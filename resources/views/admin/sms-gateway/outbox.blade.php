@extends('layouts.admin')

@section('content')
<section class="content-header">
<h1>SMS Gateway <small>Outbox</small></h1>
<ol class="breadcrumb">
    <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">SMS Gateway</a></li>
    <li class="active">Outbox</li>
</ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Data Kotak Keluar</h3>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="DataTable" class="table table-hover">
                        <thead>
                            <tr class="custom__text-green" style="font-size: 13px;">
                                <th>No</th>
                                <th>ID</th>
                                <th>Tujuan</th>
                                <th>Isi Pesan</th>
                                <th>Status</th>
                                <th>Keterangan</th>
                                <th>Tgl Updated</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody> 
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
@endsection
@section('js')
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#DataTable').DataTable({
        deferRender: true,
        processing: true,
        serverSide: true,
        autoWidth: false,
        info: false,
        ajax:{
             url: "{{ url('/admin/sms-gateway/outbox/datatables') }}",
             dataType: "json",
             type: "POST",
             data:{ _token: "{{csrf_token()}}"}
           },

        //order: [[ 1, "desc" ]],
        columns:[
                  {data: 'no', width: "50px", sClass: "text-center", orderable: false},
                  {data: 'id', defaulContent: '-' },
                  {data: 'sent_to', defaulContent: '-' },
                  {data: 'message', defaulContent: '-'},
                  {data: 'status', defaulContent: '-' },
                  {data: 'note', defaulContent: '-' },
                  {data: 'updated_at', defaulContent: '-' },
                  {data: "action_hapus", defaultColumn: "-", orderable: false, searchable: false},
                ]
     });
});
</script>
@endsection