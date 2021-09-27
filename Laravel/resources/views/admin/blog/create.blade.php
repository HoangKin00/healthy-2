@extends ('layout.admin')
@section('title','Thêm Mới Blog')
@section('main')
<div class="container-fluid">
    <div class="">
        <form action="{{ route('blog.add') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-8">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tiêu đề Blog</label>
                            <input type="" class="form-control" id="exampleInputEmail1" placeholder="Tiêu đề blog"
                                name="title" value="{{old('title')}}">
                            @error('title')<p style="color: red;">*{!!$message!!}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội Dung</label>
                            <textarea name="content" class="form-control content-editor"
                                value="{{old('content')}}"> </textarea>
                            @error('content')<p style="color: red;">*{{$message}}</p> @enderror
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Danh mục</label>
                            <select name="categoryBlog_id" id="input" class="form-control">
                                <option value="">Danh mục</option>
                                @foreach($categoryBlog as $cat)
                                <option value="{{$cat->id}}">{{$cat->name}}</option>
                                @endforeach
                            </select>
                            @error('categoryBlog_id')<p style="color: red;">*{{$message}}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Trạng Thái:</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" id="input" value="0">
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
                            <label for="exampleInputFile">Chọn Ảnh</label>
                            <div class="input-group">
                                <span class="btn btn-success col fileinput-button">
                                    <i class="fas fa-plus"></i>
                                    <span>Chọn Ảnh</span>
                                </span>
                                <img src="https://rpfinancelk.com/wp-content/uploads/2020/12/no-image-available-icon-photo-camera-flat-vector-illustration-132483097.jpg"
                                    id="show_img" width="100%">
                                     
                                <input type="file" name="upload_file" id="select_file" value="{{old('file_upload')}}"
                                    style="display:none">
                                     @error('upload_file')<p style="color: red;">*{{$message}}</p> @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <a href=""> <button type="submit" class="btn btn-info"><i class="fas fa-save"></i>Lưu
                        Lại</button></a>
                <a href="{{route('blog.create')}}"> <button type="submit" class="btn btn-default float-right"><i
                            class="fas fa-arrow-left"></i>Bỏ qua</button></a>
            </div>
        </form>
    </div>
</div>
@stop
@section('js')
<script>
$('.fileinput-button').click(function() {
    $('#select_file').click();
})
$('#select_file').change(function() {
    var file = $(this)[0].files[0];
    var reader = new FileReader();
    reader.onload = function(ev) {
        $('img#show_img').attr('src', ev.target.result);
    }
    reader.readAsDataURL(file);
})
</script>

@stop