<?php

namespace App\Http\Controllers;
use App\Slide;
use App\Product;
use App\ProductType;
use Illuminate\Http\Request;
use Auth;
use App\User;


class PageController extends Controller
{
    public function getIndex(){
    	$slide = Slide::all();
    	$new_product = Product::where('new',1)->paginate(4);
    	$sanpham_khuyenmai = Product::where('promotion_price','<>','0')->paginate(8);

    	// return view('page.trangchu',['slide'=>$slide]);
    	return view('page.trangchu',compact('slide','new_product','sanpham_khuyenmai'));
    	
    }

    public function getLoaiSp($type){
        $sp_theoloai = Product::where('id_type',$type)->get();
        $sp_khac = Product::where('id_type','<>',$type)->paginate(3);
        $loai = ProductType::all();
    	return view('page.loai_sanpham', compact('sp_theoloai','sp_khac','loai'));
    }
     public function getChitiet(Request $req){
        $sanpham = Product::where('id',$req->id)->first();
        $sp_tuongtu = Product::where('id_type',$sanpham->id_type)->paginate(6);
    	$new_product = Product::where('new',1)->paginate(2);
        return view('page.chitiet_sanpham', compact('sanpham','sp_tuongtu','new_product'));
    }
    public function getLienHe(){
    	return view('page.lienhe');
    }
     public function getGioiThieu(){
        return view('page.gioithieu');
    }

    public function getLogin(){
        return view('page.login');
    }
    public function postLogin( Request $req){
        $this-> validate($req,
            [
                'email'=>'required|email',
                'password'=>'required'
            ],
            [
                'email.required' =>'Vui long nhap email',
                'email.email' =>'Vui long nhap dung dinh dang email',
                'password.required' =>'Vui long nhap password'
            ]
        );
        $scredentials = array('email' =>$req->email, 'password'=>$req->password);
        if (Auth::attempt($scredentials)) {
           return redirect()->back()->with(['flag'=>'success','message'=>'Dang nhap thanh cong']);
        }
         else{
            return redirect()->back()->with(['flag'=>'danger','message'=>'Dang nhap khong thanh cong']);
        }

    }

    public function getSignup(){
        return view('page.dangky');
    }
}
