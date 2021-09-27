@extends ('layout.admin')
@section('title',' Thùng rác danh mục Blog')
@section('main')
<div class="container">
    <div class="d-flex">
         <a href="{{route('categoryVideo.index')}}" style="float: right" class="btn btn-secondary"><i
                class="fas fa-arrow-left ml-2"></i>Quay lại</a>
    <a href="" type="button" class="btn btn-warning btn-restore-all ml-2"><i class="fas fa-undo-alt"> Khôi phục lựa chọn
        </i></a>
    <a href="{{route('admin.deleteAll')}} ? is_trashed = true" type="button"
        class="btn btn-danger btn-delete-all ml-2"><i class="fas fa-trash nav-icon"> Xóa lựa chọn </i></a>

    </div>
    <hr>
    <form action="{{route('admin.restoreAll')}}" method="POST" id="formRestoreAll">
    @csrf @method('PUT')
     <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">
                        <div class="icheck-success d-inline">
                            <input type="checkbox" id="check_all">
                            <label for="check_all">
                            </label>
                        </div>
                    </th>
                <th scope="col">ID</th>
                <th scope="col">Tên QTV</th>
                <th scope="col">Email</th>
                <th scope="col">Số diện thoại</th>
                <th scope="col">Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $adm)
            <tr>
                 <td>
                    <div class="icheck-success d-inline">
                        <input type="checkbox" name="id[]" value="{{$adm->id}}" id="item-{{$adm->id}}" class="check_item">
                        <label for="item-{{$adm->id}}">
                        </label>
                    </div>
                </td>
                <th scope="row">{{$adm->id}}</th>
                <td>{{$adm->name}}</td>
                <td>{{$adm->email}}</td>
                <td>{{$adm->phone}}</td>

                <td>
                    <div class="d-flex">
                        <a href="{{route('admin.restore',$cat->id)}}" title="Phục hồi" class="btn btn-warning" style="margin-right: 10px;"><i class="fas fa-undo-alt"></i></a>
                        <a href="{{route('admin.forceDelete', $adm->id)}}" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                    </div>
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
<form action="{{route('admin.deleteAll')}}" method="POST" id="formDeleteAll" value="">
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