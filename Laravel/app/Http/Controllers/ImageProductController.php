<?php

namespace App\Http\Controllers;

use App\Models\ImageProduct;
use Illuminate\Http\Request;
use Str;

class ImageProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ImageProduct  $productImage
     * @return \Illuminate\Http\Response
     */
    public function show(ImageProduct $productImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function edit(ImageProduct $image)
    {
        return view('admin.product.image-edit',compact('image'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImageProduct $image)
    {
        $data['image'] = $image->image;
        if($request->has('upload')){
            $ex = $request->upload->extension();
            $file_name = 'PRODUCT-'.time().'-'.strtoupper(Str::random(10)).'.'.$ex;
            if($request->upload->move(public_path('uploads'), $file_name)){
                $data['image'] = $file_name;
            }
        }
        $image->update($data);
        return redirect() -> route('product.edit',$image->product_id)->with('yes','Cập nhật ảnh khác của Sản phẩm thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ImageProduct  $productImage
     * @return \Illuminate\Http\Response
     */
    public function destroy( $image)
    {
         $images = ImageProduct::find($image);
        if ($images) {
            $images->delete();
            return redirect()->route('product.edit', $images->product_id)->with('success', 'Xóa ảnh phụ thành công!');
        }
       
    }
}
