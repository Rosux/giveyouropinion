<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * returns a page for admins to see all forms
     */
    public function index()
    {
        // http://127.0.0.1:8000/form/
        // TODO: give the form data for the user to the form.index page (id, urlToken, maxAnswers, timeOpened, timeClosed, timestamps)
        return view("form.index");
    }

    // displays a form based on url form token (urlToken) to all users (id, user_id.data, questions, timeOpened, timeClosed, timestamps)
    public function getForm($urlToken)
    {
        // http://127.0.0.1:8000/form/$urlToken
        // $urlToken = the token of the form to be displayed/sent (check and validate the token, all tokens are unique)
        // TODO: give the form data depending on {urlToken} in the url
        return view("form.form");
    }



    /**
     * handle user question input
     * users POST requests for answers end up here
     */
    public function postForm(Request $request)
    {
        // ID = $request["id"]
        // TODO: handle a post request of answers from anon's
    }

    /**
     * handles a POST form request (creates a form in db)
     */
    public function createFormPost(Request $request)
    {
        // ID = $request["id"]
        // TODO: handle a post request from admins/users that create a new form
    }

    /**
     * handles a edit POST request based on post id stuff/data
     */
    public function editFormPost(Request $request)
    {
        // ID = $request["id"]
        // TODO: handle a POST request where the user/admin edits their form
        // TODO: make sure the form belongs to the current user
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
