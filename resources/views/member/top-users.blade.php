@extends('layouts.member')
@section('content')
<section class="content-header hidden-xs">
    <h1>Top 10<small> Pengguna</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Top 10 Pengguna</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
      <div class="col-md-5">
         <div class="box box-green ">
            <div class="box-body">
               <table class="table" id="aktivitas" style="font-size: 13px;">
                   <thead>
                       <tr>
                           <th>No</th>
                           <th>Nama</th>
                           <th class="text-right">Jumlah Transaksi</th>
                       </tr>
                   </thead>
                  <tbody>
                    @foreach($users as $i => $user)
                      <tr>
                          <td>{{ $i+1 }}</td>
                         <td>{{ $user->name }}</td>
                         <td class="text-right">{{ number_format($user->total_trx, 0, '', '.') }}</td>
                      </tr>
                    @endforeach
                  </tbody>
               </table>
            </div>
            <!-- /.box-body -->
         </div>
      </div>
</div>
</section>
@endsection