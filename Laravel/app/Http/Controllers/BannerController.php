<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends Controller
{
    public function index()
    {
        $data = Banner::searchFilter()->paginate(3);
        $orderByOptions = [
            'id-ASC'=> 'ID tăng dần',
            'id-DESC'=> 'ID giảm dần',
            'name-ASC'=> 'Tên tăng dần',
            'name-DESC'=> 'Tên giảm dần',
            'created_at-ASC'=> 'Created at A - Z',
            'created_at-DESC'=> 'Created at Z - A',
        ];
        return view('admin.banner.index', compact('data','orderByOptions'));
    }
    public function create()
    {
        return view('admin.banner.create');
    }
    public function add(Request $request, Banner $ban)
    {
        //Validate dữ liệu
        $rules = [
            'title' => 'required|unique:banner,title,'.$ban->id,
            'file_upload' => 'required|file|mimes:jpg,png,jpeg,gif',
        ];
        $mag = [
            'title.required' => 'Tiêu đề banner không được để trống',
            'title.unique' => 'Tiêu đề banner <b>' . $request->title . '</b> đã tồn tại trong CSDL',
           'file_upload.required' => 'Ảnh banner không được để trống',
            'file_upload.file' => 'Ảnh banner phải ở dạng một File',
            'file_upload.mimes' => 'Ảnh banner phải định dạng đuôi: jpg,png,jpeg,gif',
        ];
        $request->validate($rules, $mag);
        //Lấy dữ liệu
       
        if($request->has('file_upload')){
            $file = $request->file_upload;
            $ext = $request->file_upload->extension();
              $file_name = 'banner-'.time().'-'.strtoupper(Str::random(10)).'.'.$ex;
            $file_name = time() . $file->getClientoriginalName();
            $file->move(public_path('uploads'),$file_name);
        }
        else {

            $file_name = $ban->image;

        }

        $request->merge(['image'=>$file_name]);
        $form_data = $request->only('title','image','link','status');
        //Lưu vào CSDL
        $banner = Banner::create($form_data);
        if ($banner) {
            return redirect()->route('banner.index')->with('success', 'Thêm banner thành công!');
        } else {
            return  redirect()->back();
        }
    }
    public function destroy(Banner $ban)
    {
        $ban->delete();
        return redirect()->route('banner.index')->with('success', 'Xóa banner thành công!');
    }
    public function edit(Banner $ban)
    {
        return view('admin.banner.edit', compact('ban'));
    }
      public function update(Banner $ban, Request $request)
    {
          //Validate dữ liệu
         $rules = [
            'title' => 'required|unique:banner,title,'.$ban->id,
            // 'image' => 'required|file|mimes:jpg,png,jpeg,gif',
        ];
        $mag = [
            'title.required' => 'Tiêu đề banner không được để trống',
            'title.unique' => 'Tiêu đề banner <b>' . $request->title . '</b> đã tồn tại trong CSDL',
           'image.required' => 'Ảnh banner không được để trống',
            // 'image.file' => 'Ảnh banner phải ở dạng một File',
            // 'image.mimes' => 'Ảnh banner phải định dạng đuôi: jpg,png,jpeg,gif',
        ];
        $request->validate($rules, $mag);
        //Lấy dữ liệu
        $form_data = $request->only('title','image','link','status');
        if ($request->has('file_upload')) {
            $file = $request->file_upload;
            $ext = $request->file_upload->extension();
              $file_name = 'banner-'.time().'-'.strtoupper(Str::random(10)).'.'.$ex;
            $file_name = time() . $file->getClientoriginalName();
            $file->move(public_path('uploads'), $file_name);
        } else {

            $file_name = $ban->image;
        }
        $form_data['image'] =  $file_name;
        if ($ban->update($form_data)) {
            return redirect()->route('banner.index')->with('success', 'Sửa thành công');
        }
        return redirect()->back()->with('error', 'Sửa không thành công!');
    }
    //xóa nhiều
     public function clear(Request $req)
    {
        $ids = $req->id;
        $n = 0;
        $n1 = 0;
        foreach($ids as $id){
            $blog = Banner::find($id);
            if($blog){
                $blog->delete();
                $n ++;

            }else{
                $n1 ++;

            }

        }

        return redirect()->route('banner.index')->with('success','Đã xóa '.$n.' banner và có '.$n1.' banner không thể xóa');

    }
}
