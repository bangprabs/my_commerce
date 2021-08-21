<?php

namespace App\Http\Controllers\Front;

use Route;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;

class ProductsController extends Controller
{
    public function listing(Request $request)
    {
        Paginator::useBootstrap();
        if ($request->ajax()) {
            $data= $request->all();
            // echo "<pre>"; print_r($data); die;
            $url = $data['url'];
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if ($categoryCount>0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                // If fabric filter is selected
                if (isset($data['fabric']) && !empty($data['fabric'])) {
                    $categoryProducts->whereIn('products.fabric', $data['fabric']);
                }

                if (isset($data['sleeve']) && !empty($data['sleeve'])) {
                    $categoryProducts->whereIn('products.sleeve', $data['sleeve']);
                }

                if (isset($data['pattern']) && !empty($data['pattern'])) {
                    $categoryProducts->whereIn('products.pattern', $data['pattern']);
                }

                if (isset($data['fit']) && !empty($data['fit'])) {
                    $categoryProducts->whereIn('products.fit', $data['fit']);
                }

                if (isset($data['occasion']) && !empty($data['occasion'])) {
                    $categoryProducts->whereIn('products.occasion', $data['occasion']);
                }

                // If sort option selected by User
                if (isset($data['sort']) && !empty($data['sort'])) {
                    if ($data['sort'] == "product_latest") {
                        $categoryProducts->orderBy('id', 'Desc');
                    } else if($data['sort'] == "product_name_a_z"){
                        $categoryProducts->orderBy('product_name', 'Asc');
                    } else if($data['sort'] == "product_name_z_a"){
                        $categoryProducts->orderBy('product_name', 'Desc');
                    } else if($data['sort'] == "price_lowest"){
                        $categoryProducts->orderBy('product_price', 'Asc');
                    } else if($data['sort'] == "price_highest"){
                        $categoryProducts->orderBy('product_price', 'Desc');
                    }
                } else {
                    $categoryProducts->orderBy('id', 'Desc');
                }

                $categoryProducts = $categoryProducts->paginate(30);

                return view('front.products.ajax_products_listing')->with(compact('categoryDetails', 'categoryProducts', 'categoryCount', 'url'));
            } else {
                abort(404);
            }
        } else {
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if ($categoryCount>0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                $categoryProducts = $categoryProducts->paginate(30);

                // Products Filters
                $productFilters = Product::productFilters();
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray = $productFilters['occasionArray'];

                $page_name = "listing";
                return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'categoryCount', 'url', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'page_name'));
            } else {
                abort(404);
            }
        }
    }
    public function detail($code, $id){
        return view('front.products.detail');
    }
}
