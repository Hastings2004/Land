<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    
    public function registerUser(Request $request) {
        //validate the request
        //username, email, phone_number, password
       $fields = $request->validate([
                'username' =>['required','max:50'], 
                'email' => [
                    'required',
                    'max:50',
                    'email',
                    'unique:users',
                    'regex:/^[\w\.-]+@[\w\.-]+\.\w{2,}$/'
                ],
                'phone_number' => ['required','max:12'],
                'password' => [
                    'required',
                    'min:4',
                    'confirmed',
                    'regex:/^(?=(?:.*[A-Za-z]){2,})(?=(?:.*\d){2,}).{4,}$/'
                ],
            ],
            [
                'password.regex' => 'Password must be at least 4 characters long and contain at least 2 letters and 2 numbers.'
        ]); 

       //register the user
        $user = User::create($fields);

      //login 
        Auth::login($user);

       //redirect to home page
        return redirect()->route('dashboard')->with('success', 'You have successfully signed up '); 

      
 }
  public function loginUser(Request $request){
        $fields = $request ->validate([
            'email' =>['required','max:50', 'email'],
            'password'=> ['required']
            ]); 

            //Try to login
            if(Auth::attempt($fields, $request ->remember)){
                return redirect()->intended('/dashboard')->with('success', 'You are logged in successfully');
            }else{
                return back()->withErrors([
                    'failed' => 'The credentials do not match with our records'
                ]);
                
        }
   
}
//logout function
public function logoutUser(Request $request){
            //logout user
            Auth::logout();
            //end the session
            $request -> session() ->invalidate();

            //regenerate CSRF token
            $request -> session()->regenerateToken();

            //redirect to the home page
            return redirect()->route('login')->with('success', 'You are logged out successfully');

}


}
