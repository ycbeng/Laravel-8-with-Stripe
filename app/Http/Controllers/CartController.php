<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Auth;
use App\Models\myCart;
use App\Models\Product;

class CartController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth'); 		
    }

    

    public function add(){
        $r=request();
        $addCart=myCart::Create([
            'productID'=>$r->productID,
            'quantity'=>$r->quantity,
            'userID'=>Auth::id(),
            'orderID'=>'',
        ]);
        Return redirect()->route('show.my.cart');
    }

    public function showMyCart(){
        $carts=DB::table('my_carts')
        ->leftjoin('products','products.id','=','my_carts.productID')
        ->select('my_carts.quantity as cartQTY','my_carts.id as cid', 'products.*')
        ->where('my_carts.orderID','=','')//if '' means haven't make payment
        ->where('my_carts.userID','=',Auth::id()) //item match with current login user
        //->get();       
        ->paginate(5);//5 = five items in one page

        $this->cartItem(); //call function calculate no. cart item
       
        return view('myCart')->with('carts',$carts);
    }

    public function delete($id){
        $deleteItem=myCart::find($id); //binding record
        $deleteItem->delete();//delete record
        Session::flash('success','Item was remove successfully!');
        Return redirect()->route('show.my.cart');
    }

    public function cartItem(){
        $noItem=DB::table('my_carts')
        ->leftjoin('products','products.id','=','my_carts.productID')
        ->select(DB::raw('COUNT(*) as count_item'))
        ->where('my_carts.orderID','=','')//if '' means haven't make payment
        ->where('my_carts.userID','=',Auth::id()) //item match with current login user
        ->groupBy('my_carts.userID')
        ->first();

        $cartItem=$noItem->count_item;
        Session()->put('cartItem',$cartItem);//assign value to session variable cartItem
    }
}
