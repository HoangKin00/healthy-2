
@extends('layout.admin')

@section('title', 'Sản phẩm')


@section('main')

<div class="row">

        <form action="" class="form-inline" role="form">

            <div class="form-group">
                <input class="form-control " name="key" type="search" placeholder="Tìm kiếm" aria-label="Search"  value="{{request()->key}}">
            </div>
            <select name="order" id="input" class="form-control">
                <option value="">Sắp xếp</option>
                @foreach($orderByOptions as $key => $value)
                <option value="{{$key}}" {{request()->order == $key ? 'selected' : ''}}>{{$value}}</option>
                @endforeach
            </select>
            <select name="cat" class="form-control">
                <option value="">Danh mục</option>
                @foreach ($cats as $cat)
                <option value="{{$cat->id}}" {{request()->cat == $cat->id ? 'selected' :''}}>{{$cat->name}}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-info"><i class="fas fa-search"></i></button>
            <a href="{{route('product.create')}}"class="btn btn-success ml-2"><i class="fas fa-plus-circle"></i> Thêm mới</a>
            <a href="" class="btn btn-danger btn-delete-all ml-2">Xóa lựa chọn <i class="fas fa-trash"></i></a>
        </form>
  
        <a href="{{route('product.trashed')}}" class="btn btn-warning ml-2">Thùng rác <i class="fas fa-trash-restore"></i></a>

</div>

<br>
<form action="{{route('product.deleteAll')}}" id="formDeleteAll" method="post">
    @csrf @method('DELETE')
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>
                <div class="icheck-danger d-inline">
                    <input type="checkbox" id="check_All">
                    <label for="check_All"></label>
                </div>
            </th>
            <th>Mã</th>
            <th>Tên</th>
            <th>Ảnh</th>
            <th>Danh mục</th>
            <th>Giá</th>
            <th>Trạng thái</th>
            <th>Ngày tạo</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $dt)
        <tr>
            <td>
                <div class="icheck-danger d-inline">
                    <input type="checkbox" id="item-{{$dt->id}}" class="check_item"  name="id[]" value="{{$dt->id}}">
                    <label for="item-{{$dt->id}}"></label>
                </div>
            </td>
            <td>{{$dt -> id}}</td>
            <td>{{$dt -> name}}</td>
            <td>
                <img src="{{ url('public/uploads') }}/{{$dt -> image}}" width="70">
            </td>
            <td>{{$dt->cat->name}}</td>
            <td>{{number_format($dt -> price)}} đ</td>
            <td>{{$dt->status == 1 ? 'Còn hàng' : 'hết hàng'}}</td>
            <td>{{$dt -> created_at ? $dt -> created_at -> format('d-m-Y') : 0}}</td>
            <td>
                    <a href="{{route('product.edit',$dt -> id)}}" class="btn btn-sm btn-primary float-right"><i class="fas fa-edit"></i></a>
                    <a href="{{route('product.delete',$dt-> id)}}" style="margin: 0 7px;" 
                        class="btn btn-sm btn-danger btn-sing-delete float-right"><i class="fas fa-trash"></i></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</form>
<br>
<div class="text-center">
    {{$data ->appends(request()->all()) -> links()}}
</div>

<form action="" method="post" id="singDelete">
    @csrf @method('DELETE')
</form>

@stop()

@section('css')
<link rel="stylesheet" href="{{url('public/admin/plugins')}}/icheck-bootstrap/icheck-bootstrap.min.css">
@stop()

@section('js')
<script>
    $('.btn-delete-all').hide();
    $('input#check_All').click(function(){
        var ischeck = $(this).is(':checked');
        if(ischeck){
            $('input.check_item').prop('checked', true);
            $('.btn-delete-all').show();
        }else{
            $('input.check_item').prop('checked', false);
            $('.btn-delete-all').hide();
        }
    })

    $('input.check_item').click(function(){
        var ischeckLeng = $('input.check_item:checked').length;
        if(ischeckLeng > 0){
            $('.btn-delete-all').show();
        }else{
            $('.btn-delete-all').hide();
        }
    })

    //sự kiện xóa một sp
    $('a.btn-sing-delete').click(function(ev){
        ev.preventDefault();
        var href = $(this).attr('href');
        $('form#singDelete').attr('action',href);
        if(confirm('Bạn muốn xóa sản phẩm này!')){
            $('form#singDelete').submit();
        }
    })
    $('.btn-delete-all').click(function(ev){
        ev.preventDefault();
        if(confirm('Bạn muốn xóa những sản phẩm đã lựa chọn !')){
            $('form#formDeleteAll').submit();        }
        
    })
    
</script>
@stop()