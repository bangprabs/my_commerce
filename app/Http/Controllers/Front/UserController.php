<?php

namespace App\Http\Controllers\Front;

use Session;
use App\Cart;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function loginRegister()
    {
        return view('front.users.login_register');
    }

    public function registerUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            //Check already user exist
            $userCount = User::where('email', $data['email'])->count();
            if ($userCount>0) {
                $message = "Email already Exist !";
                session::flash('error_message', $message);
                return redirect()->back();
            } else {
                //Insert the user
                $user = new User();
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 1;

                $user->save();
                if (Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])) {
                    if (!empty(Session::get('session_id'))) {
                        $user_id = Auth::user()->id;
                        $session_id = Session::get('sesion_id');
                        Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                    }

                    $email = $data['email'];
                    $messageData = ['name'=>$data['name'], 'mobile'=>$data['mobile'], 'email'=>$data['email']];
                    Mail::send('emails.register', $messageData, function($message) use($email){
                        $message->to($email)->subject('Welcome to E-Commerce Website');
                    });

                    return redirect('');
                }
            }
        }
    }

    public function checkEmail(Request $request)
    {
        $data = $request->all();
        $emailCount = User::where('email', $data['email'])->count();
        if ($emailCount>0) {
            return "false";
        } else {
            return "true";
            die;
        }
    }

    public function loginUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // dd($data); die;
            if (Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])) {
                if (!empty(Session::get('session_id'))) {
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('sesion_id');
                    Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                }
                return redirect('/cart');
            } else {
                $message = "Invalid Email and Password !";
                session::flash('error_message_login', $message);
                return redirect()->back();
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
