@extends ('layout.admin')
@section('title','Tài Khoản')
@section('main')
<div class="container">
    <div class="d-flex">
         <a href="{{route('customer.index')}}" style="float: right" class="btn btn-secondary"><i
                class="fas fa-arrow-left ml-2"></i>Quay lại</a>
        <a href="" type="button" class="btn btn-warning btn-restore-all ml-2"><i class="fas fa-window-restore"></i>Khôi phục sản phẩm</i></a>
        <a href="" type="button" class="btn btn-danger btn-delete-all ml-2"><i class="fas fa-trash nav-icon"> Xóa lựa chọn </i></a>
    </div>
    <hr>
    <form action="{{route('customer.retrieve')}}" method="POST" id="formRestore">
        @csrf @method('GET')
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>
                        <div class="icheck-success d-inline">
                            <input type="checkbox" id="check_all">
                            <label for="check_all">
                            </label>
                        </div>
                    </th>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Deleted at</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data1 as $cus)
                <tr>
                    <td>
                        <div class="icheck-success d-inline">
                            <input type="checkbox" name="id[]" value="{{$cus->id}}" id="item-{{$cus->id}}" class="check_item">
                            <label for="item-{{$cus->id}}">
                            </label>
                        </div>
                    </td>
                    <td scope="row">{{$cus->id}}</td>
                    <td>{{$cus->name}}</td>
                    <td>{{$cus->email}}</td>
                    <td>{{$cus->created_at ? $cus->created_at->format('d-m-Y') : ''}}</td>
                    <td>{{$cus->deleted_at ? $cus->deleted_at->format('d-m-Y') : ''}}</td>
                    <td>
                        <div class="d-flex">
                            <a href="{{route('customer.restore',$cus->id)}}" title="Phục hồi" class="btn btn-warning" style="margin-right: 10px;"><i class="fas fa-undo-alt"></i></a>
                            <a href="{{route('customer.forceDelete',$cus->id)}}" onclick="return confirm('Bạn có chắc muốn xóa không?');" class="btn btn-danger btn-delete"><i class="fas fa-trash"></i></a>
                        </div>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </form>
    <div class="text-center">
        {{$data1 -> links()}}
    </div>
</div>
<form action="{{route('customer.deleteAll')}}" method="POST" id="formDeleteAll" value="">
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
             $('a.btn-delete-all').show();
        } else {
            $('input.check_item').prop('checked', false);
            $('a.btn-restore-all').hide();
            $('a.btn-delete-all').hide();
        }
    });
    $('input.check_item').click(function() {

        var isCheckLength = $('input.check_item:checked').length;
        if (isCheckLength > 0) {
              $('a.btn-restore-all').show();
             $('a.btn-delete-all').show();
        } else {
            $('a.btn-restore-all').hide();
            $('a.btn-delete-all').hide();
        }
    });

    $('a.btn-restore-all').click(function(ev) {
        ev.preventDefault();
        if (confirm('Bạn có muốn khôi phục không?')) {
            $('form#formRestore').submit();
        }
    })
    //xóa nhiều sp
    $('input.check_item').click(function() {
        $('#idDelete').html('');
        $('input.check_item').each(function() {
            if ($(this).is(':checked')) {
                var input = $(this).attr('value');
                var id_input = '<input type="hidden" name="id[]" value="' + input + '">';
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
