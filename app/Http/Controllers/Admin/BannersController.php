<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banners;
use Session;
use Image;

class BannersController extends Controller
{
    public function banners()
    {
        $banners = Banners::get()->toArray();
        return view('admin.banners.banners')->with(compact('banners'));
    }

    public function updateBannerStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Banners::where('id', $data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'banner_id'=>$data['banner_id']]);
        }
    }

    public function deleteBanner($id)
    {
        //Get Banner Image
        $bannerImage = Banners::where('id', $id)->first();

        //Get Banner Image Path
        $banner_image_path = 'images/banner_images/';

        //Delete Banner Image if exists in Banners Folder
        if (file_exists($banner_image_path.$bannerImage->image)) {
            unlink($banner_image_path.$bannerImage->image);
        }

        //Delete Banner from DB
        Banners::where('id', $id)->delete();
        $message = 'Brand has been Deleted Successfully !';
        session::flash('success_message', $message);
        return redirect()->back();
    }

    public function addEditBanner($id = null, Request $request)
    {
        if ($id == "") {
            $bannerdata = new Banners;
            $title = "Add Banner Image";
            $message = 'Brand has been Added Successfully !';
        } else {
            $bannerdata = Banners::find($id);
            $title = "Edit Banner Image";
            $message = 'Brand has been Updated Successfully !';
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            $bannerdata->link = $data['link'];
            $bannerdata->title = $data['title'];
            $bannerdata->alt = $data['alt'];

             // Upload banner image
             if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    // Get Original Name
                    $image_name = $image_tmp->getClientOriginalName();
                    // Get Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate Random Name
                    $imageName = $image_name.'-'.rand(111,99999).'.'.$extension;
                    // Set Path Image
                    $banner_image_path = 'images/banner_images/'.$imageName;
                    // Upload image then resized it
                    Image::make($image_tmp)->resize(1170,480)->save($banner_image_path);
                    // Insert image name to table
                    $bannerdata->image = $imageName;
                }
            }

            $bannerdata->save();
            session::flash('success_message', $message);
            return redirect('admin/banners');
        }

        return view('admin.banners.add_edit_banner')->with(compact('title', 'bannerdata'));
    }
}
