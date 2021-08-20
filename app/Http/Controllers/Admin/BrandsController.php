<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brands;
use Session;

class BrandsController extends Controller
{
    public function brands()
    {
        $brands = Brands::get();
        return view('admin.brands.brands')->with(compact('brands'));
    }

    public function updateBrandsStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Brands::where('id', $data['brand_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'brand_id'=>$data['brand_id']]);
        }
    }

    public function addEditBrand(Request $request, $id = null)
    {
        if ($id == "") {
            $title = "Add Brands";
            $brand = new Brands;
            $brands = Brands::get();
            $message = "Brand Added Successfully !";
        } else {
            $title = "Edit Brand";
            $brand = Brands::find($id);
            $brands = Brands::get();
            $message = "Brand has been Edited Successfully !";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // Brand Valdation
            $rules = [
                'brand_name' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customeMessages = [
                'brand_name.required' => 'Brand Name is required',
                'brand_name.regex' => 'Valid Brand Name is required',
            ];
            $this->validate($request, $rules, $customeMessages);
            $brand->name = $data['brand_name'];
            $brand->status = 1;
            $brand->save();
            session::flash('success_message', $message);
            return redirect ('admin/brands');

        }
        return view('admin.brands.add_edit_brand')->with(compact('title', 'brand', 'brands'));
    }

    public function deleteBrand($id)
    {
        Brands::where('id', $id)->delete();
        $message = 'Brand has been Deleted Successfully !';
        session::flash('success_message', $message);
        return redirect()->back();
    }

}
