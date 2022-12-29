<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Form;
use App\Models\Answer;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

class FormController extends Controller
{
    private $maxQuestions = 255;
    /**
     * returns a page for admins to see all forms
     */
    public function index()
    {
        // http://127.0.0.1:8000/form/
        if(Form::where('user_id', Auth::user()->id)->get()->count() <= 0){
            // question doesnt even exist
            return view("form.index");
        }
        $forms = Form::where('user_id', Auth::user()->id)->get();
        return view("form.index")->with(["forms" => $forms]);
    }

    /**
     * returns answers given to a question based on urlToken
     */
    public function answersIndex($urlToken){
        // http://127.0.0.1:8000/form/answers/{urlToken}
        
        // if form is not found redirect otherwise set form data to $formID
        if(Form::where('urlToken', $urlToken)->get()->count() <= 0){
            // question doesnt even exist
            return redirect('form/');
        }
        $formID = Form::where('urlToken', $urlToken)->get()->first()['id'];

        // send questions (can be empty array) to form.answers
        if(Answer::where('question_id', $formID)->get()->count() <= 0){
            // question doesnt even exist
            return view("form.answers");
        }
        $answers = Answer::where('question_id', $formID)->get();
        
        return view("form.answers")->with(["answers"=>$answers]);
    }

    /**
     * returns a form page with the form if password is set correctly or doesnt exists (and of course the form has to exist)
     * displays a form based on url form token (urlToken) to all users
     */
    public function getForm($urlToken, $password="")
    {
        // http://127.0.0.1:8000/form/$urlToken/$Password

        if(Form::where('urlToken', $urlToken)->get()->count() <= 0){
            // no form found so give error message
            return view("form.form")->with(["error" => "No Form Found!"]);
        }
        $form = Form::where('urlToken', $urlToken)->get()->first();

        // check for password if it exists or if its set correctly
        if($form["password"] === null || $form["password"] == $password){
            return view("form.form")->with(["form" => $form]);
        }else{
            return view("form.form")->with(["error" => "Password Incorrect!"]);
        }
    }







    /**
     * handle user question input
     * users POST requests for answers end up here
     */
    public function postForm(Request $request)
    {
        // ID = $request["id"]
        // TODO: handle a post request of answers from anon's
        $response = [
            "result"=>"no data sent"
        ];
        return response($response, 200)->header('Content-Type', 'application/json');
    }

