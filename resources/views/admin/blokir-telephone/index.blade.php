@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
<h1>Data <small>Blokir Telephone</small></h1>
<ol class="breadcrumb">
 	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
 	<li class="active">Blokir Telephone</li>
</ol>
</section>
<section class="content">
    <div class="row hidden-xs hidden-sm">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title"><span class="hidden-xs">Data Blokir Telephone </span></h3>
               <div class="box-tools">
                <a href="#" class="btn-loading btn btn-primary pull-right modal-open" data-id="" data-toggle="modal" data-target="#myModal" style="padding: 3px 7px;"><i class="fa fa-plus"></i> Tambah Data</a>
               </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
               <table id="DataTable" class="table table-hover">
                  <thead>
                  <tr class="custom__text-green">
                     <th>No</th>
                     <th>ID</th>
                     <th>Phone</th>
                     <th>Date</th>
                     <th>Action</th>
                  </tr>
                  </thead>
                  <tbody class="read">
                  <?php $no=1; ?>
                  @foreach($blockPhoneWeb as $data)
                  <tr>
                     <td>{{$no++}}</td>
                     <td>#{{$data->id}}</td>
                     <td>{{$data->phone}}</td>
                     <td>{{date("d M Y H:i:s", strtotime($data->updated_at))}}</td>
                     <td>
                        <form method="POST" action="{{ route('admin.blokir.telephone.destroy', $data->id) }}" accept-charset="UTF-8">
                           <input name="_method" type="hidden" value="DELETE">
                           <input name="_token" type="hidden" value="{{ csrf_token() }}">
                           <a href="#" data-id="{{$data->id}}" data-phone="{{$data->phone}}" data-toggle="modal" data-target="#myModalEdit" class="btn-loading btn btn-success btn-sm" style="padding: 3px 7px;"><i class="fa fa-pencil"></i></a>
                           <button class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 3px 7px;"><i class="fa fa-trash"></i></button>
                        </form>
                     </td>
                  </tr>
                  @endforeach
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
                    <h3 class="box-title">Blokir Telephone</h3>
                    <div class="box-tools">
                        <a href="#" class="btn-loading btn btn-primary pull-right modal-open" data-id="" data-toggle="modal" data-target="#myModal" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a>
               
                    </div>
                </div><!-- /.box-header -->
                <div class="box-body" style="padding: 0px">
                    <table class="table">
                        @foreach($blockPhoneMobile as $data)
                        <tr>
                            <td>
                               <span style="font-size: 15px;font-weight: bold;">#{{$data->id}}</span><br>
                               <span>{{$data->phone}}</span><br>
                               <span>{{date("d M Y H:i:s", strtotime($data->updated_at))}}</span>
                            </td>
                            <td>
                                <a href="#" data-id="{{$data->id}}" data-phone="{{$data->phone}}" data-toggle="modal" data-target="#myModalEdit" class="btn-loading btn btn-success btn-sm btn-block" style="padding: 2px 5px;font-size:10px;"><i class="fa fa-pencil"></i> Edit</a>
                                <form method="POST" action="{{ route('admin.blokir.telephone.destroy', $data->id) }}" accept-charset="UTF-8">
                                   <input name="_method" type="hidden" value="DELETE">
                                   <input name="_token" type="hidden" value="{{ csrf_token() }}">
                                   <div><button class="btn btn-danger btn-sm btn-block" onclick="return confirm('Anda yakin akan menghapus data ?');" type="submit" style="padding: 2px 5px;font-size:10px;"><i class="fa fa-trash"></i> Hapus</button></div>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer" align="center" style="padding-top:13px;">
                   @include('pagination.default', ['paginator' => $blockPhoneMobile])
               </div>
            </div><!-- /.box -->
        </div>
    </div>
</section>


    <div id="myModal" class="modal fade" role="dialog">
       <div class="modal-dialog">
    	<!-- konten modal-->
    	<div class="modal-content">
    		<!-- heading modal -->
    		<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal">&times;</button>
    			<h4 class="modal-title">Tambah Data</h4>
    		</div>
    		<!-- body modal -->
    		<div class="modal-body">
    			<form action="{{route('admin.blokir.telephone.store')}}" method="post">
                {{ csrf_field() }}
                  <div class="box-body">
                     <div class="form-group">
                        <label>Phone :</label>
                        <textarea class="form-control" rows="7" name="phone" id="phone" placeholder="Isi Phone dan pisahkan dengan tanda koma (,). exp : 085800000000,081226448012,089866545412" required></textarea>
                     </div>
                  </div>
                 <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
        		</div>
               </form>
    		</div>
    		<!-- footer modal -->
    		
    	</div>
       </div>
    </div>    
    
    <div id="myModalEdit" class="modal fade" role="dialog">
       <div class="modal-dialog">
    	<!-- konten modal-->
    	<div class="modal-content">
    		<!-- heading modal -->
    		<div class="modal-header">
    			<button type="button" class="close" data-dismiss="modal">&times;</button>
    			<h4 class="modal-title">Update Data</h4>
    		</div>
    		<!-- body modal -->
    		<div class="modal-body">
    			<form action="{{route('admin.blokir.telephone.update')}}" method="post">
                {{ csrf_field() }}
                  <div class="box-body">
                     <div class="form-group hidden">
                        <label>ID :</label>
                        <input type="text" name="id" id="id" class="form-control" readonly>
                     </div>
                     <div class="form-group">
                        <label>Phone :</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                  </div>
                 <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
        		</div>
               </form>
    		</div>
    		<!-- footer modal -->
    		
    	</div>
       </div>
    </div>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
    $(function () {
       $('#DataTable').DataTable({
         "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
         "iDisplayLength": 50,
         "searching": true,
         "lengthChange": false,
         "info": false
       });
    });
    
    $("#myModal").on("hidden.bs.modal", function(){
        $('#phone').val('');
    });
    
    $(function () {
      $("#myModalEdit").on("show.bs.modal", function (event) {
        var button = $(event.relatedTarget);
        var code = button.data("id");
        var phone = button.data("phone");
        
        var modal = $(this);
        modal.find("#id").val(code);
        modal.find("#phone").val(phone);
      });
    });
});
</script>
@endsection