<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryBlog;
use App\Models\Blog;
class BlogController extends Controller
{
    public function index()
    {
        $data = Blog::SearchFilter()->paginate(3);
        $orderByOptions = [
            'id-ASC'=> 'ID tăng dần',
            'id-DESC'=> 'ID giảm dần',
            'name-ASC'=> 'Tên tăng dần',
            'name-DESC'=> 'Tên giảm dần',
            'created_at-ASC'=> 'Created at A - Z',
            'created_at-DESC'=> 'Created at Z - A',
        ];
        $categoryBlog = CategoryBlog::all();
        return view('admin.blog.index', compact('data','orderByOptions','categoryBlog'));
    }

    public function create()
    {
        $categoryBlog = CategoryBlog::all();
        return view('admin.blog.create',compact('categoryBlog'));
    }
    //thêm mới blog
    public function add(Request $request, Blog $blog)
    {
        //Validate dữ liệu
        $rules = [
            'title' => 'required|unique:blog,title,'.$blog->id,
            'content' => 'required',
            'categoryBlog_id' => 'required',
            'upload_file' => 'required|file|mimes:jpg,png,jpeg,gif',
        ];
        $mag = [
            'title.required' => 'Tiêu đề blog không được để trống',
            'title.unique' => 'Tiêu đề blog <b>' . $request->title . '</b> đã tồn tại trong CSDL',
            'content.required' => 'Nội dung blog không được để trống',
            'categoryBlog_id.required' => 'Danh mục blog không được để trống',
            'upload_file.required' => 'Ảnh blog không được để trống',
            'upload_file.file' => 'Ảnh blog phải ở dạng một File',
            'upload_file.mimes' => 'Ảnh blog phải định dạng đuôi: jpg,png,jpeg,gif',
        ];
        $request->validate($rules, $mag);
        //Lấy dữ liệu
        $form_data = $request->only('title','image','content','categoryBlog_id','status');
        if ($request->has('upload_file')) {
            $file = $request->upload_file;
            $ext = $request->upload_file->extension();
              $file_name = 'blog-'.time().'-'.strtoupper(Str::random(10)).'.'.$ex;
            $file_name = time() . $file->getClientoriginalName();
            $file->move(public_path('uploads'), $file_name);
        }
        $form_data['image'] =  $file_name;
        //Lưu vào CSDL
        $blog = Blog::create($form_data);
        if ($blog) {
            return redirect()->route('blog.index');
        } else {
            return  redirect()->back();
        }
    }
    //Hiện thị sửa
    public function edit(Blog $blog)
    {
        $categoryBlog = CategoryBlog::all();
        return view('admin.blog.edit', compact('blog','categoryBlog'));
    }
    //Sửa blog
    public function update(Blog $blog, Request $request)
    {
          //Validate dữ liệu
         $rules = [
            'title' => 'required|unique:blog,title,'.$blog->id,
            'content' => 'required',
            'categoryBlog_id' => 'required',
            'file_upload' => 'required|file|mimes:jpg,png,jpeg,gif',
        ];
        $mag = [
            'title.required' => 'Tiêu đề blog không được để trống',
            'title.unique' => 'Tiêu đề blog <b>' . $request->name . '</b> đã tồn tại trong CSDL',
            'content.required' => 'Nội dung blog không được để trống',
            'categoryBlog_id.required' => 'Danh mục blog không được để trống',
            'title.unique' => 'Tiêu đề blog <b>' . $request->title . '</b> đã tồn tại trong CSDL',
            'content.required' => 'Nội dung blog không được để trống',
            'categoryBlog_id.required' => 'Danh mục blog không được để trống',
            'file_upload.required' => 'Ảnh blog không được để trống',
            'file_upload.file' => 'Ảnh blog phải ở dạng một File',
            'file_upload.mimes' => 'Ảnh blog phải định dạng đuôi: jpg,png,jpeg,gif',
        ];
        $request->validate($rules, $mag);
        //Lấy dữ liệu
        $form_data = $request->only('title','image','content','categoryBlog_id','status');
        if ($request->has('file_upload')) {
            $file = $request->file_upload;
            $ext = $request->file_upload->extension();
            $file_name = 'blog-'.time().'-'.strtoupper(Str::random(10)).'.'.$ex;
            $file_name = time() . $file->getClientoriginalName();
            $file->move(public_path('uploads'), $file_name);
        } else {

            $file_name = $blog->image;
        }
        $form_data['image'] =  $file_name;
        if ($blog->update($form_data)) {
            return redirect()->route('blog.index')->with('success', 'Sửa thành công');
        }
        return redirect()->back()->with('error', 'Sửa không thành công!');
    }
    // //Xóa 1 sản phẩm vào thùng rác
    public function destroy(Blog $blog)
    {
      
        if ( $blog->delete()) {
            return redirect()->route('blog.index')->with('success', 'Xóa danh mục thành công!');
        } else {
            return redirect()->route('blog.index')->with('error', 'Không thể xóa danh mục này');
        }
    }
   
    //Xoa nhiều bên index rồi nhảy sang thùng rác
    public function clear(Request $req)
    {
        $ids = $req->id;
        $n = 0;
        $n1 = 0;
        foreach($ids as $id){
            $blog = Blog::find($id);
            if($blog){
                $blog->delete();
                $n ++;

            }else{
                $n1 ++;

            }

        }

        return redirect()->route('blog.index')->with('success','Đã xóa '.$n.' blog và có '.$n1.' blog không thể xóa');

    }
}
