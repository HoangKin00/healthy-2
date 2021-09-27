
@extends('layout.admin')

@section('title', 'Thêm mới Sản phẩm')


@section('main')

            <form class="form-horizontal" method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-info">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputEmail3">Tên sản phẩm </label>
                                    <input type="text" class="form-control" name="name" placeholder="Tên sản phẩm" value="{{old('name')}}">
                                    @error('name')
                                    <p style="color: red;">{!!$message!!}</p>
                                @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3">Mô tả sản phẩm </label>
                                    <textarea name="content" class="form-control abc" rows="3" placeholder="Nội dung">{{old('content')}}</textarea>
                                    @error('content')
                                    <p style="color: red;" class="help-block">{!!$message!!}</p>
                                @enderror
                                </div>
                                <div class="form-group">
                                    
                                    <div class="col-md-6">
                                        <label for="inputEmail3">Ảnh khác sản phẩm </label>
                                        <span class="btn btn-success col fileinput-other">
                                            <i class="fas fa-plus"></i>
                                            <span>Chọn ảnh khác</span>
                                        </span>
                                    </div>                                    
                                    <input type="file" class="form-control" id="other_image" name="other_image[]" multiple style="display: none">
                                    <br>
                                    <div id="show_other_img" class="row">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-info">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="inputEmail3">Danh mục </label>
                                    <select name="categoryProduct_id" class="form-control select2"  style="height: auto;">
                                        <option style="height: auto;" value="">Chọn danh mục</option>
                                        @foreach ($cats as $cat)
                                        <option value="{{$cat->id}}" {{old('categoryProduct_id') == $cat->id ? 'selected' :''}}>{{$cat->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('categoryProduct_id')
                                    <p style="color: red;">{!!$message!!}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3">Giá sản phẩm</label>
                                    <input type="text" class="form-control" name="price" placeholder="Nhập giá"  value="{{old('price')}}">
                                    @error('price')
                                    <p style="color: red;">{!!$message!!}</p>
                                @enderror
                                </div>
                                
                                <div class="form-group">
                                    <label for="inputEmail3">Trạng thái </label>
                                    <br>
                                    <input type="checkbox" class="my-status" name="status" checked>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3">Ảnh sản phẩm </label>
                                    <span class="btn btn-success col fileinput-button">
                                        <i class="fas fa-plus"></i>
                                        <span>Chọn ảnh</span>
                                    </span>
                                    @error('upload')
                                    <p style="color: red;" class="help-block">{!!$message!!}</p>
                                @enderror
                                    <img class="mt-2" src="{{url('public/admin/dist')}}/img/show.jpg" id="show_img" style="width:100%" alt="">
                                    <input type="file" class="form-control" id="select_file" name="upload" style="display: none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
 
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu lại</button>
                    <a href="{{route('product.index')}}" class="btn btn-danger float-right"><i class="fas fa-caret-square-left"></i> Quay lại</a>
                </div>
                <!-- /.card-footer -->
            </form>


@stop()
@section('css')
<style>
    .select2-selection--single{
        height: auto !important;
    }
</style>
<link rel="stylesheet" href="{{url('public/admin/plugins')}}/summernote/summernote.min.css">
<link rel="stylesheet" href="{{url('public/admin/plugins')}}/select2/css/select2.min.css">
@stop()
@section('js')
<script src="{{url('public/admin/plugins')}}/summernote/summernote.min.js"></script>
<script src="{{url('public/admin/plugins')}}/select2/js/select2.full.min.js"></script>
<script src="{{url('public/admin/plugins')}}/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script>
$('.abc').summernote({
    height:200
});

$('.select2').select2();

$("input.my-status").each(function(){
    $(this).bootstrapSwitch('state', $(this).prop('checked'))
});

$('.fileinput-button').click(function(){
    $('#select_file').click()
});
$('#select_file').change(function(){
    var file = $(this)[0].files[0];
    var reader = new FileReader();
    reader.onload = function(ev) {
        $('img#show_img').attr('src', ev.target.result)
    }
    reader.readAsDataURL(file);
});

$('.fileinput-other').click(function(){
    $('#other_image').click()
});
$('#other_image').change(function(){
    var files = $(this)[0].files;
    $('#show_other_img').html('');
    if(files && files.length){
        for (let i = 0; i < files.length; i++) {
            const fi = files[i];
            var reader = new FileReader();
            reader.onload = function(ev) {
                var _image = '<div class="col-md-4">';
                _image +='<img src="'+ev.target.result+'" style="width:100%"/>';
                _image +=' </div>';
                $('#show_other_img').append(_image);
            }
            reader.readAsDataURL(fi);
        }
    }
});
</script>
@stop()


