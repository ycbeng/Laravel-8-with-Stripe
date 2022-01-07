<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;
use Session;
use App\Models\Category;

class ProductController extends Controller
{
    public function add(){
        $r=request();  //received the data by GET or POST mothod 
        $image=$r->file('productImage');        
        $image->move('images',$image->getClientOriginalName());   //images is the location                
        $imageName=$image->getClientOriginalName(); 
        $addProduct=Product::create([
            'name'=>$r->productName,
            'description'=>$r->productDescription,
            'quantity'=>$r->productQuantity,
            'price'=>$r->productPrice,
            'CategoryID'=>$r->CategoryID,
            'image'=>$imageName,
        ]);
        Session::flash('success',"Product create successfully!");
        Return redirect()->route('showProduct');
    }

    public function view(){
        //$viewProduct=Product::all();
        $viewProduct=DB::table('products')
        ->leftjoin('categories','categories.id','=','products.CategoryID')
        ->select('products.*','categories.name as catName')
        ->get();

        Return view('showProduct')->with('products',$viewProduct);
    }


    public function delete($id){
        
        $deleteProduct=Product::find($id);
        $deleteProduct->delete();
        Session::flash('success',"Product was delete successfully!");
        Return redirect()->route('showProduct');
    }

    public function edit($id){

        $products=Product::all()->where('id',$id);
        Return view('editProduct')->with('products',$products)
                                  ->with('categoryID',Category::all());
    }

    public function update(){

        $r=request();
        $products =Product::find($r->productID);
        
        if($r->file('productImage')!=''){
            $image=$r->file('productImage');        
            $image->move('images',$image->getClientOriginalName());                   
            $imageName=$image->getClientOriginalName(); 
            $products->image=$imageName;
            }    
        
        $products->name=$r->productName;
        $products->description=$r->productDescription;
        $products->price=$r->productPrice;
        $products->quantity=$r->productQuantity;
        $products->CategoryID=$r->CategoryID;
        $products->save();

        Return redirect()->route('showProduct');
    }

    public function productdetail($id){
        $products=Product::all()->where('id',$id);
        return view('productDetail')->with('products',$products);
    }

    public function viewProduct(){

        $products=Product::all();
        
        (new CartController)->cartItem(); // call CartController function
        
        return view('viewProducts')->with('products',$products);
        
    }

    public function searchProduct(){
        $r=request();
        $keyword=$r->keyword;
        $products=DB::table('products')->where('name','like','%'.$keyword.'%')->get();
        return view('viewProducts')->with('products',$products);
    }

    public function viewPhone(){
        $products=DB::table('products')->where('CategoryID','=','1')->get();
        return view('viewProducts')->with('products',$products);
    }

    public function viewComputer(){
        $products=DB::table('products')->where('CategoryID','=','2')->orWhere('CategoryID','=','3')->get();
        return view('viewProducts')->with('products',$products);
    }

}
