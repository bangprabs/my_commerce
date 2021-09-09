<?php

namespace App\Http\Controllers\Admin;

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

    public function addEditCoupon($id = null)
    {
        if ($id == "") {
            //Add Coupon
            $coupon = new Coupon;
            $title = "Add Coupon";
        } else {
            // Edit/Update Coupon
            $coupon = Coupon::find($id);
            $title = "Edit Coupon";
        }
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);

        $users = User::select('email')->where('status', 1)->get()->toArray();

        return view('admin.coupons.add_edit_coupon')->with(compact('title', 'coupon', 'categories', 'users'));
    }
}
