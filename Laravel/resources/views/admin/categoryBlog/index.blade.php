@extends ('layout.admin')
@section('title',' Danh Mục Blog')
@section('main')
<div class="container">
    <div class="d-flex">
        <form class="form-inline">
            <div class="form-group">
                <input class="form-control " name="key" type="search" placeholder="Search" aria-label="Search">
            </div>

            <select name="order" id="input" class="form-control">
                <option value="">Sắp xếp</option>
                @foreach($orderByOptions as $key => $value)
                <option value="{{$key}}" {{request()->order == $key ? 'selected' : ''}}>{{$value}}</option>
                @endforeach
            </select>

            <select name="status" id="input" class="form-control">
                <option value="">Mặc định</option>
                <option value="2" {{request()->status == 2 ? 'selected' : ''}}>Ẩn</option>
                <option value="1" {{request()->status == 1 ? 'selected' : ''}}>Hiển Thị</option>
            </select>

            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
        </form>
        <a href="{{route('categoryBlog.create')}}" type="button" class="btn btn-info" style="margin-left: 15px;"><i class="fas fa-plus"></i>Thêm Mới</a>
        <a href="" type="button" class="btn btn-danger btn-delete-all ml-2"><i class="fas fa-trash nav-icon"> Xóa lựa chọn </i></a>
        <a href="{{route('categoryBlog.trashed')}}" class="btn btn-warning ml-2">Thùng rác <i class="fas fa-trash-restore"></i></a>

    </div>
    <hr>
    <form action="{{route('categoryBlog.clear')}}" method="POST" id="formDeleteAll">
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
                    <th scope="col">STT</th>
                    <th scope="col">Tên DM</th>
                    <th scope="col">Trạng Thái</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $cat)
                <tr>
                    <td>
                        <div class="icheck-success d-inline">
                            <input type="checkbox" name="id[]" value="{{$cat->id}}" id="item-{{$cat->id}}" class="check_item">
                            <label for="item-{{$cat->id}}">
                            </label>
                        </div>
                    </td>
                    <td>{{$cat->id}}</td>
                    <td>{{$cat->name}}</td>
                    <td>{{$cat->status == 0 ? 'Ẩn' : 'Hiển Thị'}}</td>
                    <td>{{$cat->created_at ? $cat->created_at->format('d-m-Y') : ''}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{route('categoryBlog.edit',$cat->id)}}" class="btn btn-primary" style="margin-right: 10px;"><i class="fas fa-edit"></i></a>
                            <a href="{{route('categoryBlog.destroy', $cat->id)}}" class="btn btn-danger btn-delete btn-single-delete"><i class="fas fa-trash"></i></a>
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
