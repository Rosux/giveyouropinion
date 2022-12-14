<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * registers the user
     * good luck rik :)
     */
    public function register(Request $request)
    {
        // Validate FormFields
        $formFields = $request->validate([
            'email' => ['required', 'email', Rule::unique('user', 'email')],
            'password' => ['required', 'min:5'],
            'username' => ['required', 'min:3']
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        // Create User
        $user = User::create([
            'email' => $formFields['email'],
            'password' => $formFields['password'],
            'username' => $formFields['username']
        ]);

        // Authentication add login statement
        auth()->login($user);

        // Redirect to Home-Page
        return redirect('/form/')->with('message', 'Welcome ' . $formFields['username']);

    }

    /**
     * authenticates the user
     * good luck rik :)
     */
    public function login(Request $request)
    {
        // Validate Formfields
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // Authenticate
        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You are now logged in!');
            
        }
// 
        return back()->withErrors(['email' => 'Invalid Credentials'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'You have been logged out!');
    }
}
