@extends ('layout.admin')
@section('title','Quản trị viên')
@section('main')
<div class="container">
    <div class="d-flex">
        <form class="form-inline">
            <input class="form-control " name="key" type="search" placeholder="Search" aria-label="Search">
            <select name="order" id="input" class="form-control">
                <option value="">Sắp xếp</option>
                @foreach($orderByOptions as $key => $value)
                <option value="{{$key}}" {{request()->order == $key ? 'selected' : ''}}>{{$value}}</option>
                @endforeach
            </select>
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
        </form>
        <a href="{{route('admin.create')}}" type="button" class="btn btn-info" style="margin-left: 15px;"><i class="fas fa-plus"></i>Thêm Mới</a>
        <a href="" type="button" class="btn btn-danger btn-delete-all ml-2"><i class="fas fa-trash nav-icon"> Xóa lựa chọn </i></a>
        <a href="{{route('admin.trashed')}}" class="btn btn-warning ml-2">Thùng rác <i class="fas fa-trash-restore"></i></a>

    </div>
    <hr>
      <form action="{{route('admin.clear')}}" method="POST" id="formDeleteAll">
        @csrf @method('DELETE')
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
                        <a href="{{route('admin.edit', $adm->id)}}" class="btn btn-primary" style="margin-right: 10px;"><i class="fas fa-edit"></i></a>
                        <a href="{{route('admin.destroy', $adm->id)}}" class="btn btn-danger btn-delete btn-single-delete"><i class="fas fa-trash"></i></a>
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
    <form action="" method="POST" id="singleDelete">
        @csrf @method('DELETE')
    </form>
</div>
@stop()
@section('css')
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="{{ url('public/admin') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@stop
@section('js')
<script>
    $('a.btn-delete-all').hide()
    $('input#check_all').click(function() {
        var isCheck = $(this).is(':checked');
        if (isCheck) {
            $('input.check_item').prop('checked', true);
            $('a.btn-delete-all').show();
        } else {
            $('input.check_item').prop('checked', false);
            $('a.btn-delete-all').hide();
        }
    });
    $('input.check_item').click(function() {

        var isCheckLength = $('input.check_item:checked').length;
        if (isCheckLength > 0) {
            $('a.btn-delete-all').show();
        } else {
            $('a.btn-delete-all').hide();
        }
    });


    $('a.btn-single-delete').click(function(ev) {
        ev.preventDefault();
        var href = $(this).attr('href');
        $('form#singleDelete').attr('action', href);
        if (confirm('Bạn có muốn xóa ?')) {
            $('form#singleDelete').submit();
        }
    })

    $('a.btn-delete-all').click(function(ev) {
        ev.preventDefault();
        if (confirm('Bạn có muốn xóa không?')) {
            $('form#formDeleteAll').submit();
        }
    })
</script>
@stop