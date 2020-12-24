@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
<h1>Data <small>Users</small></h1>
<ol class="breadcrumb">
 	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
 	<li class="active">Users</li>
</ol>
</section>
<section class="content">
    <div class="row hidden-xs hidden-sm">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title"><span class="hidden-xs">Data Users (Member)</span></h3>
               <div class="box-tools">
                  <a href="{{route('users.create')}}" class="btn-loading btn btn-primary" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>
               </div>
            </div><!-- /.box-header -->
            <div class="box-body">
               <table id="DataTable" class="table table-hover">
                  <thead>
                  <tr class="custom__text-green">
                     <th>No</th>
                     <th>Nama</th>
                     <th>Email</th>
                     <th>No HP</th>
                     <th>Kota</th>
                     <th>Pin</th>
                     <th>Saldo</th>
                     <th>Status</th>
                     <th>Akses</th>
                     <th>Date Reg</th>
                     <th colspan="3">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                      
                  </tbody>
               </table>
            </div><!-- /.box-body -->
         </div>
      </div>
    </div>
    <div class="row hidden-lg hidden-md">
        <div class="col-xs-12">
            <div class="box"> 
                <div class="box-header">
                    <h3 class="box-title">Data Users (Member)</h3>
                    <div class="box-tools">
                        <a href="{{route('users.create')}}" class="btn-loading btn btn-primary" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body" style="padding: 0px">
                    <table class="table">
                        @foreach($usersMobile as $data)
                        <tr>
                            <td width="50px" rowspan="2">
                                @if($data->image != null)
                                <img src="{{asset('admin-lte/dist/img/avatar/'.$data->image)}}" style="display: inline;width: 40px;">
                                @else
                                <img src="{{asset('admin-lte/dist/img/avatar5.png')}}" style="display: inline;width: 40px;">
                                @endif
                            <td>
                               <span style="font-size: 15px;font-weight: bold;">{{$data->name}}</span><br>
                               <span>{{$data->phone}}</span>
                            </td>
                            <td align="right" >
                                <div style="font-size:12px;"><small> {{$data->roles()->first()['display_name']}}</small></div>
                                @if($data->status == 1)
                                <div><label class="label label-success">AKTIF</label></div>
                                @else
                                <div><label class="label label-danger">NONAKTIF</label></div>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td style="border-style: none;padding-top: 0px;">
                                <div style="font-size:15px;"><small><label class="label label-default">Rp {{number_format($data->saldo, 0, '.', '.')}}</label></small></div>
                                <div>{{$data->city}}</div>
                                <div><small>{{$data->email}}</small></div>
                            </td>
                            <td align="right" style="border-style: none;padding-top: 0px;">
                                <div style="margin-bottom:5px;"><a href="{{route('users.show', $data->id)}}" class="btn-loading btn btn-warning btn-sm detail btn-block" style="padding: 2px 5px;font-size:10px;">Detail</a></div>
                                <div style="margin-bottom:5px;"><a href="{{route('users.edit', $data->id)}}" class="btn-loading btn btn-success btn-sm btn-block" style="padding: 2px 5px;font-size:10px;">Ubah</a></div>
                                <!--<form method="POST" action="{{ route('users.destroy', $data->id) }}" accept-charset="UTF-8">-->
                                <!--   <input name="_method" type="hidden" value="DELETE">-->
                                <!--   <input name="_token" type="hidden" value="{{ csrf_token() }}">-->
                                <!--   <div><button class="btn btn-danger btn-sm btn-block" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;font-size:10px;">Hapus</button></div>-->
                                <!--</form>-->
                            </td>
                        </tr>
                        
                        @endforeach
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer" align="center" style="padding-top:13px;">
                   @include('pagination.default', ['paginator' => $usersMobile])
               </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>
@endsection
@section('js')
<script type="text/javascript">
//$(document).ready(function() {
    var table = $('#DataTable').DataTable({
        deferRender: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        info: false,
        ajax:{
            url : "{{ route('get.admin.users.datatables') }}",
            dataType: "json",
            type: "POST",
            data:{ _token: "{{csrf_token()}}"}
        },
        
        columns:[
                  {data: 'no', width: "50px", sClass: "text-left", orderable: false},
                  {data: 'name', defaulContent: '-'},
                  {data: 'email', defaulContent: '-'},
                  {data: 'phone', defaulContent: '-'},
                  {data: 'city', defaulContent: '-' },
                  {data: 'pin', defaulContent: '-' },
                  {data: 'saldo', defaulContent: '-', sClass: "text-right"},
                  {data: 'status', defaulContent: '-' },
                  {data: 'akses', defaulContent: '-' },
                  {data: 'created_at', defaulContent: '-' },
                  {data: 'action_view', defaulContent: '-' },
                  {data: 'action_edit', defaulContent: '-' },
                   {data: 'action_lock', defaulContent: '-' },
                ]
     });
//});
var tableReload = $('#DataTable').DataTable();
function buttonLock(selector){
    var trans_id = $(selector).data('transId');
    // console.log(trans_id);
    $.blockUI({ css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } }); 
    $.ajax({
        url: "{{route('lock.admin.users')}}",
        type: 'POST',
        data:{_token:"{{csrf_token()}}",id:trans_id},
        success: function(response){
            tableReload.ajax.reload(null,false);
            $.unblockUI();
        }
    });
    
}    

function buttonUnlock(selector){
    var trans_id = $(selector).data('transId');
    // console.log(trans_id); 
    $.blockUI({ css: { 
        border: 'none', 
        padding: '15px', 
        backgroundColor: '#000', 
        '-webkit-border-radius': '10px', 
        '-moz-border-radius': '10px', 
        opacity: .5, 
        color: '#fff' 
    } }); 
    $.ajax({
        url: "{{route('unlock.admin.users')}}",
        type: 'POST',
        data:{_token:"{{csrf_token()}}",id:trans_id},
        success: function(response){
            tableReload.ajax.reload(null,false);
            $.unblockUI();
        }
    });
}
</script>
@endsection