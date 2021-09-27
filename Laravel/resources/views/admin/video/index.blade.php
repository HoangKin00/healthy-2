@extends('layout.admin')
@section('title','Video')
@section('main')
    
<form action=""  class="form-inline" role="form">
    <div class="form-group">
        <input  name="key"  class="form-control" placeholder="Bạn đang tìm ?" value="{{request()->key}}">
    </div>
    <select name="order" class="form-control">
        <option value="">Sắp xếp</option>
        @foreach($orderByOptions as $key => $value)
        <option value="{{$key}}" {{request()->order == $key ? 'selected' : ''}}>{{$value}}</option>
        @endforeach
    </select>
    <select name="cat" class="form-control">
        <option value="">Danh mục</option>
        @foreach($data1 as $cat)
        <option value="{{$cat->id}}" {{request()->cat == $cat->id ? 'selected' : ''}}>{{$cat->name}}</option>
        @endforeach
    </select>
    <select name="status" class="form-control">
        <option value="">Trạng thái</option>
        <option value="2" {{request()->status == 02 ? 'selected' : ''}}>Ẩn</option>
        <option value="1" {{request()->status == 1 ? 'selected' : ''}}>Hiển Thị</option>
    </select>
    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
    <a href="{{route('video.create')}}" class="btn btn-warning ml-2"><i class="fas fa-plus">Thêm mới</i></a>
    <a href="" type="button" class="btn btn-danger btn-delete-all ml-2"><i class="fas fa-trash nav-icon"> Xóa lựa chọn </i></a>
</form>
<hr>
    <div class="container">
       <form action="{{route('video.clear')}}" method="POST" id="formDeleteAll"> 
       @csrf @method('DELETE')
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
                        <a href="{{route('video.edit', $vid->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"> Sửa</i></a>
                        <a href="{{route('video.destroy',$vid->id)}}"   onclick="return confirm('Bạn có chắc muốn xóa không?');" class="btn btn-danger btn-sm btn-single-delete"><i class="fas fa-trash"> Xóa</i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </form>
        <hr>
        {{$data->links()}}
    </div>
<form action="" method="POST" id="singleDelete">
    @csrf @method('DELETE')
 </form>
@stop
@section('css')
 <!-- iCheck for checkboxes and radio inputs -->
 <link rel="stylesheet" href="{{ url('public/admin') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@stop
@section('js')
<script>
     $('a.btn-delete-all').hide()
    $('input#check_all').click(function(){
        var isCheck = $(this).is(':checked');
        if (isCheck){
            $('input.check_item').prop('checked',true);
            $('a.btn-delete-all').show();
        }else{
            $('input.check_item').prop('checked',false);
            $('a.btn-delete-all').hide();
        }
    });
    $('input.check_item').click(function(){
       
        var isCheckLength = $('input.check_item:checked').length;
            if(isCheckLength > 0){
                $('a.btn-delete-all').show();
            }else{
                $('a.btn-delete-all').hide();
        }
    });


    $('a.btn-single-delete').click(function(ev){
        ev.preventDefault();
        var href = $(this).attr('href');
        $('form#singleDelete').attr('action',href);
        if( confirm('Bạn có muốn xóa ?')){
            $('form#singleDelete').submit();
        }
    })

    $('a.btn-delete-all').click(function(ev){
        ev.preventDefault();
        // $('form#formDeleteAll').submit();
        if( confirm('Bạn có muốn xóa ?')){
            $('form#formDeleteAll').submit();
        }
    })
</script>
@stop