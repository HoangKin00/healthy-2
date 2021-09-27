@extends('layout.admin')
@section('title','LOGO')
@section('main')
    
<hr>
    <div class="container">
       <form action="" method="POST" id=""> 
       @csrf
        <table class="table table-hover">
            <thead>
                <tr>
                    <th >ID</th>
                    <th >Ảnh</th>
                    <th>Ngày thêm </th>
                    <th>Ngày sửa </th>
                    <th></th>
                    
                </tr>
            </thead>
            <tbody>  
                @foreach($data as $logo)
                <tr>
                    <td >{{$logo->id}}</td>
                    <td ><img src="{{url('public/uploads')}}/{{$logo->image}}" alt="" width="150" height="150"></td>
                    <td >{{$logo->created_at}}</td>
                    <td >{{$logo->updated_at}}</td>
                    <td >
                        
                            <a href="{{route('admin.logo.edit',$logo->id)}}" class="btn btn-primary btn-sm"><i class="fas fa-edit"> Sửa</i></a>
                         
                         
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        </form>
        <hr>
    </div>
@stop
@section('css')
 <!-- iCheck for checkboxes and radio inputs -->
 <link rel="stylesheet" href="{{ url('public/admin') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
@stop
