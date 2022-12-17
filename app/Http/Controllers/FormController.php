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
        // TODO: give the form data for the user to the form.index page (id, urlToken, maxAnswers, timeOpened, timeClosed, timestamps)
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
        // http://127.0.0.1:8000/form/$urlToken
        // TODO: password implementatie

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
        $response = [
            "result"=>"no data sent"
        ];
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
        // $id = the id of the form to be edited
        // TODO: give the form data depending on {id} in the url to edit (all data)
        // TODO: make sure the form belongs to the current user
        return view("form.edit");
    }
}
