@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
    <h1>Data <small>Validasi Users</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Data User</a></li>
        <li class="active">Validasi Users</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                   <h3 class="box-title">Validasi Users</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="DataTable"  class="table table-hover">
                      <thead>
                         <tr class="custom__text-green">
                            <th>No.</th>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Image Ktp</th>
                            <th>Image Selfie</th>
                            <th>Image Tabungan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
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
        // deferRender: true,
        processing: true,
        serverSide: false,
        autoWidth: false,
        info: false,
        ajax:{
            url : "{{ route('data.validasi-users.datatables') }}",
        },
        // order: [[ 7, "desc" ]],
        columns:[
                  {data: null, width: "50px", sClass: "text-center", orderable: false},
                  {data: 'id', defaulContent: '-' },
                  {data: 'name', defaulContent: '-' },
                  {data: 'img_ktp', defaulContent: '-' },
                  {data: 'img_selfie', defaulContent: '-' },
                  {data: 'img_tabungan', defaulContent: '-' },
                  {data: 'status', defaulContent: '-' },
                  {data: 'created_at', defaulContent: '-' },
                  {data: "action", defaultColumn: "-", orderable: false, searchable: false},
                ]
     });
     table.on( 'order.dt search.dt', function () {
        table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
        } );
     }).draw();
});
</script>
@endsection