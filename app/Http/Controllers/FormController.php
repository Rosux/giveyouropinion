<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Form;
use App\Models\Answer;
use Ramsey\Uuid\Uuid;
use Carbon\Carbon;

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
        // validate/create title/maxAnswers/userId/urlToken/password/maxAnswers/timeOpened/timeClosed
        $formData = Validator::make($request->all(), [
            'title' => 'required|string|min:3|max:255',
            'maxAnswers' => 'nullable|integer|gt:0',
            'timeZone' => 'required|timezone',
            'timeOpened' => 'nullable|date',
            'timeClosed' => 'nullable|date',
        ]);
        // if validator fails return error
        if($formData->fails()){
            return ["success"=>false,"error"=>$formData->errors()];
        }
        // transform $formData object into array
        $formData = $request->all();
        // user_id
        $formData["userId"] = Auth::user()->id;
        // urlToken
        $formData["urlToken"] = Uuid::uuid4();
        // password
        $request->has("password") ? $formData["password"] = Str::random(30) : $formData["password"] = null;
        // maxAnswers
        ($request->has("maxAnswers") && $request->input("maxAnswers") > 0) ? $formData["maxAnswers"] = (int)$request->input('maxAnswers') : $formData["maxAnswers"] = null;
        // YYYY-MM-DD HH:MM:SS+HH:M
        $userTimeZone = $request->input("timeZone");
        // timezone & timeOpened
        if($request->has('timeOpened')){
            // convert usertime to current server time
            $userDateOpenTime = new Carbon($formData['timeOpened'], $userTimeZone);
            if($userDateOpenTime->format('Y-m-d H:i:s') > Carbon::now($userTimeZone)->format('Y-m-d H:i:s')){
                // if time is greater than now set timeOpened to user time converted to server time
                $formData["timeOpened"] = $userDateOpenTime->format('Y-m-d H:i:sO');
            }else{
                // set timeOpened to current servertime
                $formData["timeOpened"] = Carbon::now($userTimeZone)->format('Y-m-d H:i:sO');
            }
        }else{
            // set timeOpened to current servertime
            $formData["timeOpened"] = Carbon::now($userTimeZone)->format('Y-m-d H:i:sO');
        }
        // timezone & timeClosed
        if($request->has('timeClosed')){
            // convert usertime to current server time
            $userDateCloseTime = new Carbon($formData['timeClosed'], $userTimeZone);
            if($userDateCloseTime->format('Y-m-d H:i:s') > Carbon::now($userTimeZone)->format('Y-m-d H:i:s')){
                // if time is greater than now set timeClosed to user time converted to server time
                $formData["timeClosed"] = $userDateCloseTime->format('Y-m-d H:i:sO');
            }else{
                $formData["timeClosed"] = null;
            }
        }else{
            $formData["timeClosed"] = null;
        }
        // validate questions array json stuff
        $requestData = request()->all();
        $questions = json_decode($requestData['questions'], true);
        // thank you chatgpt for saving me
        $validator = Validator::make(['questions' => $questions], [
            'questions' => 'required|array|min:1|max:255',
            'questions.*' => 'required|array',
            'questions.*.question_title' => 'required|string|max:255|min:1',
            'questions.*.type' => 'required|integer|in:1,2,3',
            'questions.*.placeholder' => 'required_if:questions.*.type,1|string|nullable|max:255|min:1',
            'questions.*.choices' => 'required_if:questions.*.type,2|required_if:questions.*.type,3|array|nullable|min:1|max:25',
            'questions.*.choices.*' => 'required_if:questions.*.type,2|required_if:questions.*.type,3|string|max:255|min:1',
        ]);
        if ($validator->fails()) {
            // validation failed
            return ["success"=>false,"error"=>$validator->errors()];
        }
        // instantiate array
        $Q = [
            "title"=>$request->input("title"),
            "questions"=>[]
        ];
        // put stuff in array
        for($i=0;$i<count($questions);$i++){
            $row = [
                "question_title"=>$questions[$i]["question_title"],
                "type"=>$questions[$i]["type"]
            ];
            if($row["type"] == 1){
                // text input
                $row["placeholder"] = $questions[$i]["placeholder"];
            }elseif($row["type"] == 2 || $row["type"] == 3){
                // checkboxes/radio buttons
                $row["choices"] = [];
                for($j=0;$j<count($questions[$i]["choices"]);$j++){
                    array_push($row["choices"], $questions[$i]["choices"][$j]);
                }
            }else{
                // wrong type
                continue;
            }
            array_push($Q["questions"], $row);
        }
        $formData["questions"] = $Q;
        // save to db
        $form = Form::create([
            'user_id' => $formData['userId'],
            'urlToken' => $formData['urlToken'],
            'questions' => json_encode($formData['questions'], true),
            'password' => $formData['password'],
            'maxAnswers' => $formData['maxAnswers'],
            'timeOpened' => $formData['timeOpened'],
            'timeClosed' => $formData['timeClosed'],
        ]);
        if($form->exists()){
            return ["success"=>true];
        }else{
            return ["success"=>false,"error"=>"Couldn't save data"];
        }
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
     * handles the deletion of forms
     */
    public function deleteFormPost(Request $request){
        // check for input id as integer
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',
        ]);
        if($validator->fails()){
            return ["success"=>false,"error"=>$validator->errors()];
        }
        $id = $request->input('id');
        // delete form
        $row = Form::where('id', $id)->where('user_id', Auth::user()->id)->delete();
        // check if form was deleted
        if($row>0){
            return ["success"=>true];
        }else{
            return ["success"=>false,"error"=>"Couldn't delete row."];
        }
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
