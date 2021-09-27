
@extends('layout.admin')

@section('title', 'Chỉnh sửa ảnh khác Sản phẩm')


@section('main')

            <form class="form-horizontal" method="POST" action="{{route('image.update',$image->id)}}" enctype="multipart/form-data">
                @csrf @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inputEmail3">Ảnh khác sản phẩm </label>
                            <span class="btn btn-success col fileinput-button">
                                <i class="fas fa-plus"></i>
                                <span>Chọn ảnh</span>
                            </span>
                            @error('upload')
                            <p style="color: red;" class="help-block">{!!$message!!}</p>
                        @enderror
                            <?php
                                    $pro_img_link = public_path('uploads').'/'.$image->image;
                                    $no_img_link = 'public/admin/dist/img/show.jpg';
                                    $img_link = $image->image ? url('public/uploads').'/'.$image->image : $no_image_link;
                                    $img_link = file_exists($pro_img_link) ? $img_link : $no_img_link;
                                    ?>
                                    <img class="mt-2" src="{{$img_link}}" id="show_img" style="width:100%" alt="">
                                    <input type="file" class="form-control" id="select_file" name="upload" style="display: none">
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

@section('js')

<script>

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

</script>
@stop()


