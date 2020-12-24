@extends('layouts.admin')

@section('content')
<style>
  .toolbar {
      float: left;
  }
  .dataTables_length {
      float: left;
  }

  /*.dataTables_processing{*/
  /*    background-color:#0CB4FF;*/
  /*}*/

  .dropdown-menu-left {
      right: auto;
      left: -100px;
  }
</style>
<section class="content-header hidden-xs hidden-sm">
    <h1>Data <small>Validasi Membership</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data Membership</a></li>
        <li class="active">Validasi Membership</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                   <h3 class="box-title">Validasi Membership</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="DataTable"  class="table table-hover table-consended">
                      <thead>
                         <tr class="custom__text-green">
                            <th>No.</th>
                            <th>ID</th>
                            <th>User</th>
                            <th>Upgrade</th>
                            <th>Tanggal Request</th>
                            <th>Tanggal Validasi</th>
                            <th>Status</th>
                            <th>Detail</th>
                            <th>#</th>
                         </tr>
                      </thead>
                      <tbody></tbody>
                  <tbody>
                  </tbody>
               </table>
                </div><!-- /.box-body -->
            </div>
        </div><!-- /.box -->
    </div>
</section>
@endsection
@section('js')
<script>

$(document).ready(function() {
    
    var table = $('#DataTable').DataTable({
        "language": {
            // "processing": "<i class='fa fa-spinner fa-spin fa-3x fa-fw'></i><span class='sr-only'>Loading...</span>",
            "zeroRecords": "<i>Data tidak ditemukan</i>",
            // "loadingRecords": "Please wait - loading..."
         },
        deferRender: true,
        processing: true,
        serverSide: true,
        autoWidth: true,
        autoHight: true,
        info: false,
        dom: '<"toolbar">frti<"bottom"lp><"clear">',
        ajax:{
             url: "{{ route('data.validasi-membership.datatables') }}",
             dataType: "json",
             type: "POST",
             data:{ _token: "{{csrf_token()}}"}
           },

        // order: [[ 7, "desc" ]],
        columns:[
                  {data: 'no', width: "50px", sClass: "text-center", orderable: false},
                  {data: 'id', defaulContent: '-' },
                  {data: 'username', defaulContent: '-' },
                  {data: 'roleup', defaulContent: '-' },
                  {data: 'created_at', defaulContent: '-' },
                  {data: 'tgl_validasi', defaulContent: '-' },
                  {data: 'status', defaulContent: '-' },
                  {data: 'detail',defaulContent: '-'},
                  {data: "action", defaultColumn: "-", orderable: false, searchable: false},
                ]
     });
     
});
</script>
@endsection