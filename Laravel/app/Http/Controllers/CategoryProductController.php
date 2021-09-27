<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Models\Product;
class CategoryProductController extends Controller
{
    public function index()
    {
        $data = CategoryProduct::SearchFilter()->paginate(3);
        $orderByOptions = [
            'id-ASC'=> 'ID tăng dần',
            'id-DESC'=> 'ID giảm dần',
            'name-ASC'=> 'Tên tăng dần',
            'name-DESC'=> 'Tên giảm dần',
            'created_at-ASC'=> 'Created at A - Z',
            'created_at-DESC'=> 'Created at Z - A',
        ];
        return view('admin.categoryProduct.index', compact('data','orderByOptions'));
    }

    public function create()
    {
        return view('admin.categoryProduct.create');
    }
    //thêm mới category
    public function add(Request $request)
    {
         //Validate dữ liệu
         $rules = [
            'name' => 'required|unique:categoryProduct',
        ];
        $mag = [
            'name.required' => 'Tên danh mục sản phẩm không được để trống',
            'name.unique' => 'Tên danh mục sản phẩm <b>'.$request->name.'</b>  đã tồn tại trong CSDL',
        ];
        $request->validate($rules, $mag);
        //Lấy dữ liệu
        $form_data = $request->only('name', 'status');
        //Lưu vào CSDL
        $added = CategoryProduct::create($form_data);

        if ($added) { //chưa vào đc đây đâu
            return redirect()->route('categoryProduct.index');
        } else {
            return  redirect()->back();
        }
    }
    //Hiện thị sửa
    public function edit(CategoryProduct $cat)
    {
        return view('admin.categoryProduct.edit', compact('cat'));
    }
    //Sửa category
    public function update(CategoryProduct $cat, Request $request)
    {
         //Validate dữ liệu
         $rules = [
            'name' => 'required|unique:categoryProduct,name,'.$cat->id,
        ];
        $mag = [
            'name.required' => 'Tên danh mục sản phẩm không được để trống',
            'name.unique' => 'Tên danh mục sản phẩm <b>'.$request->name.'</b>  đã tồn tại trong CSDL',
        ];
        $request->validate($rules, $mag);
        $form_data = $request->only('name', 'status');
        if ($cat->update($form_data)) {
            return redirect()->route('categoryProduct.index')->with('success', 'Sửa thành công');
        }
        return redirect()->back()->with('error', 'Sửa không thành công!');
    }
    //Xóa 1 sản phẩm vào thùng rác
    public function destroy(CategoryProduct $cat)
    {
        $count_prod = Product::where('categoryProduct_id', $cat->id)->count();
        if ($count_prod > 0) {
            return redirect()->route('categoryProduct.index')->with('error', 'Không thể xóa danh mục này');
        } else {
            $cat->delete();
            return redirect()->route('categoryProduct.index')->with('success', 'Xóa danh mục thành công!');
        }
    }
    //Xóa nhiều sản phẩm, xóa vĩnh viễn
    public function forceDelete($id)
    {
        $cat = CategoryProduct::withTrashed()->find($id);
        $cat->forceDelete();
        return redirect()->route('categoryProduct.trashed')->with('success', 'Xóa vĩnh viễn danh mục thành công!');
    }

    //Thùng rác
    public function trashed()
    {
        $data = CategoryProduct::onlyTrashed()->paginate(3);
        return view('admin.categoryProduct.trashed', compact('data'));
    }
    //Khôi phục nhiều cái
    public function restore($id)
    {
        $cat = CategoryProduct::withTrashed()->find($id);
        $cat->restore();
        return redirect()->route('categoryProduct.index')->with('success', 'Khôi phục thành công!');
    }
    //Xoa nhiều bên index rồi nhảy sang thùng rác
    public function clear(Request $req)
    {
        $ids = $req->id;
        $n = 0;
        $n1 = 0;
        foreach($ids as $id){
            $cat = CategoryProduct::find($id);
            if($cat->product()->count()==0){
                $cat->delete();
                $n ++;

            }else{
                $n1 ++;

            }

        }

        return redirect()->route('categoryProduct.index')->with('success','Đã xóa '.$n.' danh mục và có '.$n1.' danh mục không thể xóa');

    }
//Khôi phục nhiều
    public function restoreAll(Request $request)
    {
        $ids = $request->id;
        foreach($ids as $id){
            $cat = CategoryProduct::withTrashed()->find($id);
            if($cat){
                $cat->restore();

            }
        }
        return redirect()->route('categoryProduct.index')->with('success','Đã Khôi Phục thành công');
    }
//Xóa nhiều bên thùng rác
    public function deleteAll(Request $req)
    {
        $ids = $req->id;
        foreach ($ids as $id) {
            $pro = CategoryProduct::withTrashed()->find($id);
            if ($pro) {
                $pro->forceDelete();
            }
        }

        return redirect()->route('categoryProduct.trashed')->with('success', 'Đã xóa vĩnh viễn thành công');
    }
}


