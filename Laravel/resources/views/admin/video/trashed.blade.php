@extends ('layout.admin')
@section('title',' Thùng rác danh mục Blog')
@section('main')
<div class="container">
    <div class="d-flex">
    <a href="" type="button" class="btn btn-warning btn-restore-all ml-2"><i class="fas fa-undo-alt"> Khôi phục lựa chọn
        </i></a>
    <a href="{{route('video.forceDeleteAll')}} ? is_trashed = true" type="button"
        class="btn btn-danger btn-delete-all ml-2"><i class="fas fa-trash nav-icon"> Xóa lựa chọn </i></a>

    </div>
    <hr>
    <form action="{{route('video.restoreAll')}}" method="POST" id="formRestoreAll">
    @csrf @method('PUT')
 <table class="table table-hover">
            <thead>
                <tr>
                    <th>
                    <div class="icheck-success d-inline">
                        <input type="checkbox" id="check_all" >
                        <label for="check_all">
                        </label>
                      </div>
                    </th>
                    <th >ID</th>
                    <th >Video</th>
                    <th>Tên </th>
                    <th>Trạng thái</th>
                    <th>Danh mục</th>
                    <th></th>
                    
                </tr>
            </thead>
            <tbody>  
                @foreach($data as $vid)
                <tr>
                    <td>
                    <div class="icheck-success d-inline">
                        <input type="checkbox" name="id[]" value="{{$vid->id}}" id="item-{{$vid->id}}" class="check_item">
                        <label for="item-{{$vid->id}}">
                        </label>
                      </div>
                    </td>
                    <td >{{$vid->id}}</td>
                    <td ><video audio="muted" controls="controls" src="{{url('public/uploads')}}/{{$vid->video}}" alt="" width="150" height="150"></video></td>
                    <td >{{$vid->name}}</td>
                    <td >{{$vid->status == 0 ? 'Ẩn':'Hiển thị'}}</td>
                    <td >{{$vid->categoryVideo->name}}</td>
                    <td >
                            <a href="{{route('video.restore',$vid->id)}}" title="Phục hồi" class="btn btn-warning" style="margin-right: 10px;"><i class="fas fa-undo-alt"></i></a>
                        <a href="{{route('video.forceDelete',$vid->id)}}" onclick="return confirm('Bạn có chắc muốn xóa không?');" class="btn btn-danger btn-sm btn-single-delete"><i class="fas fa-trash"> Xóa</i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </form>
    <div class="text-center">
        {{$data -> links()}}
    </div>
</div>
<form action="{{route('video.forceDeleteAll')}}" method="POST" id="formDeleteAll" value="">
    @csrf @method('DELETE')
    <div id="idDelete"></div>
</form>
@stop()

@section('css')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ url('public/admin') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@stop
@section('js')
<script>
$('a.btn-restore-all').hide()
$('a.btn-delete-all').hide()
$('input#check_all').click(function() {
    var isCheck = $(this).is(':checked');
    if (isCheck) {
        $('input.check_item').prop('checked', true);
        $('a.btn-restore-all').show();
        $('a.btn-delete-all').show()
    } else {
        $('input.check_item').prop('checked', false);
        $('a.btn-restore-all').hide();
        $('a.btn-delete-all').hide();
    }
    $('#idDelete').html('');
    $('input.check_item').each(function() {
        if ($(this).is(':checked')) {
            var input = $(this).attr('value');
            var id_input = '<input type="hidden" name="id[]" value="'+input+'">';
            console.log(id_input);
            $('#idDelete').append(id_input);
        }
    });
});
$('input.check_item').click(function() {

    var isCheckLength = $('input.check_item:checked').length;
    if (isCheckLength > 0) {
        $('a.btn-restore-all').show();
        $('a.btn-delete-all').show()
    } else {
        $('a.btn-restore-all').hide();
        $('a.btn-delete-all').hide();
    }
});


$('a.btn-restore-all').click(function(ev) {
    ev.preventDefault();
    $('form#formRestoreAll').submit();
})

$('input.check_item').click(function(){
    $('#idDelete').html('');
    $('input.check_item').each(function() {
        if ($(this).is(':checked')) {
            var input = $(this).attr('value');
            var id_input = '<input type="hidden" name="id[]" value="'+input+'">';
            console.log(id_input);
            $('#idDelete').append(id_input);
        }
    });
})

$('a.btn-delete-all').click(function(ev) {
    ev.preventDefault();
   
    if (confirm('Bạn có muốn xóa không?')) {
        $('form#formDeleteAll').submit();
    }
})

</script>
@stop