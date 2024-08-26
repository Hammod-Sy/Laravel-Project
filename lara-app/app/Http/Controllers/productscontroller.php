<?php

namespace App\Http\Controllers;

use App\Http\Requests\productRequest;
use App\Models\Product;
use finfo;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;

class productscontroller extends Controller
{
    public function getproducts(){
        $product = Product::all();
        if(!$product){
            return response('No Products' ,201);
        }
        return response( $product ,200);
    }
    public function getproduct($id){
        $product = Product::find($id);
        if(!$product){
            return response('No Products' ,201);
        }
        return response($product ,200);
    }

    public function addproduct(productRequest $request){
        $product = new Product;
        if($request -> name){
            $product -> name = $request->name;
        }
        if($request -> price){
            $product -> price = $request->price;
        }
        if($request -> description){
            $product -> description = $request->description;
        }
        if($request -> hasFile('image')){
        $img= $request -> file('image');
        $img_name= $img ->getClientOriginalName();
        $st = $img -> storeAs('/products' , $img_name , 'public');
        $path = 'products/'.$img_name;
        $product->image = $path;
        }
        $product -> save();
        return response('Products Added' ,200);
    }


    public function updateproduct($id , productRequest $request){
        $newproduct = Product::find($id);
        if($request -> name){
            $newproduct -> name = $request->name;
        }
        if($request -> price){
            $newproduct -> price = $request->price;
        }
        if($request -> description){
            $newproduct -> description = $request->description;
        }
        $img = $request ->file('image');
        $img_name = $img -> getClientOriginalName();
        $st = $img->storeAs('/products',$img_name,'public');
        $path = 'products/'.$img_name;
        $newproduct -> image = $path;
        $newproduct -> save();
        return response('Product Updated',200);

    }

    public function deleteproduct($id){
        $product = Product::destroy($id);
        return response('Product Deleted', 200);
    }

}
