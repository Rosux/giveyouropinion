<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Form;
use App\Models\Answer;
use Ramsey\Uuid\Uuid;

class FormController extends Controller
{
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

        $formData = $request->validate([
            'questions' => ['required'],
            // 'timeOpened' => ['date_format:Y-m-d H:i:s", "after:start_time'],
            // 'timeClosed' => ['date_format:Y-m-d H:i:s", "after:start_time'],
            'maxAnswers' => ['integer', 'gt:0']
        ]);
        
        // user_id
        $formData["userId"] = Auth::user()->id;
        // urlToken
        $formData["urlToken"] = Uuid::uuid4();
        // password
        $request->has("password") ? $formData["password"] = Str::random(30) : $formData["password"] = false;
        // maxAnswers
        $request->has("maxAnswers") ? $formData["maxAnswers"] = (int)$request->input('maxAnswers') : $formData["maxAnswers"] = null;
        // timeOpened
        $request->has("timeOpened") ? $formData["timeOpened"] = $request->input('timeOpened') : $formData["timeOpened"] = null;
        // timeClosed
        $request->has("timeClosed") ? $formData["timeClosed"] = $request->input('timeClosed') : $formData["timeClosed"] = null;
        

        // question
        // $formData['questions'] = TOEKOMSTIGE DATA];
        $Q = json_decode($request->input('questions'), true);
        // structure example
        // $questions = [
        //     "title"=>"FORM TITLE",
        //     "headerimg"=>"../blabla",
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
        //                 "choice 1",
        //                 "choice 2",
        //                 "choice 3"
        //             ]
        //         ]
        //     ]
        // ];

        // questions must be built from here, we only take the value and coresponding question type to validate it
        // $questions = $request->input('question.0.question');
        

        return $formData;


        




        $response = ["result"=>"no data sent"];
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
