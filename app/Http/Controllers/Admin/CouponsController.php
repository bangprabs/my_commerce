<?php

namespace App\Http\Controllers\Admin;

use Session;
use App\User;
use App\Coupon;
use App\Section;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CouponsController extends Controller
{
    public function coupons()
    {
        $coupons = Coupon::get()->toArray();
        // dd($coupons); die;
        return view('admin.coupons.coupons')->with(compact('coupons'));
    }

    public function updateCouponStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Coupon::where('id', $data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'coupon_id'=>$data['coupon_id']]);
        }
    }

    public function addEditCoupon(Request $request, $id = null)
    {
        if ($id == "") {
            //Add Coupon
            $coupon = new Coupon;
            $selCats = array();
            $selUsers = array();
            $title = "Add Coupon";
            $message = "Coupon added successfully !";
        } else {
            // Edit/Update Coupon
            $coupon = Coupon::find($id);
            $selCats = explode(', ', $coupon['categories']);
            $selUsers = explode(', ', $coupon['users']);
            $title = "Edit Coupon";
            $message = "Coupon updated successfully !";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();

             //Coupon Valdation
             $rules = [
                'categories' => 'required',
                'coupon_option' => 'required',
                'coupon_type' => 'required',
                'amount_type' => 'required',
                'amount' => 'required|numeric',
                'expiry_date' => 'required',
            ];
            $customeMessages = [
                'categories.required' => 'Select Categories',
                'coupon_option.required' => 'Select Coupon Option',
                'coupon_type.required' => 'Select Coupon Type',
                'amount_type.required' => 'Selec Amount Type',
                'amount.required' => 'Input the amount',
                'amount.numeric' => 'Input the valid amount',
                'expiry_date.required' => 'Input the expiry date',
            ];
            $this->validate($request, $rules, $customeMessages);


            if (isset($data['users'])) {
                $users = implode(', ', $data['users']);
            }else{
                $users = "";
            }

            if (isset($data['categories'])) {
                $categories = implode(', ', $data['categories']);
            }
            if ($data['coupon_option'] == "Automatic") {
                $coupon_code = str_random(8);
            }else {
                if(empty($data['coupon_code'])){
                    $message = "Please enter Coupon Code is missing!";
                    session::flash('error_message',$message);
                    return redirect('admin/coupons');
                }
                $coupon_code = $data['coupon_code'];
            }

            $coupon->coupon_option = $data['coupon_option'];
            $coupon->coupon_code = $coupon_code;
            $coupon->categories = $categories;
            $coupon->users = $users;
            $coupon->coupon_type = $data['coupon_type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->amount = $data['amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->status = 1;
            $coupon->save();

            session::flash('success_message', $message);
            return redirect('admin/coupons');

        }

        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);

        $users = User::select('email')->where('status', 1)->get()->toArray();

        return view('admin.coupons.add_edit_coupon')->with(compact('title', 'coupon', 'categories', 'users', 'selCats', 'selUsers'));
    }

    public function deleteCoupon($id)
    {
        Coupon::where('id', $id)->delete();
        $message = 'Coupon has been Deleted Successfully !';
        session::flash('success_message', $message);
        return redirect()->back();
    }

}
