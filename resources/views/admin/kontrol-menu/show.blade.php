@extends('layouts.admin')
@section('meta', '<meta http-equiv="refresh" content="60">')

@section('content')
<section class="content-header hidden-xs">
<h1>Kontrol menu <small>Menu dan sub menu</small></h1>
<ol class="breadcrumb">
  <li><a href="#"><i class="fa fa-dashboard"></i> Kontrol Menu</a></li>
  <li class="active">Menu dan sub menu</li>
</ol>
</section>
<section class="content">
   <div class="row">
      <div class="col-md-6">
        <div class="box box-solid box-penjelasan">
            <div class="box-header">
                <i class="fa fa-text-width"></i>
                <h3 class="box-title">Edit Kontrol menu</h3>
                <div class="box-tools pull-right box-minus" style="display:none;">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                </div>
            </div><!-- /.box-header -->
          
          @if($section_active == 'MENU')
            <form role="form" action="{{url('/admin/kontrol-menu/updateSaveMenu', $datamenu->id)}}" method="post">
            <input name="_method" type="hidden" value="PATCH">
            {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group{{ $errors->has('caption') ? ' has-error' : '' }}">
                        <label>Nama Menu: </label>
                            <input type="text" id="caption" class="form-control" name="caption" value="{{$datamenu->caption}}">
                    </div>
                    <div class="form-group">
                        <!-- <label>Harga Produk: </label> -->
                        <label>Icon: </label>
                            <input type="text" id="icon" class="form-control" name="icon" value="{{$datamenu->icon}}" placeholder="Icon">
                    </div>
                    <div class="form-group">
                        <label>Permission Menu: </label>
                            <!-- <input type="text" id="permission_menu" class="form-control" name="permission_menu" value="{{$datamenu->display_name}}"> -->
                            <select name="permission" id="permission" class="form-control">
                                @foreach($getRole as $data)
                                <option value="{{$data->id}}" {{$data->id == $datamenu->permission_menu?'selected':''}} >{{$data->display_name}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <label>Status: </label>
                            <!-- <input type="text" id="permission_menu" class="form-control" name="permission_menu" value="{{$datamenu->display_name}}"> -->
                            <select name="status" id="status" class="form-control">
                                <option value="1" {{1==$datamenu->status?'selected':''}}>ACTIVE</option>
                                <option value="0" {{0==$datamenu->status?'selected':''}}>NON ACTIVE</option>
                            </select>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="submit btn btn-primary btn-block">Simpan</button>
                </div>
            </form>
          @elseif($section_active == 'SUBMENU')
            <form role="form" action="{{url('/admin/kontrol-menu/updateSaveSubmenu', $datamenu->id)}}" method="post">
            <input name="_method" type="hidden" value="PATCH">
            {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group{{ $errors->has('caption_sub') ? ' has-error' : '' }}">
                        <label>Nama Menu: </label>
                            <input type="text" id="caption_sub" class="form-control" name="caption_sub" value="{{$datamenu->caption_sub}}">
                    </div>
                    <div class="form-group">
                        <label>Parent Menu: </label>
                            <select name="parent_menu" id="parent_menu" class="form-control">
                                @foreach($getSubMenu as $dataParent)
                                <option value="{{$dataParent->id}}" {{$dataParent->id == $datamenu->idparent?'selected':''}}>{{strtoupper($dataParent->caption)}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <!-- <label>Harga Produk: </label> -->
                        <label>Icon: </label>
                            <input type="text" id="icon_sub" class="form-control" name="icon_sub" value="{{$datamenu->icon_sub}}" placeholder="Icon">
                    </div>
                    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                        <!-- <label>Harga Produk: </label> -->
                        <label>URL: </label>
                            <input type="text" id="url" class="form-control" name="url" value="{{$datamenu->url}}" placeholder="Url">
                    </div>
                    <div class="form-group">
                        <label>Permission Menu: </label>
                            <!-- <input type="text" id="permission_menu" class="form-control" name="permission_menu" value="{{$datamenu->display_name}}"> -->
                            <select name="permission" id="permission" class="form-control">
                                @foreach($getRole as $data)
                                <option value="{{$data->id}}" {{$data->id == $datamenu->permission_menu?'selected':''}} >{{$data->display_name}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <label>Status: </label>
                            <!-- <input type="text" id="permission_menu" class="form-control" name="permission_menu" value="{{$datamenu->display_name}}"> -->
                            <select name="status_sub" id="status_sub" class="form-control">
                                <option value="1" {{1==$datamenu->status_sub?'selected':''}}>ACTIVE</option>
                                <option value="0" {{0==$datamenu->status_sub?'selected':''}}>NON ACTIVE</option>
                            </select>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="submit btn btn-primary btn-block">Simpan</button>
                </div>
            </form>
          @elseif($section_active == 'SUBMENU2')
            <form role="form" action="{{url('/admin/kontrol-menu/updateSaveSubmenu2', $datamenu->id)}}" method="post">
            <input name="_method" type="hidden" value="PATCH">
            {{csrf_field()}}
                <div class="box-body">
                    <div class="form-group{{ $errors->has('caption_sub2') ? ' has-error' : '' }}">
                        <label>Nama Menu: </label>
                            <input type="text" id="caption_sub2" class="form-control" name="caption_sub2" value="{{$datamenu->caption_sub2}}">
                    </div>
                    <div class="form-group">
                        <label>Parent Menu: </label>
                            <select name="parent_menu" id="parent_menu" class="form-control">
                                @foreach($getSubMenu as $dataParentSub)
                                <option value="{{$dataParentSub->id}}" {{$dataParentSub->id == $datamenu->idparent?'selected':''}}>{{strtoupper($dataParentSub->caption_sub)}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <!-- <label>Harga Produk: </label> -->
                        <label>Icon: </label>
                            <input type="text" id="icon_sub2" class="form-control" name="icon_sub2" value="{{$datamenu->icon_sub2}}" placeholder="Icon">
                    </div>
                    <div class="form-group{{ $errors->has('url') ? ' has-error' : '' }}">
                        <!-- <label>Harga Produk: </label> -->
                        <label>URL: </label>
                            <input type="text" id="url" class="form-control" name="url" value="{{$datamenu->url}}" placeholder="Url">
                    </div>
                    <div class="form-group">
                        <label>Permission Menu: </label>
                            <!-- <input type="text" id="permission_menu" class="form-control" name="permission_menu" value="{{$datamenu->display_name}}"> -->
                            <select name="permission" id="permission" class="form-control">
                                @foreach($getRole as $data)
                                <option value="{{$data->id}}" {{$data->id == $datamenu->permission_menu?'selected':''}} >{{$data->display_name}}</option>
                                @endforeach
                            </select>
                    </div>
                    <div class="form-group">
                        <label>Status: </label>
                            <!-- <input type="text" id="permission_menu" class="form-control" name="permission_menu" value="{{$datamenu->display_name}}"> -->
                            <select name="status_sub2" id="status_sub2" class="form-control">
                                <option value="1" {{1==$datamenu->status_sub2?'selected':''}}>ACTIVE</option>
                                <option value="0" {{0==$datamenu->status_sub2?'selected':''}}>NON ACTIVE</option>
                            </select>
                    </div>
                </div>

                <div class="box-footer">
                    <button type="submit" class="submit btn btn-primary btn-block">Simpan</button>
                </div>
            </form>
          @endif
      </div>
      </div>

   </div>
</section>
@endsection
@section('js')

@endsection