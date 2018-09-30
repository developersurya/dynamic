<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;

class SigninController extends Controller {

		function index(){
			return view('login-form');
		}

		function checklogin( Request $request ){
			$this->validate($request, [
			'email' => 'required|email',
			'password' => 'required|alphaNum|min:3'
			]);
			$user_data = array(
				'email' => $request->get('email'),
				'password' => $request->get('password'),
			);
			//print_r($user_data);die();
			if(Auth::attempt($user_data)){
				return view('home');
			}else{
				return back()->with('error', 'Wrong Login Details');
			}
		}

		function successlogin(){
			return view('successlogin');
		}
		function logout(){
			Auth::logout();
			return redirect('home');
		}
	}