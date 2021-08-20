<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Section;
use Image;
use Session;

class CategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::with(['section', 'parentcategory'])->get();
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Category::where('id', $data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id=null)
    {
        if ($id=="") {
            // Add category function
            $title = "Add Category";
            $category = new Category;
            $categorydata = array();
            $getCategories = array();
            $message = "Category has been added successfully !";
        }else{
            // Edit Category Funtcion
            $title = "Edit Category";
            $categorydata = Category::where('id', $id)->first();
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$categorydata['section_id']])->get();
            $category = Category::find($id);
            $message = "Category has been added updated !";
        }

        if ($request->isMethod('post')) {

            $data = $request->all();

            // Category Valdation
            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'url' => 'required',
                'category_image' => 'image'
            ];
            $customeMessages = [
                'category_name.required' => 'Category Name is required',
                'category_name.regex' => 'Valid Category Name is required',
                'section_id.required' => 'Section is required',
                'url.required' => 'Category URL is required',
                'category_image.image' => 'Valid Category Image is required'
            ];
            $this->validate($request, $rules, $customeMessages);

            // Update image
            if ($request->hasFile('category_image')) {
            $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    // Get Image Extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate New Image Name
                    $imageName = rand(111,9999).'.'.$extension;
                    $imagePath = 'images/category_images/'.$imageName;
                    // Upload the images
                    Image::make($image_tmp)->resize(600,600)->save($imagePath);
                    $category->category_image = $imageName;
                }
            }

            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();


            Session::flash('success_message', $message);
            return redirect('admin/categories');
        }

        // Get all sections
        $getSection = Section::get();
        return view('admin.categories.add_edit_categories')->with(compact('title', 'getSection', 'categorydata', 'getCategories'));
    }

    public function appendCategoryLevel(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $getCategories = Category::with('subcategories')->where(['section_id'=>$data['section_id'], 'parent_id'=>0, 'status'=>1])->get();
            // $getCategories = json_decode(json_encode($getCategories), true);
            //  echo "<pre>"; print_r($getCategories); die;
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }

    public function deleteCategoryImage($id)
    {
        // Get category image
        $categoryImage = Category::select('category_image')->where('id', $id)->first();
        // Get Image Path
        $categoryImagePath = 'images/category_images/';
        // Delete Image from folder if exist
        if (file_exists($categoryImagePath.$categoryImage->category_image)) {
            unlink($categoryImagePath.$categoryImage->category_image);
        }

        // Delete image from table
        Category::where('id', $id)->update(['category_image'=>'']);
        $message = 'Category Image has been Deleted Successfully !';
        session::flash('success_message', $message);
        return redirect()->back();
    }

    public function deleteCategory($id)
    {
        Category::where('id', $id)->delete();
        $message = 'Category has been Deleted Successfully !';
        session::flash('success_message', $message);
        return redirect()->back();
    }
}
