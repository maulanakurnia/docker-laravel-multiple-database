<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Hash;
use Session;
use App\Models\User;

class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) { 
            return redirect()->route('tasks.index');
        }
        return view('pages.signin');
    }
  
    public function login(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required|string'
        ];
  
        $messages = [
            'email.required'        => 'Email is required',
            'email.email'           => 'Not a valid email address',
            'password.required'     => 'Password is required',
            'password.string'       => 'Password must be string'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];
  
        Auth::attempt($data);
  
        if (Auth::check()) {
            return redirect()->route('tasks.index');
  
        } else {
            Session::flash('error', 'The email or password is incorrect');
            return redirect()->route('login');
        }
  
    }
  
    public function showFormRegister()
    {
        return view('pages.signup');
    }
  
    public function register(Request $request)
    {
        $rules = [
            'name'                  => 'required|min:3|max:35',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|confirmed'
        ];
  
        $messages = [
            'name.required'         => 'Name is required',
            'name.min'              => 'Nama lengkap minimal 3 karakter',
            'name.max'              => 'Nama lengkap maksimal 35 karakter',
            'email.required'        => 'Email is required',
            'email.email'           => 'Not a valid email address',
            'email.unique'          => 'Email has been registered',
            'password.required'     => 'Password is required',
            'password.confirmed'    => 'Password confirmation does not match'
        ];
  
        $validator = Validator::make($request->all(), $rules, $messages);
  
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }
  
        $user = new User;
        $user->name = ucwords(strtolower($request->name));
        $user->email = strtolower($request->email);
        $user->password = Hash::make($request->password);
        $save = $user->save();
  
        if($save){
            Session::flash('success', 'Register successful! Please login to access data');
            return redirect()->route('login');
        } else {
            Session::flash('errors', ['' => 'Registration failed! Please repeat in a moment']);
            return redirect()->route('pages.signup');
        }
    }
  
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
  
}
