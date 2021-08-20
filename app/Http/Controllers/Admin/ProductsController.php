<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Session;
use App\Section;
use App\Category;
use Image;
use App\ProductsAttribute;
use App\ProductsImages;
use App\Brands;

class ProductsController extends Controller
{
    public function products()
    {
        $products = Product::with(['category'=>function($query){
            $query->select('id', 'category_name');
        } ,'section'=>function($query){
            $query->select('id', 'name');
        }])->get();
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'product_id'=>$data['product_id']]);
        }
    }

    public function deleteProduct($id)
    {
        Product::where('id', $id)->delete();
        $message = 'Product has been Deleted Successfully !';
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function addEditProduct(Request $request, $id = null)
    {
        if ($id == "") {
            $title = "Add Product";
            $product = new Product;
            $productdata = array();
            $message = "Product Added Successfully !";
        } else {
            $title = "Edit Products";
            $productdata = Product::find($id);
            $product = Product::find($id);
            $message = "Product has been Edited Successfully !";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

             // Product Valdation
             $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u'
            ];
            $customeMessages = [
                'category_id.required' => 'Category ID is required',
                'product_name.required' => 'Product Name is required',
                'product_name.regex' => 'Valid Product Name is required',
                'product_code.required' => 'Product Code is required',
                'product_code.regex' => 'Valid Product Code is required',
                'product_price.required' => 'Product Price is required',
                'product_price.regex' => 'Valid Product Price is required',
                'product_color.required' => 'Product Color is required',
                'product_color.regex' => 'Valid Product Color is required',
            ];
            $this->validate($request, $rules, $customeMessages);


            // Upload product image
            if ($request->hasFile('main_image')) {
                $image_tmp = $request->file('main_image');
                if ($image_tmp->isValid()) {
                    // Get Original Name
                    $image_name = $image_tmp->getClientOriginalName();
                    // Get Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate Random Name
                    $imageName = $image_name.'-'.rand(111,99999).'.'.$extension;
                    // Set Path Image
                    $large_image_path = 'images/product_images/large/'.$imageName;
                    $medium_image_path = 'images/product_images/medium/'.$imageName;
                    $small_image_path = 'images/product_images/small/'.$imageName;
                    // Upload origninal image (size big)
                    Image::make($image_tmp)->save($large_image_path);
                    // Upload image then resized it
                    Image::make($image_tmp)->resize(520,600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                    // Insert image name to table
                    $product->main_image = $imageName;
                }
            }

            // Upload Product Video
            if ($request->hasFile('product_video')) {
                $video_temp = $request->file('product_video');
                if ($video_temp->isValid()) {
                    // Upload video
                    $video_name = $video_temp->getClientOriginalName();
                    $extension = $video_temp->getClientOriginalExtension();
                    $videoName = $video_name.'-'.rand().'.'.$video_name;
                    $video_path = 'videos/products_videos/';
                    $video_temp->move($video_path, $videoName);
                    // Save video in table
                    $product->product_video = $video_name;
                }
            }

            // Find Data From ID
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->brand_id = $data['brand_id'];
            $product->category_id = $data['category_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_price = $data['product_price'];
            $product->product_color = $data['product_color'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['category_id'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occassion = $data['occassion'];
            $product->meta_title = $data['meta_title'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->meta_description = $data['meta_description'];
            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }
            $product->status = 1;
            $product->save();
            session::flash('success_message', $message);
            return redirect('admin/products');
        }

        // Products Filters
        $productFilters = Product::productFilters();
        $fabricArray = $productFilters['fabricArray'];
        $sleeveArray = $productFilters['sleeveArray'];
        $patternArray = $productFilters['patternArray'];
        $fitArray = $productFilters['fitArray'];
        $occasionArray = $productFilters['occasionArray'];

        // Ambil section dan kategori dan sub kategori
        $categories = Section::with('categories')->get();
        // $categories = json_decode(json_encode($categories), true);
        // echo "<pre>"; print_r($categories); die;

        $brands = Brands::where('status', 1)->get();
        $brands = json_decode(json_encode($brands), true);

        return view ('admin.products.add_edit_products')->with(compact('title', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'categories', 'productdata', 'brands'));
    }

    public function deleteProductImage($id)
    {
        // Get product image
        $productImage = Product::select('main_image')->where('id', $id)->first();

        // Get Image Path
        $smallImagePath = 'images/product_images/small/';
        $mediumImagePath = 'images/product_images/medium/';
        $largeImagePath = 'images/product_images/large/';

        // Delete Image from folder if exist in small folder
        if (file_exists($smallImagePath.$productImage->main_image)) {
            unlink($smallImagePath.$productImage->main_image);
        }

        // Delete Image from folder if exist in medium folder
        if (file_exists($mediumImagePath.$productImage->main_image)) {
            unlink($mediumImagePath.$productImage->main_image);
        }

        // Delete Image from folder if exist in large folder
        if (file_exists($largeImagePath.$productImage->main_image)) {
            unlink($largeImagePath.$productImage->main_image);
        }

        // Delete image from product table
        Product::where('id', $id)->update(['main_image'=>'']);
        $message = 'Product Image has been Deleted Successfully !';
        session::flash('success_message', $message);
        return redirect()->back();
    }

    public function deleteProductVideo($id)
    {
        // Get product image
        $productVideo = Product::select('product_video')->where('id', $id)->first();

        // Get Video Path
        $productVideoPath = 'videos/product_videos/';

        // Delete Video from folder if exist in small folder
        if (file_exists($productVideoPath.$productVideo->product_video)) {
            unlink($productVideoPath.$productVideo->product_video);
        }

        // Delete image from product table
        Product::where('id', $id)->update(['product_video'=>'']);
        $message = 'Product Videos has been Deleted Successfully !';
        session::flash('success_message', $message);
        return redirect()->back();
    }

    public function addAttributes(Request $request, $id)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {

                    //For SKU Checking
                    $attrCountSKU = ProductsAttribute::where('sku', $value)->count();
                    if ($attrCountSKU > 0) {
                        $message = "SKU Already exist, Please add another SKU !";
                        session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    //For Size if exist
                    $attrCountSize = ProductsAttribute::where(['product_id' => $id, 'size' => $data['size'][$key]])->count();
                    if ($attrCountSize > 0) {
                        $message = "Size Already exist, Please add another Size !";
                        session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            $message = "Product Attribute has been successfully added !";
            session::flash('success_message', $message);
            return redirect()->back();
        }

        $productdata = Product::select('id', 'product_name', 'product_code', 'product_color', 'main_image')->with('attributes')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        // echo "<pre>"; print_r($productdata); die;
        $title = "Product Attributes";
        return view('admin.products.add_attributes')->with(compact('productdata', 'title'));
    }

    public function editAttributes(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach ($data['attrId'] as $key => $attr) {
                if (!empty($attr)) {
                    ProductsAttribute::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);
                }
            }
        }
        $message = 'Attributes has been Edited Successfully !';
        session::flash('success_message_edit_attr', $message);
        return redirect()->back();
    }

    public function updateAttributeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsAttribute::where('id', $data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'attribute_id'=>$data['attribute_id']]);
        }
    }

    public function deleteAttributes($id)
    {
        ProductsAttribute::where('id', $id)->delete();
        $message = 'Attributes has been Deleted Successfully !';
        Session::flash('success_message_edit_attr', $message);
        return redirect()->back();
    }

    public function addImages(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                foreach ($images as $key => $image) {
                    $productImage = new ProductsImages;
                    $imageTemp = Image::make($image);
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111,999999).time().".".$extension;

                     // Set Path Image
                     $large_image_path = 'images/product_images/large/'.$imageName;
                     $medium_image_path = 'images/product_images/medium/'.$imageName;
                     $small_image_path = 'images/product_images/small/'.$imageName;
                     // Upload origninal image (size big)
                     Image::make($imageTemp)->save($large_image_path);
                     // Upload image then resized it
                     Image::make($imageTemp)->resize(520,600)->save($medium_image_path);
                     Image::make($imageTemp)->resize(260,300)->save($small_image_path);

                     $productImage->image = $imageName;
                     $productImage->product_id = $id;
                     $productImage->status = 1;
                     $productImage->save();
                }
                $message = 'Product Image has been Uploaded Successfully !';
                Session::flash('success_message_edit_attr', $message);
                return redirect()->back();
            }
        }
        $productdata = Product::with('images')->select('id', 'product_name', 'product_code', 'product_color', 'main_image')->find($id);
        $productdata = json_decode(json_encode($productdata), true);
        $title = "Add Images Attribute";
        // echo "<pre>"; print_r($productdata); die;
        return view('admin.products.add_images')->with(compact('productdata', 'title'));
    }

    public function updateImagesStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsImages::where('id', $data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'image_id'=>$data['image_id']]);
        }
    }


    public function deleteImage($id)
    {
        // Get product image
        $productImage = ProductsImages::select('image')->where('id', $id)->first();

        // Get Image Path
        $smallImagePath = 'images/product_images/small/';
        $mediumImagePath = 'images/product_images/medium/';
        $largeImagePath = 'images/product_images/large/';

        // Delete Image from folder if exist in small folder
        if (file_exists($smallImagePath.$productImage->image)) {
            unlink($smallImagePath.$productImage->image);
        }

        // Delete Image from folder if exist in medium folder
        if (file_exists($mediumImagePath.$productImage->image)) {
            unlink($mediumImagePath.$productImage->image);
        }

        // Delete Image from folder if exist in large folder
        if (file_exists($largeImagePath.$productImage->image)) {
            unlink($largeImagePath.$productImage->image);
        }

        // Delete image from product table
        ProductsImages::where('id', $id)->delete();
        $message = 'Product Image has been Deleted Successfully !';
        session::flash('success_message_edit_attr', $message);
        return redirect()->back();
    }

}


