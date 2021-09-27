<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\CategoryProduct;
use App\Models\ImageProduct;
use Illuminate\Http\Request;

use Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Product::searchFilter()->paginate(10);
        $orderByOptions = [
            'id-ASC'=> 'Mã tăng dần',
            'id-DESC'=> 'Mã giảm dần',
            'price-ASC'=> 'Giá tăng dần',
            'price-DESC'=> 'Giá giảm dần',
            'created_at-ASC'=> 'Ngày tạo mới nhất'
        ];
        // dd($data);
        $cats = CategoryProduct::orderBy('name','ASC')->get();
        return view('admin.product.index',compact('data','orderByOptions','cats'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cats = CategoryProduct::orderBy('name','ASC')->get();
        return view('admin.product.create',compact('cats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'categoryProduct_id' => 'required|exists:categoryproduct,id',
            'price' => 'required|numeric|min:1000',
            'content' => 'required',
            'upload' => 'required|file|mimes:jpg,png,jpeg,gif'
        ];
        $mag = [
            'name.required' => 'Tên sản phẩm không được để trống',
            'categoryProduct_id.required' => 'Danh mục không được để trống',
            'categoryProduct_id.exists' => 'Danh mục không tồn tại',
            'price.required' => 'Giá sản phẩm không được để trống',
            'price.numeric' => 'Giá sản phẩm phải là số',
            'price.min' => 'Giá sản phẩm nhỏ nhất là 1000đ',
            'content.required' => 'Nội dung sản phẩm không được để trống',
            'upload.required' => 'Ảnh sản phẩm không được để trống',
            'upload.file' => 'Ảnh sản phẩm phải ở dạng một File',
            'upload.mimes' => 'Ảnh sản phẩm phải định dạng đuôi: jpg,png,jpeg,gif'
        ];
        $request->validate($rules, $mag);
        $data = $request->only('name','image','price','categoryProduct_id','content','status');
        $data['status'] = $request->status ? 1 : 0;
        $ex = $request->upload->extension();
        $file_name = 'PRODUCT-'.time().'-'.strtoupper(Str::random(10)).'.'.$ex;
        if($request->upload->move(public_path('uploads'), $file_name)){
            $data['image'] = $file_name;
        };
        if($product = Product::create($data)){
            //upload nhiều ảnh phải để trong phần sau khi thêm mới xong
            $product_id = $product->id; //lấy id sản phẩm sau khi thêm mới xong
            if($request->other_image && count($request->other_image)){
                $other_image = $request->other_image;
                foreach($other_image as $key => $odImage){
                    $ex1 = $odImage->extension();
                    $file_name1 = 'PRODUCT-'.time().'-'.$key.'-'.strtoupper(Str::random(10)).'.'.$ex1;
                    
                    if($odImage->move(public_path('uploads'), $file_name1)){
                        ImageProduct::create([
                            'product_id' => $product_id,
                            'image' => $file_name1
                        ]);
                    }
                }
            }
            return redirect() -> route('product.index')->with('success','Thêm mới Sản phẩm thành công');
        }
        return redirect() -> back()->with('error','Thêm mới Sản phẩm thất bại');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $cats = CategoryProduct::orderBy('name','ASC')->get();
        $images = $product->images;
        return view('admin.product.edit',compact('cats','product','images'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->only('name','image','price','categoryProduct_id','content','status');
        $data['status'] = $request->status ? 1 : 0;
        if($request->has('upload')){
            $ex = $request->upload->extension();
            $file_name = 'PRODUCT-'.time().'-'.strtoupper(Str::random(10)).'.'.$ex;
            if($request->upload->move(public_path('uploads'), $file_name)){
                $data['image'] = $file_name;
            }
        }else{
            $data['image'] = $product->image;
        }

        $other_image = $request->other_image;
        if($other_image && count($other_image)){
            foreach($other_image as $key => $odImage){
                $ex1 = $odImage->extension();
                $file_name1 = 'PRODUCT-'.time().'-'.$key.'-'.strtoupper(Str::random(10)).'.'.$ex1;
                        
                if($odImage->move(public_path('uploads'), $file_name1)){
                    ImageProduct::create([
                        'product_id' => $product->id,
                        'image' => $file_name1
                    ]);
                }
            }
        }

        //cập nhật
        if($product->update($data)){
            return redirect() -> route('product.index')->with('success','Cập nhật Sản phẩm thành công');
        }
        return redirect() -> back()->with('error','Cập nhật Sản phẩm không thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    
    
    public function delete(Product $pro)
        {
            
            if($pro->hasDetail->count() == 0 ){
            
                $pro -> delete();
                return redirect() -> route('product.index')->with('success','Xóa Sản phẩm thành công');
            }
            return redirect() -> route('product.index')->with('error','Sản phẩm này đã được mua. Không xóa được!');
        }

    public function trashed(){ //xóa tạm thời
        $data = Product::onlyTrashed()->paginate(10); //SELECT * FROM category LIMIT 5
        
        return view('admin.product.trashed', compact('data'));
    }
    public function restore($id){ //khôi phục
        $cat = Product::withTrashed()->find($id);
        $cat -> restore();
        return redirect() -> route('product.index')->with('success','Khôi phục Sản phẩm thành công');    
    }
    public function forceDelete($id){ //xóa vĩnh viễn
     
        $cat = Product::withTrashed()->find($id);
        ImageProduct::where('product_id',$id)->delete();
        $cat -> forceDelete();
        return redirect() -> route('product.trashed')->with('success','Xóa vĩnh viễn Sản phẩm thành công');    
    }

    public function restoreAll(Request $req){
        $ids = $req->id;
        foreach($ids as $id){
            $pro = Product::withTrashed()->find($id);
            if($pro){
                $pro->restore();
            }
        }
        return redirect() -> route('product.index')->with('success','Đã khôi phục sản phẩm thành công');    
    }

    public function deleteAll(Request $req){
        $ids = $req->id;
        $n = 0;
        $n1 = 0;
        foreach($ids as $id){
            $pro = Product::find($id);
            if($pro->hasDetail->count() == 0){
                $pro->delete();
                $n++;
               
            }else{
                $n1++;
            }
        }
        return redirect() -> route('product.index')->with('success','Đã xóa '.$n.' Sản phẩm và có '.$n1.' Sản phẩm không thể xóa');    
    }

    public function clear(Request $req)
    {
        $ids = $req->id;
        foreach ($ids as $id) {
            $pro = Product::withTrashed()->find($id);
            
            if ($pro) {
                ImageProduct::where('product_id',$id)->delete();
                $pro->forceDelete();
            }
        }

        return redirect()->route('product.index')->with('success', 'Đã xóa vĩnh viễn thàn công');
    }

}
