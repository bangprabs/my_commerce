<?php

namespace App\Http\Controllers\Front;

use Session;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
                    // echo "<pre>"; print_r(Auth::user()); die;
                    return redirect('');
                }
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
