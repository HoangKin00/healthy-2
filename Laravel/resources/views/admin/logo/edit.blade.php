@extends ('layout.admin')
@section('title','Sửa logo')
@section('main')
<div class="container">
    <div class="col-8">
        <div class="card card-info">

            <!-- /.card-header -->
            <!-- form start -->

            <form class="form-horizontal" action="{{route('admin.logo.update', $logo->id)}}" method="POST" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="card-body">
                   
                    <div class="form-group">
                        <span class="btn btn-success col fileinput-button">
                            <i class="fas fa-plus"></i>
                            <span>Chọn ảnh khác</span>
                        </span>
                        <img src="{{url('public/uploads')}}/{{$logo->image}}" id="show_img" width="400" height="400">
                        <input type="file" name="file_upload" id="select_file" value="{{$logo->image}}" style="display:none">
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <a href=""> <button type="submit" class="btn btn-info"><i class="fas fa-save"></i>Lưu
                            Lại</button></a>
                    <a href="{{route('admin.logo')}}"> <button type="submit" class="btn btn-default float-right"><i class="fas fa-arrow-left"></i>Bỏ qua</button></a>
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
