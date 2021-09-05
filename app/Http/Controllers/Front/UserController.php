<?php

namespace App\Http\Controllers\Front;

use Session;
use App\Cart;
use App\User;
use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
                $user->status = 0;

                $user->save();

                //Send confirmation email
                $email = $data['email'];
                $messageData = [
                            'email'=>$data['email'],
                            'name'=>$data['name'],
                            'code'=>base64_encode($data['email']),
                            'mobile'=>$data['mobile'],
                            'email'=>$data['email']
                ];
                Mail::send('emails.confirmation', $messageData, function($message) use($email){
                    $message->to($email)->subject("Confirm your account E-Commerce");
                });

                //Redirect back with success
                $message = "Please confirm your email to activate your account";
                session::flash('success_message', $message);
                return redirect()->back();

                // if (Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])) {
                //     if (!empty(Session::get('session_id'))) {
                //         $user_id = Auth::user()->id;
                //         $session_id = Session::get('sesion_id');
                //         Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                //     }

                //     $email = $data['email'];
                //     $messageData = ['name'=>$data['name'], 'mobile'=>$data['mobile'], 'email'=>$data['email']];
                //     Mail::send('emails.register', $messageData, function($message) use($email){
                //         $message->to($email)->subject('Welcome to E-Commerce Website');
                //     });

                //     return redirect('');
                // }
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

                $userStatus = User::where('email',$data['email'])->first();
                if ($userStatus->status == 0) {
                    Auth::logout();
                    $message = "Your Account is not activated yet !, Please activate your account";
                    session::flash('error_message', $message);
                    return redirect()->back();
                }

                if (!empty(Session::get('session_id'))) {
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('sesion_id');
                    Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                }
                return redirect('/cart');
            } else {
                $message = "Invalid Email and Password !";
                session::flash('error_message', $message);
                return redirect()->back();
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function confirmAccount($email ,Request $request)
    {
        //Decode the email
        $email = base64_decode($email);

        //Check user email
        $userCount = User::where('email',$email)->count();
        if ($userCount>0) {
            //logic email activated or not
            $userDetails = User::where('email',$email)->first();
            if ($userDetails->status == 1) {
                $message = "Your email already Activated, Please login !";
                session::flash('error_message', $message);
                return redirect('login-register');
            }else {
                //update status to 1
                User::where('email', $email)->update(['status'=>1]);
                $messageData = ['code'=>base64_encode($userDetails['email']),'name'=>$userDetails['name'], 'mobile'=>$userDetails['mobile'], 'email'=>$email];
                Mail::send('emails.confirmation', $messageData, function($message) use($email){
                    $message->to($email)->subject('Welcome to E-Commerce Website');
                });
                $message = "Your email has been activated, You can login now !";
                session::flash('success_message', $message);
                return redirect('login-register');
            }
        }else{
            abort(404);
        }
    }

    public function forgotPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $emailCount = User::where('email', $data['email'])->count();
            if ($emailCount == 0) {
                $message = "Email doesn't exist !";
                session::flash('error_message', $message);
                return redirect()->back();
            } else {
                $random_password = str_random(8);
                $newPassword = bcrypt($random_password);

                //Update Password
                User::where('email', $data['email'])->update(['password'=>$newPassword]);
                //get username
                $userName = User::select('name')->where('email', $data['email'])->first();
                //send forgor password email
                $email = $data['email'];
                $name = $userName->name;
                $messageData = [
                    'email' =>$email,
                    'name' =>$name,
                    'password' =>$random_password
                ];
                Mail::send('emails.forgot_password', $messageData, function($message) use($email){
                    $message->to($email)->subject("New Passoword E-Commerce Website");
                });

                //redirect to login register page
                $message = "Please check your email for new Password";
                session::flash('success_message', $message);
                return redirect('login-register');
            }
        }
        return view('front.users.forgot_password');
    }

    public function account(Request $request)
    {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id)->toArray();

        $countries = Country::where('status', 1)->get()->toArray();

        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required|numeric',
            ];
            $customeMessages = [
                'name.required' => 'Name is required',
                'mobile.required' => 'Mobile is required',
                'mobile.numeric' => 'Valid Mobile is required',
            ];
            $this->validate($request, $rules, $customeMessages);

            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->address = $data['address'];
            $user->city = $data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];
            $user->save();

            $message = "Your account details has been updated successfully !";
            session::flash('success_message', $message);
            return redirect()->back();
        }

        return view('front.users.account')->with(compact('userDetails', 'countries'));
    }

    public function userChkPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $user_id = Auth::user()->id;
            $checkPassword = User::selecT('password')->where('id',$user_id)->first();
            if (Hash::check($data['current_pwd'], $checkPassword->password)) {
                return "true";
            } else {
                return "false";
            }
        }
    }

    public function updateUserPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $user_id = Auth::user()->id;
            $checkPassword = User::selecT('password')->where('id',$user_id)->first();
            if (Hash::check($data['current_pwd'], $checkPassword->password)) {
                //Update current password
                $newPassword = bcrypt($data['new_password']);
                User::where('id',$user_id)->update(['password'=>$newPassword]);
                $message = "Your password has been updated successfully !";
                session::flash('success_message', $message);
                return redirect()->back();
            } else {
                $message = "Current password is incorrect !";
                session::flash('error_message', $message);
                return redirect()->back();
            }
        }
    }
}
