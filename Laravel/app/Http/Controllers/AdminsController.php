<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admins;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminsController extends Controller
{
    public function index()
    {
        // $data = Admins::all();
        $data = Admins::search()->paginate(3);
        $orderByOptions = [
            'id-ASC'=> 'ID tăng dần',
            'id-DESC'=> 'ID giảm dần',
            'name-ASC'=> 'Tên tăng dần',
            'name-DESC'=> 'Tên giảm dần',
            'created_at-ASC'=> 'Created at A - Z',
            'created_at-DESC'=> 'Created at Z - A',
        ];
        return view('admin.admin.index', compact('data','orderByOptions'));
    }
    public function create()
    {
        return view('admin.admin.create');
    }
    public function add(Request $request)
    {
        //Validate dữ liệu
        $rules = [
            'name' => 'required|unique:admin',
            'email' => 'required|email|unique:admin',
            'phone' => 'required|numeric|digits:10',
            'password' => 'required|size:6',
        ];

        $mag = [
            'name.required' => 'Tên người quản trị viên không được để trống',
            'name.unique' => 'Tên người quản trị <b>'.$request->name.'</b> đã tồn tại trong CSDL',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email <b>'.$request->email.'</b> đã tồn tại trong CSDL',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.numeric' => 'Số điện thoại không được dùng ký tự',
            'phone.digits' => 'Số điện thoại bắt buộc phải 10 số',
            'password.required' => 'Mật khẩu không được để trống',
            'password.size' => 'Mật khẩu bắt buộc phải 6 ký tự',
        ];
        $request->validate($rules, $mag);

        //Lấy dữ liệu
        // $form_data = $request->only('name', 'email', 'phone', 'password');
        //Lưu vào CSDL

        $added = Admins::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        if ($added) { //chưa vào đc đây đâu
            return redirect()->route('admin.index')->with('success', 'Thêm mới tài khoản thành công!');;
        } else {
            return  redirect()->back();
        }
    }


    public function edit(Admins $adm)
    {
        return view('admin.admin.edit', compact('adm'));
    }
    public function update($adm,Request $request)
    {
        //Validate dữ liệu
        $rules = [
            'name' => 'required|unique:admin,name,'.$adm,
            'email' => 'required|email|unique:admin,email,'.$adm,
            'phone' => 'required|numeric|digits:10',
            'password' => 'required|size:6',
        ];

        $mag = [
            'name.required' => 'Tên người quản trị viên không được để trống',
            'name.unique' => 'Tên người quản trị <b>'.$request->name.'</b> đã tồn tại trong CSDL',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email <b>'.$request->email.'</b> đã tồn tại trong CSDL',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.numeric' => 'Số điện thoại không được dùng ký tự',
            'phone.digits' => 'Số điện thoại bắt buộc phải 10 ký tự',
            'password.required' => 'Mật khẩu không được để trống',
            'password.size' => 'Mật khẩu bắt buộc phải 6 ký tự',
        ];
        $request->validate($rules, $mag);
        //Lấy dữ liệu
        $form_data = Admins::find($adm);
        // dd($cat);
        $form_data ->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        //Lưu vào CSDL

        if( $form_data){ //chưa vào đc đây đâu
            return redirect()->route('admin.index')->with('success', 'Cập nhật tài khoản thành công!');;
        }else{
            return  redirect()-> back();
        }
    }
        public function destroy(Admins $adm)
    {
        $adm->delete();
        return redirect()->route('admin.index')->with('success', 'Xóa tài khoản thành công!');
    }
     //Xóa nhiều sản phẩm, xóa vĩnh viễn
    public function forceDelete($id)
    {
        $admin = Admins::withTrashed()->find($id);
        $admin->forceDelete();
        return redirect()->route('admin.index')->with('success', 'Xóa vĩnh viễn danh mục thành công!');
    }

    //Xoa nhiều bên index rồi nhảy sang thùng rác
    public function clear(Request $req)
    {
        $ids = $req->id;
        $n = 0;
        $n1 = 0;
        foreach($ids as $id){
            $admin = Admins::find($id);
            if($admin){
                $admin->delete();
                $n ++;

            }else{
                $n1 ++;

            }

        }

        return redirect()->route('admin.index')->with('success','Đã xóa '.$n.' quản trị viên và có '.$n1.' quản trị viên không thể xóa');

    }
        //Thùng rác
    public function trashed()
    {
        $data = Admins::onlyTrashed()->paginate(3);
        return view('admin.admin.trashed', compact('data'));
    }
    //Khôi phục nhiều cái
    public function restore($id)
    {
        $adm = Admins::withTrashed()->find($id);
        $adm->restore();
        return redirect()->route('admin.index')->with('success', 'Khôi phục thành công!');
    }
    //Khôi phục nhiều
    public function restoreAll(Request $request)
    {
        $ids = $request->id;
        foreach($ids as $id){
            $adm = Admins::withTrashed()->find($id);
            if($adm){
                $adm->restore();

            }
        }
        return redirect()->route('admin.index')->with('success','Đã Khôi Phục thành công');
    }
//Xóa nhiều bên thùng rác
    public function deleteAll(Request $req)
    {
        $ids = $req->id;
        foreach ($ids as $id) {
            $admin = Admins::withTrashed()->find($id);
            if ($admin) {
                $admin->forceDelete();
            }
        }

        return redirect()->route('admin.index')->with('success', 'Đã xóa vĩnh viễn thành công');
    }
}
