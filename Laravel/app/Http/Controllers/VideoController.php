<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Video;
use App\Models\CategoryVideo;
class VideoController extends Controller
{
    public function index()
    {
        $data =  Video::searchFilter()->paginate(5);
        $data1 =  CategoryVideo::orderBy('name','ASC')->get();
        $orderByOptions = [
            'id-ASC' => 'ID A-Z',
            'id-DESC' => 'ID Z-A',
            'name-ASC' => 'Tên A-Z',
            'name-DESC' => 'Tên Z-A',
            'created_at-ASC' => 'Ngày nhập A-Z',
            'created_at-DESC' => 'Ngày nhập Z-A',

        ];
        return view('admin.video.index',compact('data','orderByOptions','data1'));
    }
    public function create()
    {
        $cats = CategoryVideo::orderBy('name','ASC')->get();
        return view('admin.video.create',compact('cats'));
    }
    
    public function store(Request $request, Video $vid)
    {
      
        $rules = [
            'name' => 'required|unique:video,name,'.$vid->id,
            'content' => 'required',
            'categoryVideo_id' => 'required',
             'upload_file' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
        ];
        $mag = [
            'name.required' => 'Tiêu đề video không được để trống',
            'name.unique' => 'Tiêu đề video <b>' . $request->name . '</b> đã tồn tại trong CSDL',
            'content.required' => 'Nội dung video không được để trống',
            'categoryVideo_id.required' => 'Danh mục video không được để trống',
            'upload_file.required' => 'Video không được để trống',
            'upload_file.mimes' => 'Video phải định dạng đuôi: mp4,ogx,oga,ogv,ogg,webm',
        ];
        $request->validate($rules, $mag);
      
        $form_data = $request->only('name','video','content','categoryVideo_id','status');
            if ($request->has('upload_file')) {
                $file = $request->upload_file;
                $ext = $request->upload_file->extension();
                $file_name = time().'-'.'video.'.$ext;
                $file_name = $file->getClientoriginalName();
                $file->move(public_path('uploads'), $file_name);
            }
        $form_data['video'] =  $file_name;
        //Lưu vào CSDL
      $video = Video::create($form_data);
        if ($video) {
            return redirect()->route('admin.video');
        } else {
            return  redirect()->back();
        }
    }

    public function edit(Video $vid)
    {
        $cats = CategoryVideo::orderBy('name','ASC')->get();
        return view('admin.video.edit',compact('cats','vid'));
    }
    public function update(Video $vid,Request $request)
    {   
        $rules = [
            'name' => 'required|unique:video,name,'.$vid->id,
            'content' => 'required',
            'categoryVideo_id' => 'required',
             'upload_file' => 'required|mimes:mp4,ogx,oga,ogv,ogg,webm',
        ];
        $mag = [
            'name.required' => 'Tiêu đề video không được để trống',
            'name.unique' => 'Tiêu đề video <b>' . $request->name . '</b> đã tồn tại trong CSDL',
            'content.required' => 'Nội dung video không được để trống',
            'categoryVideo_id.required' => 'Danh mục video không được để trống',
            'upload_file.required' => 'Video không được để trống',
            'upload_file.mimes' => 'Video phải định dạng đuôi: mp4,ogx,oga,ogv,ogg,webm',
        ];
        $req->validate($rules,$msg);
       $form_data = $request->only('name','video','content','categoryVideo_id','status');
            if ($request->has('upload_file')) {
                $file = $request->upload_file;
                $ext = $request->upload_file->extension();
                $file_name = time().'-'.'video.'.$ext;
                $file_name = $file->getClientoriginalName();
                $file->move(public_path('uploads'), $file_name);
            }else {

            $file_name = $vid->video;
        }
        $form_data['video'] =  $file_name;
        //Lưu vào CSDL
      $video = $vid->update($form_data);
        if ($video) {
            return redirect()->route('admin.video');
        } else {
            return  redirect()->back();
        }
    }

    public function trashed()
    {
        $data =  Video::onlyTrashed()->paginate(5);
        return view('admin.video.trashed',compact('data'));
    }
    public function restore( $id)
    {
        $vid = Video::withTrashed()->find($id);
        $vid->restore();
        return redirect()->route('admin.video')->with('success','Khôi phục thành công!');

    }
    public function forceDelete($id)
    {   
        $vid = Video::withTrashed()->find($id);
        $vid->forceDelete();
        return redirect()->route('admin.video')->with('success','Xóa vĩnh viễn thành công!'); 
           
    }
    
    public function delete(Video $vid)
    {   
        if( $vid->delete()){
            return redirect()->route('admin.video')->with('success','Xóa sản phẩm thành công!');
        }
            return redirect()->back()->with('error','Không thể xóa sản phẩm này');
    }
    
   
    public function destroy(Video $vid)
    {
       $video = $vid->delete();
        if($video){
            return redirect()->route('admin.video')->with('success','Xóa sản phẩm thành công!');
        }
        
        return redirect()->route('admin.video')->with('error','Không thể xóa sản phẩm này. Sản phẩm đã có mặt trong chi tiết đơn hàng.');

    }
    public function deleteAll(Request $req)
    {
        $ids = $req->id;
        $n = 0;
        $n1 = 0;
        foreach($ids as $id){
            $vid = Video::find($id);
            if($vid){
                $vid->delete();
                $n ++;
            }else{
                $n1 ++;
            }
        }
        
        return redirect()->route('admin.video')->with('success','Đã xóa '.$n.' video và có '.$n1.' video không thể xóa');

    }
    public function restoreAll(Request $req)
    {
        $ids = $req->id;
        $n = 0;
        foreach($ids as $id){
            $vid = Video::withTrashed()->find($id);
            if($vid){
                $vid->restore();
                $n ++;
            }
        }
        
        return redirect()->route('admin.video')->with('success','Đã khôi phục '.$n.' video ');

    }
    public function forceDeleteAll(Request $req)
    {   
        $ids = $req->id;
        // dd($ids);
        foreach($ids as $id1){
            $vid = Video::withTrashed()->find($id1);
            if($vid){
                $vid->forceDelete();
               
            }
        }
        return redirect()->route('admin.video')->with('success','Xóa vĩnh viễn  sản phẩm thành công!'); 
           
    }
        public function clear(Request $req)
    {
        $ids = $req->id;
        $n = 0;
        $n1 = 0;
        foreach($ids as $id){
            $vid = Video::find($id);
            if($vid){
                $vid->delete();
                $n ++;

            }else{
                $n1 ++;

            }

        }

        return redirect()->route('admin.video')->with('success','Đã xóa '.$n.' video và có '.$n1.' video không thể xóa');

    }
    
}
