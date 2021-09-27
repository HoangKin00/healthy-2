@extends ('layout.admin')
@section('title','Sửa Danh Mục Sản Phẩm')
@section('main')
<div class="container">
    <div class="col-8">
        <div class="card card-info">

            <!-- /.card-header -->
            <!-- form start -->

            <form class="form-horizontal" action="{{route('categoryProduct.update', $cat->id)}}" method="POST">
                @csrf @method('PUT')
                <input type="hidden" name="id" value="$cat->id">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Tên DM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputEmail3" placeholder="Tên Danh Mục"
                                name="name" value="{{$cat->name}}">
                            @error('name')<p style="color: red;">*{!!$message!!}</p> @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                            <div class="form-check">
                                <input type="radio" name="status" id="input" value="1"
                                    {{ $cat->status == 0 ? 'checked' : ''}}>
                                <label class="form-check-label" for="inlineRadio1">Ẩn</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="status" id="input" value="2"
                                    {{$cat->status == 1 ? 'checked' : ''}}>
                                <label class="form-check-label" for="inlineRadio1">Hiển Thị</label>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href=""> <button type="submit" class="btn btn-info"><i class="fas fa-save"></i>Lưu
                            Lại</button></a>
                    <a href="{{route('categoryProduct.index')}}"> <button type="submit"
                            class="btn btn-default float-right"><i class="fas fa-arrow-left"></i>Bỏ qua</button></a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@stop