    /**
     * handles a POST form request (creates a form in db)
     */
    public function createFormPost(Request $request)
    {
        // ID = $request["id"]
        // TODO: handle a post request from admins/users that create a new form
        // TODO validate the questions
        
        // https://laravel.com/docs/5.1/requests#accessing-the-request

        // TODO: if validator fails send JSON data back not a whole page
        $formData = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'questions' => ['required', 'json'],
            // 'questions.*.question_title' => ['string', 'min:3', 'max:255', 'required'],
            // 'questions.*.type' => ['integer', 'min:1', 'max:3', 'required'],
            // 'questions.*.placeholder' => ['string', 'min:3', 'max:255'],
            // 'questions.*.choices' => ['array', 'min:1'],
            'maxAnswers' => ['nullable', 'integer', 'gt:0']
        ]);
        
        // user_id
        $formData["userId"] = Auth::user()->id;
        // urlToken
        $formData["urlToken"] = Uuid::uuid4();
        // password
        $request->has("password") ? $formData["password"] = Str::random(30) : $formData["password"] = null;
        // maxAnswers
        ($request->has("maxAnswers") && $request->input("maxAnswers") > 0) ? $formData["maxAnswers"] = (int)$request->input('maxAnswers') : $formData["maxAnswers"] = null;
        // timeOpened
        if($request->has("timeOpened")){
            $timeOpened = new Carbon($request->input("timeOpened"));
            if($timeOpened->format('Y-m-d H:i:s') > Carbon::now()->format('Y-m-d H:i:s')){
                // if timeOpened is set AND timeOpened is later than now
                $formData["timeOpened"] = $timeOpened->toDateTimeString();
            }else{
                $formData["timeOpened"] = Carbon::now()->toDateTimeString();
            }
        }else{
            $formData["timeOpened"] = Carbon::now()->toDateTimeString();
        }
        // timeClosed
        if($request->has("timeClosed")){
            $timeClosed = new Carbon($request->input("timeClosed"));
            if($timeClosed->format('Y-m-d H:i:s') > Carbon::now()->format('Y-m-d H:i:s')){
                // if timeClosed is set AND timeClosed is later than now
                $formData["timeClosed"] = $timeClosed->toDateTimeString();
            }else{
                $formData["timeClosed"] = null;
            }
        }else{
            $formData["timeClosed"] = null;
        }
        


        $Q = [
            "title"=>$request->input("title"),
            "questions"=>[]
        ];

        $RQ = json_decode($request->input("questions"), true);
        if($RQ === null){
            $response = ["success"=>false,"error"=>"Data error."];
            return $response;
        }
        if(count($RQ) < 1){
            // return error not enough questions given
            $response = ["success"=>false,"error"=>"Can't have 0 questions."];
            return $response;
        }elseif(count($RQ) > $this->maxQuestions){
            // return error too many questions given
            $response = ["success"=>false,"error"=>"Can't have more than "+$this->maxQuestions+" questions."];
            return $response;
        }
        for($i = 0;$i<count($RQ);$i++){
            // TODO validate stuff here
            $row = [
                "question_title"=>$RQ[$i]["question_title"],
                "type"=>$RQ[$i]["type"]
            ];
            if($row["type"] == 1){
                // text input
                $row["placeholder"] = $RQ[$i]["placeholder"];
            }elseif($row["type"] == 2 || $row["type"] == 3){
                // checkboxes/radio buttons
                $row["choices"] = [];
                for($j=0;$j<count($RQ[$i]["choices"]);$j++){
                    array_push($row["choices"], $RQ[$i]["choices"][$j]);
                }
            }else{
                // wrong type
                continue;
            }
            array_push($Q["questions"], $row);
        }
        $formData["questions"] = $Q;
        return $Q;



        // question
        // $formData['questions'] = TOEKOMSTIGE DATA];
        // structure example
        // $formData["questions"] = json_encode([
        //     "title"=>"FORM TITLE",
        //     "questions"=>[
        //         [
        //             "question_title"=>"QuestionTitle1",
        //             "type"=>1,
        //             "placeholder"=>"placeholder1"
        //         ],
        //         [
        //             "question_title"=>"QuestionTitle2",
        //             "type"=>2,
        //             "choices"=>[
        //                 0=>"checkbox text 1",
        //                 1=>"checkbox text 2",
        //                 2=>"checkbox text 3"
        //             ]
        //         ],
        //         [
        //             "question_title"=>"QuestionTitle3",
        //             "type"=>3,
        //             "choices"=>[
        //                 0=>"choice 1",
        //                 1=>"choice 2",
        //                 2=>"choice 3"
        //             ]
        //         ]
        //     ]
        // ]);
        
        
        $form = Form::create([
            'user_id' => $formData['userId'],
            'urlToken' => $formData['urlToken'],
            'questions' => json_encode($formData['questions'], true),
            'password' => $formData['password'],
            'maxAnswers' => $formData['maxAnswers'],
            'timeOpened' => $formData['timeOpened'],
            'timeClosed' => $formData['timeClosed'],
        ]);
        

        return $formData;

        // insert into db all is good $fornData
        




        $response = ["success"=>false,"error"=>"no data sent"];
        return response($response, 200)->header('Content-Type', 'application/json');
    }

    /**
     * handles a edit POST request based on post id stuff/data
     */
    public function editFormPost(Request $request)
    {
        // ID = $request["id"]
        // TODO: handle a POST request where the user/admin edits their form
        // TODO: make sure the form belongs to the current user
        $response = [
            "result"=>"no data sent"
        ];
        return response($response, 200)->header('Content-Type', 'application/json');
    }







    /**
     * return the form edit page based on url id
     */
    public function editFormGet($id)
    {
        // http://127.0.0.1:8000/form/edit/$id

        $form = Form::where('id', $id)->where('user_id', Auth::user()->id)->get()->first();

        if(Form::where('id', $id)->where('user_id', Auth::user()->id)->get()->count() <= 0){
            // question doesnt even exist
            return redirect("/form");
        }
        
        return view("form.edit")->with(["form"=>$form]);
    }
}
