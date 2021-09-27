@extends ('layout.admin')
@section('title','Sửa tài khoản')
@section('main')
<div class="container">
    <div class="col-8">
        <div class="card card-primary">
            <form action="{{route('customer.update', $cus->id)}}" method="POST">
            @csrf @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Tên Người Dùng</label>
                        <input type="" name="name" class="form-control" id="exampleInputEmail1" placeholder="Tên Người Dùng"  value="{{$cus->name}}" >
                        @error('name')<small style="color: red;">*{!!$message!!}</small> @enderror

                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Email</label>
                        <input type="email" name="email" class="form-control" id="exampleInputPassword1" placeholder="Email" value="{{$cus->email}}">
                        @error('email')<small style="color: red;">*{{$message}}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" value="{{$cus->password}}">
                        @error('password')<small style="color: red;">*{{$message}}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Số Điện Thoại</label>
                        <input type="" name="phone" class="form-control" id="exampleInputPassword1" placeholder="Số Điện Thoại" value="{{$cus->phone}}">
                        @error('phone')<small style="color: red;">*{{$message}}</small> @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Địa Chỉ</label>
                        <input type="" name="address" class="form-control" id="exampleInputPassword1" placeholder="Địa Chỉ" value="{{$cus->address}}">
                        @error('address')<small style="color: red;">*{{$message}}</small> @enderror
                    </div>
                   <div class="form-group">
                        <label for="exampleInputBirthday1"><strong>Ngày sinh *</strong></label>
                        <input type="date" class="form-control" id="exampleInputBirthday1"
                            placeholder="Nhập ngày sinh tại đây..." name="birthday" value="{{$cus->birthday}}" ;>
                        @error('birthday')
                        <small style="color : red;">{{$message}}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Giới tính:</label>
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" id="input" value="0" {{ $cus->gender == 0 ? 'checked' : ''}}>
                               Đồng tính nữ 
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" id="input" value="1" {{ $cus->gender == 1 ? 'checked' : ''}}>
                               Đồng tính nam
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" id="input" value="2" {{ $cus->gender == 2 ? 'checked' : ''}}>
                                Song tính
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="gender" id="input" value="3" {{ $cus->gender == 3 ? 'checked' : ''}}>
                                Chuyển giới
                            </label>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                    <a href=""> <button type="submit" class="btn btn-info"><i class="fas fa-save"></i>Lưu
                            Lại</button></a>
                    <a href="{{route('customer.index')}}"> <button type="submit" class="btn btn-default float-right"><i class="fas fa-arrow-left"></i>Bỏ qua</button></a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop()
