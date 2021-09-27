@extends ('layout.admin')
@section('title','Thêm Mới banner')
@section('main')
<div class="container">
    <div class="col-8">
        <div class="card card-info">

            <!-- /.card-header -->
            <!-- form start -->

            <form class="form-horizontal" action="{{route('banner.add')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card-body">
                <div class="form-group">
                            <label for="exampleInputEmail1">Tiêu đề banner</label>
                            <input type="" class="form-control" id="exampleInputEmail1" placeholder="Tiêu đề banner"
                                name="title" value="{{old('title')}}">
                            @error('title')<p style="color: red;">*{!!$message!!}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Trạng Thái:</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" id="input" value="0" >
                                    Ẩn
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" id="input" value="1" checked>
                                   Hiển Thị
                                </label>
                            </div>
                        </div>
                    <div class="form-group">
                        <span class="btn btn-success col fileinput-button">
                            <i class="fas fa-plus"></i>
                            <span>Add files</span>
                        </span>
                        <img src="https://rpfinancelk.com/wp-content/uploads/2020/12/no-image-available-icon-photo-camera-flat-vector-illustration-132483097.jpg" id="show_img" width="100%" >
                        <input type="file" name="file_upload" id="select_file" value="{{old('file_upload')}}" style="display:none">
                            @error('file_upload')<p style="color: red;">*{{$message}}</p> @enderror
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href=""> <button type="submit" class="btn btn-info"><i class="fas fa-save"></i>Lưu
                            Lại</button></a>
                    <a href="{{route('banner.index')}}"> <button type="submit" class="btn btn-default float-right"><i class="fas fa-arrow-left"></i>Bỏ qua</button></a>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
</div>
@stop
@section('js')
<script>
$('.fileinput-button').click(function(){
    $('#select_file').click();
})
$('#select_file').change(function(){
    var file = $(this)[0].files[0];
    var reader = new FileReader();
    reader.onload = function(ev){
        $('img#show_img').attr('src',ev.target.result);
    }
    reader.readAsDataURL(file);
})
</script>

@stop
