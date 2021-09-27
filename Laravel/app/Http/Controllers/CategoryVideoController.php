<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CategoryCreatRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\CategoryVideo;
use Validator;
class CategoryVideoController extends Controller
{
    public function index()
    {
        $data =  CategoryVideo::searchFilter()->paginate(5);
        $orderByOptions = [
            'id-ASC' => 'ID A-Z',
            'id-DESC' => 'ID Z-A',
            'name-ASC' => 'Tên A-Z',
            'name-DESC' => 'Tên Z-A',
            'created_at-ASC' => 'Ngày nhập A-Z',
            'created_at-DESC' => 'Ngày nhập Z-A',

        ];
        return view('admin.categoryVideo.index',compact('data','orderByOptions'));
    }
    
    
    public function create()
    {
        return view('admin.categoryVideo.create');
    }
    public function add(Request $req)
    {
        $rules=[
            'name' => 'required|unique:categoryvideo',
        ];
        $msg = [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại trong CSDL',
        ];
        $req->validate($rules,$msg);

        $form_data = $req->only('name','status');
        if(CategoryVideo::create($form_data)){
            return redirect()->route('categoryVideo.index')->with('success','Thêm mới thành công!');
        }
        return redirect()->back()->with('error','Thêm mới không thành công!');
    }
    
    public function edit(CategoryVideo $cat)
    { 
        return view('admin.categoryVideo.edit',compact('cat'));
    }
    public function update(CategoryVideo $cat, Request $req)
    { 
        $rules=[
            'name' => 'required|unique:categoryvideo,name,'.$cat->id,
        ];
        $msg = [
            'name.required' => 'Tên danh mục không được để trống',
            'name.unique' => 'Tên danh mục đã tồn tại trong CSDL',
        ];
        $req->validate($rules,$msg);

        $form_data = $req->only('name','status');

        if($cat->update($form_data)){
            return redirect()->route('categoryVideo.index')->with('success','Sửa thành công!');
        }
        return redirect()->back()->with('error','Sửa không thành công!');
    }
    public function restore( $id)
    {
        $cat = CategoryVideo::withTrashed()->find($id);
        $cat->restore();
        return redirect()->route('categoryVideo.index')->with('success','Khôi phục thành công!');

    }
    
    public function trashed()
    {
        $data =  CategoryVideo::onlyTrashed()->paginate(5);
        return view('admin.categoryVideo.trashed',compact('data'));
    }
    public function forceDelete($id)
    {   
        $cat = CategoryVideo::withTrashed()->find($id);
        $cat->forceDelete();
        return redirect()->route('categoryVideo.index')->with('success','Xóa vĩnh viễn thành công!'); 
           
    }

    
    public function destroy (CategoryVideo $cat)
    {   
       
        // if($cat->products->count()==0){
        //     $cat->delete();
        if($cat->delete()){
            
            return redirect()->route('categoryVideo.index')->with('success','Xóa danh mục thành công!');
        }
        
        return redirect()->route('categoryVideo.index')->with('error','Không thể xóa danh mục này. ');

           
    }
    public function clear(Request $req)
    {
        $ids = $req->id;
        $n = 0;
        $n1 = 0;
        foreach($ids as $id){
            $cat = CategoryVideo::find($id);
            // if($cat->products->count()==0){
            //     $cat->delete();
        
            if($cat->delete()){
                
                $n ++;

            }else{
                $n1 ++;

            }
            
        }
        
        return redirect()->route('categoryVideo.index')->with('success','Đã xóa '.$n.' danh mục và có '.$n1.' danh mục không thể xóa');

    }
    public function restoreAll(Request $req)
    {
        $ids = $req->id;
        $n = 0;
        foreach($ids as $id){
            $pro = CategoryVideo::withTrashed()->find($id);
            // if($pro->hasDetail->count()==0){
            //     $pro->restore();
            if($pro->restore()){
                
                $n ++;
            }
        }
        
        return redirect()->route('categoryVideo.index')->with('success','Đã khôi phục '.$n.' sản phẩm ');

    }
    public function deleteAll(Request $req)
    {
        $ids = $req->id;
        foreach ($ids as $id) {
            $pro = CategoryVideo::withTrashed()->find($id);
            if ($pro) {
                $pro->forceDelete();
            }
        }

        return redirect()->route('categoryVideo.index')->with('success', 'Đã xóa vĩnh viễn thành công');
    }
}
