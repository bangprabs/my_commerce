<?php

namespace App\Http\Controllers\Admin;

use App\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Hash;
use Image;

class AdminController extends Controller
{
    public function dashboard(Request $request) {
        $request->session()->put('page', 'dashboard');
        return view('admin.admin_dashboard');
    }

    public function settings() {
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings')->with(compact('adminDetails'));
    }

    public function login(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password'=> $data['password']])) {
                return redirect('admin/dashboard');
            } else {
                $value = "Invalid Email or Password";
                Session::flash('error_message', $value);
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function chkCurrentPassword(Request $request){
        $data = $request->all();
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            echo "true";
        } else {
            echo "false";
        }
    }

    public function updateCurrentPassword(Request $request) {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
                if ($data['new_pwd'] == $data ['confirm_pwd']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
                    Session::flash('success_message', 'Password has been updated successfully !');
                } else {
                    Session::flash('error_message', 'Your new password and Confirm Password doesn\'t match');
                }
            } else {
                Session::flash('error_message', 'Your current password is incorrect');
                return redirect()->back();
            }
            return redirect()->back();
        }
    }

    public function updateAdminDetails(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'mimes:jpeg,jpg,png,gif|required|max:100000'
            ];
            $customeMessages = [
                'admin_name.required' => 'Name is required',
                'admin.regex' => 'Valid name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid Mobile is required',
                'admin_image.mimes' => 'Valid Image is required'
            ];
            $this->validate($request, $rules, $customeMessages);

            // Update image
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                    if ($image_tmp->isValid()) {
                        // Get Image Extension
                        $extension = $image_tmp->getClientOriginalExtension();
                        // Generate New Image Name
                        $imageName = rand(111,9999).'.'.$extension;
                        $imagePath = 'images/admin_images/admin_photos/'.$imageName;
                        // Upload the images
                        Image::make($image_tmp)->resize(400,400)->save($imagePath);
                    } else if (!empty($data['current_admin_image'])){
                        $imageName = $data['current_admin_image'];
                    } else {
                        $imageName = "";
                    }
            }

            // Update admin details
            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'], 'mobile'=>$data['admin_mobile'], 'image'=>$imageName]);
            Session::flash('success_message', 'Admin Detail has been updated successfully !');
            return redirect()->back();

        }
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.update_admin_details')->with(compact('adminDetails'));
    }
}
