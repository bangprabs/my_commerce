<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banners;
use Session;

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
}
