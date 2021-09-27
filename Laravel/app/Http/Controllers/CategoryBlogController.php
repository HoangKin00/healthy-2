<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryBlog;
use App\Models\Blog;
class CategoryBlogController extends Controller
{
    public function index()
    {
        $data = CategoryBlog::SearchFilter()->paginate(3);
        $orderByOptions = [
            'id-ASC'=> 'ID tăng dần',
            'id-DESC'=> 'ID giảm dần',
            'name-ASC'=> 'Tên tăng dần',
            'name-DESC'=> 'Tên giảm dần',
            'created_at-ASC'=> 'Created at A - Z',
            'created_at-DESC'=> 'Created at Z - A',
        ];
        return view('admin.categoryBlog.index', compact('data','orderByOptions'));
    }

    public function create()
    {
        return view('admin.categoryBlog.create');
    }
    //thêm mới category
    public function add(Request $request)
    {
         //Validate dữ liệu
         $rules = [
            'name' => 'required|unique:categoryBlog',
        ];
        $mag = [
            'name.required' => 'Tên danh mục blog không được để trống',
            'name.unique' => 'Tên danh mục blog <b>'.$request->name.'</b>  đã tồn tại trong CSDL',
        ];
        $request->validate($rules, $mag);
        //Lấy dữ liệu
        $form_data = $request->only('name', 'status');
        //Lưu vào CSDL
        $added = CategoryBlog::create($form_data);

        if ($added) { //chưa vào đc đây đâu
            return redirect()->route('categoryBlog.index');
        } else {
            return  redirect()->back();
        }
    }
    //Hiện thị sửa
    public function edit(CategoryBlog $cat)
    {
        return view('admin.categoryBlog.edit', compact('cat'));
    }
    //Sửa category
    public function update(CategoryBlog $cat, Request $request)
    {
         //Validate dữ liệu
         $rules = [
            'name' => 'required|unique:categoryBlog,name,'.$cat->id,
        ];
        $mag = [
            'name.required' => 'Tên danh mục blog không được để trống',
            'name.unique' => 'Tên danh mục blog <b>'.$request->name.'</b>  đã tồn tại trong CSDL',
        ];
        $request->validate($rules, $mag);
        $form_data = $request->only('name', 'status');
        if ($cat->update($form_data)) {
            return redirect()->route('categoryBlog.index')->with('success', 'Sửa thành công');
        }
        return redirect()->back()->with('error', 'Sửa không thành công!');
    }
    //Xóa 1 sản phẩm vào thùng rác
    public function destroy(CategoryBlog $cat)
    {
        $count_prod = Blog::where('categoryBlog_id', $cat->id)->count();
        if ($count_prod > 0) {
            return redirect()->route('categoryBlog.index')->with('error', 'Không thể xóa danh mục này');
        } else {
            $cat->delete();
            return redirect()->route('categoryBlog.index')->with('success', 'Xóa danh mục thành công!');
        }
    }
    //Xóa nhiều sản phẩm, xóa vĩnh viễn
    public function forceDelete($id)
    {
        $cat = CategoryBlog::withTrashed()->find($id);
        $cat->forceDelete();
        return redirect()->route('categoryBlog.index')->with('success', 'Xóa vĩnh viễn danh mục thành công!');
    }

    //Thùng rác
    public function trashed()
    {
        $data = CategoryBlog::onlyTrashed()->paginate(3);
        return view('admin.categoryBlog.trashed', compact('data'));
    }
    //Khôi phục nhiều cái
    public function restore($id)
    {
        $cat = CategoryBlog::withTrashed()->find($id);
        $cat->restore();
        return redirect()->route('categoryBlog.index')->with('success', 'Khôi phục thành công!');
    }
    //Xoa nhiều bên index rồi nhảy sang thùng rác
    public function clear(Request $req)
    {
        $ids = $req->id;
        $n = 0;
        $n1 = 0;
        foreach($ids as $id){
            $cat = CategoryBlog::find($id);
            if($cat->blog()->count()==0){
                $cat->delete();
                $n ++;

            }else{
                $n1 ++;

            }

        }

        return redirect()->route('categoryBlog.index')->with('success','Đã xóa '.$n.' danh mục và có '.$n1.' danh mục không thể xóa');

    }
//Khôi phục nhiều
    public function restoreAll(Request $request)
    {
        $ids = $request->id;
        foreach($ids as $id){
            $cat = CategoryBlog::withTrashed()->find($id);
            if($cat){
                $cat->restore();

            }
        }
        return redirect()->route('categoryBlog.index')->with('success','Đã Khôi Phục thành công');
    }
//Xóa nhiều bên thùng rác
    public function deleteAll(Request $req)
    {
        $ids = $req->id;
        foreach ($ids as $id) {
            $pro = CategoryBlog::withTrashed()->find($id);
            if ($pro) {
                $pro->forceDelete();
            }
        }

        return redirect()->route('categoryBlog.index')->with('success', 'Đã xóa vĩnh viễn thành công');
    }
}
