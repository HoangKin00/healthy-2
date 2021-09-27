<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logo;
class LogoController extends Controller
{
    public function index()
    {
        $data =  Logo::all();
        return view('admin.logo.index',compact('data'));
    }
    public function edit(Logo $logo)
    {
        return view('admin.logo.edit', compact('logo'));
    }
    public function update(Logo $logo, Request $request)
    {
         
          $rules = [
            'image' => 'required|file|mimes:jpg,png,jpeg,gif'
        ];
        $mag = [
            'image.file' => 'Ảnh sp phải ở dạng một File',
            'image.mimes' => 'Ảnh sp phải định dạng đuôi: jpg,png,jpeg,gif'  
        ];
        $request->validate($rules, $mag);
        
        $form_data = $request->only('image');
        if ($request->has('file_upload')) {
            $file = $request->file_upload;
            $ext = $request->file_upload->extension();
            $file_name = time() . '-' . 'logo.' . $ext;
            $file_name = time() . $file->getClientoriginalName();
            $file->move(public_path('uploads'), $file_name);
        } else {

            $file_name = $logo->image;
        }
        $form_data['image'] =  $file_name;
        if ($logo->update($form_data)) {
            return redirect()->route('admin.logo.index')->with('success', 'Sửa thành công');
        }
        return redirect()->back()->with('error', 'Sửa không thành công!');
    }
}
