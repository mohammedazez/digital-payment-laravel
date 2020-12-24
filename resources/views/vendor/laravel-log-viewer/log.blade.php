@extends('layouts.admin')

@section('content')
<style>
    /* body {
      padding: 25px;
    } */

    /* h1 {
      font-size: 1.5em;
      margin-top: 0;
    } */

    /* #table-log {
        font-size: 0.85rem;
    } */

    /* .sidebar {
        font-size: 0.85rem;
        line-height: 1;
    } */

    /* .btn {
        font-size: 0.7rem;
    } */

    .stack {
      font-size: 0.85em;
    }

    .date {
      min-width: 75px;
    }

    .text {
      word-break: break-all;
    }

    a.llv-active {
      z-index: 2;
      background-color: #f5f5f5;
      border-color: #777;
    }

    .list-group-item {
      word-wrap: break-word;
    }
  </style>
<section class="content-header">
<h1>Pengaturan <small>Log viewer</small></h1>
<ol class="breadcrumb">
 	<li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="Javascript:;">Pengaturan</a></li>
 	<li class="active">Log viewer</li>
</ol>
</section>
<section class="content">
   <div class="row">
      <div class="col-xs-12">
         <div class="box">
            <div class="box-header">
               <h3 class="box-title">Log viewer</h3>

               <div class="pull-right">
                 @if($current_file)
                   <a href="?dl={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}">
                     <span class="fa fa-download"></span> Download file
                   </a>
                   -
                   <a id="clean-log" href="?clean={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}">
                     <span class="fa fa-sync"></span> Clean file
                   </a>
                   -
                   <a id="delete-log" href="?del={{ \Illuminate\Support\Facades\Crypt::encrypt($current_file) }}">
                     <span class="fa fa-trash"></span> Delete file
                   </a>
                   @if(count($files) > 1)
                     -
                     <a id="delete-all-log" href="?delall=true">
                       <span class="fa fa-trash-alt"></span> Delete all files
                     </a>
                   @endif
                 @endif
               </div>

               <!-- <a href="{{route('bank.create')}}" class="btn-loading btn btn-primary pull-right" data-toggle="tooltip" data-placement="left" title="Tambah Data Bank" style="padding: 3px 7px;"><i class="fa fa-plus"></i></a> -->
            </div><!-- /.box-header -->
            <div class="box-body table-responsive">
                  <div class="col-md-12 table-container">
                    <h4><i class="fa fa-calendar" aria-hidden="true"></i> Laravel Log Viewer</h4>
                    <div class="list-group">
                      @foreach($files as $file)
                        <a href="?l={{ \Illuminate\Support\Facades\Crypt::encrypt($file) }}"
                           class="list-group-item @if ($current_file == $file) llv-active @endif">
                          {{$file}}
                        </a>
                      @endforeach
                    </div>
                    @if ($logs === null)
                      <div>
                        Log file >50M, please download it.
                      </div>
                    @else
                      <table id="table-log" class="table table-striped" data-ordering-index="{{ $standardFormat ? 2 : 0 }}">
                        <thead>
                        <tr>
                          @if ($standardFormat)
                            <th>Level</th>
                            <th>Context</th>
                            <th>Date</th>
                            <th></th>
                          @else
                            <th>Line number</th>
                            <th></th>
                          @endif
                          <th>Content</th>
                          <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($logs as $key => $log)
                          <tr data-display="stack{{{$key}}}">
                            @if ($standardFormat)
                              <td class="text-{{{$log['level_class']}}}"><span class="fa fa-{{{$log['level_img']}}}" aria-hidden="true"></span> &nbsp;{{$log['level']}}</td>
                              <td class="text">{{$log['context']}}</td>
                              <td></td>
                            @endif
                            <td class="date">{{{$log['date']}}}</td>
                            <td class="text">
                              {{{$log['text']}}}
                              @if (isset($log['in_file'])) <br/>{{{$log['in_file']}}}@endif
                              @if ($log['stack'])
                                <div class="stack" id="stack{{{$key}}}"
                                     style="display: none; white-space: pre-wrap;">{{{ trim($log['stack']) }}}
                                </div>@endif
                            </td>
                            <td class="text">
                              @if ($log['stack'])
                                <button type="button" class="float-right expand btn btn-outline-dark btn-sm mb-2 ml-2" data-display="stack{{{$key}}}">
                                  <span class="fa fa-search"></span>
                                </button>
                              @endif
                            </td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    @endif
                  </div>
            </div>
        </div>
      </div>
    </div>
</section>
@endsection
@section('js')
<script>
  $(document).ready(function () {
    $('.table-container tr').on('click', function () {
      $('#' + $(this).data('display')).toggle();
    });

    Pace.track(function(){
      $('#table-log').DataTable({
        "order": [$('#table-log').data('orderingIndex'), 'desc'],
        "stateSave": true,
        "stateSaveCallback": function (settings, data) {
          window.localStorage.setItem("datatable", JSON.stringify(data));
        },
        "stateLoadCallback": function (settings) {
          var data = JSON.parse(window.localStorage.getItem("datatable"));
          if (data) data.start = 0;
          return data;
        }
      });
    });

    $('#delete-log, #clean-log, #delete-all-log').click(function () {
      return confirm('Are you sure?');
    });
  });
</script>
@endsection
