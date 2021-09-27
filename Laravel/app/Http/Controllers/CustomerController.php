<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use function Symfony\Component\String\b;

class CustomerController extends Controller
{
    public function index()
    {
        $data1 = Customer::search()->paginate(3);
        $orderByOptions = [
            'id-ASC'=> 'ID tăng dần',
            'id-DESC'=> 'ID giảm dần',
            'name-ASC'=> 'Tên tăng dần',
            'name-DESC'=> 'Tên giảm dần',
            'created_at-ASC'=> 'Created at A - Z',
            'created_at-DESC'=> 'Created at Z - A',
        ];
        return view('admin.customer.index', compact('data1','orderByOptions'));
    }
    public function create()
    {
        return view('admin.customer.create');
    }
    public function add(Request $request)
    {
        //Validate dữ liệu
        $rules = [
            'name' => 'required|unique:customer',
            'email' => 'required|email|unique:customer',
            'phone' => 'required|numeric|digits:10',
            'password' => 'required|size:6',
            'address' => 'required',
            'birthday' => 'required',
        ];

        $mag = [
            'name.required' => 'Tên người dùng không được để trống',
            'name.unique' => 'Tên người dùng <b>' . $request->name . '</b>  đã tồn tại trong CSDL',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.numeric' => 'Số điện thoại không được dùng ký tự',
            'phone.digits' => 'Số điện thoại bắt buộc phải 10 ký tự',
            'password.required' => 'Mật khẩu không được để trống',
            'password.size' => 'Mật khẩu bắt buộc phải 6 ký tự',
            'address.required' => 'Địa chỉ không được để trống',
            'birthday.required' => 'Ngày sinh không được để trống',
            // 'birthday.date_format' => 'Ngày sinh phải đúng định dạng mm/dd/YYYY',
        ];
        $request->validate($rules, $mag);

        //Lấy dữ liệu
        // $form_data = $request->only('name', 'email', 'phone', 'password', 'address', 'birthday', 'gender');
        //Lưu vào CSDL
        $added = Customer::create(
            [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'birthday' => $request->birthday,
            'gender' => $request->gender
            ]
        );

        if ($added) { //chưa vào đc đây đâu
            return redirect()->route('customer.index')->with('success', 'Thêm mới tài khoản thành công');
        } else {
            return  redirect()->back();
        }
    }

    public function destroy(Customer $cus)
    {
        $cus->delete();
        return redirect()->route('customer.index')->with('success', 'Xóa tài khoản thành công!');
    }

    public function edit(Customer $cus)
    {
        return view('admin.customer.edit', compact('cus'));
    }
    public function update( $cus, Request $request)
    {

        // Validate dữ liệu
        $rules = [
            'name' => 'required|unique:customer,name,' . $cus,
            'email' => 'required|email|unique:customer,email,' . $cus,
            'phone' => 'required|numeric|digits:10',
            'password' => 'required|size:6',
            'address' => 'required',
            'birthday' => 'required',
        ];

        $mag = [
            'name.required' => 'Tên người dùng không được để trống',
            'name.unique' => 'Tên người dùng <b>' . $request->name . '</b> đã tồn tại trong CSDL',
            'email.required' => 'Email không được để trống',
            'email.email' => 'Email không đúng định dạng',
            'phone.required' => 'Số điện thoại không được để trống',
            'phone.numeric' => 'Số điện thoại không được dùng ký tự',
            'phone.digits' => 'Số điện thoại bắt buộc phải 10 ký tự',
            'password.required' => 'Mật khẩu không được để trống',
            'password.size' => 'Mật khẩu bắt buộc phải 6 ký tự',
            'address.required' => 'Địa chỉ không được để trống',
            'birthday.required' => 'Ngày sinh không được để trống',
            // 'birthday.date_format' => 'Ngày sinh phải đúng định dạng, VD: 08/07/1999',
        ];
        $request->validate($rules, $mag);
        $form_data = Customer::find($cus);
        $form_data ->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'birthday' => $request->birthday,
                'gender' => $request->gender
                ]);
        if ($form_data) {
            return redirect()->route('customer.index')->with('success', 'Sửa thành công');
        }
        return redirect()->back()->with('error', 'Sửa không thành công!');
    }

    public function trashed()
    {
      $data1 = Customer::onlyTrashed()->paginate(6);
      return view('admin.customer.trashed', compact('data1'));
    }
    public function restore($id)
    {
        $cus = Customer::withTrashed()->find($id);
        $cus->restore();
        return redirect()->route('customer.index')->with('success', 'Khôi phục thành công!');
    }

    public function forceDelete($id)
    {
        $cus = Customer::withTrashed()->find($id);
        $cus->forceDelete();
        return redirect()->route('customer.index')->with('success', 'Xóa vĩnh viễn danh mục thành công!');
    }

    public function clear(Request $req)
    {
        $ids = $req->id;
        foreach($ids as $id){
            $pro = Customer::find($id);
            if($pro){
                $pro->delete();

            }
        }
        return redirect()->route('customer.index')->with('success','Đã xóa tài khoản thành công');

    }

    public function retrieve(Request $request)
    {
        $ids = $request->id;
        foreach($ids as $id){
            $pro = Customer::withTrashed()->find($id);
            if($pro){
                $pro->restore();
            }
        }
        return redirect()->route('customer.index')->with('success', 'Khôi phục thành công!');
    }

    public function deleteAll(Request $req)
    {
        $ids = $req->id;
        foreach ($ids as $id) {
            $pro = Customer::withTrashed()->find($id);
            if ($pro) {
                $pro->forceDelete();
            }
        }

        return redirect()->route('customer.index')->with('success', 'Đã xóa vĩnh viễn thàn công');
    }
}
