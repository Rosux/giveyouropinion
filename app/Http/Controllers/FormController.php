<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Form;
use App\Models\Answer;

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

        return false;

        // TODO create UUID token (https://github.com/ramsey/uuid) need to install this for later
        // also find out a way to store the questions consistently
        // also find a way to structure the questions so it can also be validated
        // ex:
        // [
        //     ["question_title"=>"Q_TITLE", "question_type"=>1, "question_image"=>"blabla.png"],
        //     ["question_title"=>"Q_TITLE2", "question_type"=>3, "question_image"=>"blabla2.png"]
        // ]

        // $form = Form::create([
        //     'user_id' => Auth::user()->id,
        //     'urlToken' => $formFields['username'],
        //     'questions' => $request['username'] // not safe
        // ]);


        // user_id must be sent
        $userId = $request->input('userId');
        
        // urltoken gets generated with UUID thing
        
        // questions must be built from here, we only take the value and coresponding question type to validate it
        $questions = $request->input('question.0.question');
        
        // password can only be true/false so we can generate the password/token
        $password = $request->input('password', false);

        // max answers cant be above integer limit
        $maxAnswers = $request->input('maxAnswers', null);

        // timeOpened cant be earlier than right now (creation time)
        $timeOpened = $request->input('timeOpened', null);

        // timeClosed cant be in the past based on creation time
        $timeClosed = $request->input('timeClosed', null);





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
