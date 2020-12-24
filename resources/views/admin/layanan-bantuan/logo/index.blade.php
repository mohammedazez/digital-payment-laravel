@extends('layouts.admin')
@section('meta', '<meta http-equiv="refresh" content="60">')

@section('content')
<section class="content-header hidden-xs">
<h1>Kontrol Logo <small>Logo</small></h1>
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Kontrol Logo</a></li>
    <li class="active">Logo</li>
</ol>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-green">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{url('/admin/logo')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Kontrol Logo</h3>
                </div>
                <form action="{{url('/admin/logo/store')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                        <div class="box-body">
                            <div class="form-group">
                                <label>Favicon : </label>
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($dataLogo[0]->img !='' || $dataLogo[0]->img !=null)
                                            <img src="{{asset('/img/logo/'.$dataLogo[0]->img.'')}}" id="image-1" class="img-responsive" style="width: 100px; height: 50px;max-width:400px;max-height:400px;float:left;">
                                        @else
                                            <img src="" id="image-1" class="img-responsive" style="display: none;width: 100px; height: 50px;max-width:400px;max-height:400px;float:left;">
                                        @endif
                                    </div>
                                </div>
                                <input type="file" class="form-control image" name="image_icon" id="image_icon">
                            </div>
                            <div class="form-group">
                                <label>Logo Guest : </label>
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($dataLogo[1]->img !='' || $dataLogo[1]->img !=null)
                                            <img src="{{asset('/img/logo/'.$dataLogo[1]->img.'')}}" id="image-2" class="img-responsive" style="width: 100px; height: 50px;max-width:400px;max-height:400px;float:left;">
                                        @else
                                            <img src="" id="image-2" class="img-responsive" style="display: none;width: 100px; height: 50px;max-width:400px;max-height:400px;float:left;">
                                        @endif
                                    </div>
                                </div>
                                <input type="file" class="form-control image" name="image_logo_guest" id="image_logo_guest">
                            </div>
                            <div class="form-group">
                                <label>Logo Member and Admin : </label>
                                <div class="row">
                                    <div class="col-md-12">
                                        @if($dataLogo[2]->img !='' || $dataLogo[2]->img !=null)
                                            <img src="{{asset('/img/logo/'.$dataLogo[2]->img.'')}}" id="image-3" class="img-responsive"style="width: 100px; height: 50px;max-width:400px;max-height:400px;float:left;">
                                        @else
                                            <img src="" id="image-3" class="img-responsive" style="display: none;width: 100px; height: 50px;max-width:400px;max-height:400px;float:left;">
                                        @endif
                                    </div>
                                </div>
                                <input type="file" class="form-control image" name="image_logo_member_admin" id="image_logo_member_admin">
                            </div>
                            <div class="box-footer">
                                <button type="submit" class="submit btn btn-primary btn-block">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('js')
<script type="text/javascript">
$("#reset").click(function(){
    $('#showKTP').attr('src', '');
    $('#showgambar').attr('src', '');
    $('#showtabungan').attr('src', '');
});

    function showICON(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image-1').attr('src', e.target.result); 
                $('#image-1').show('slow');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function showLOGOGUEST(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image-2').attr('src', e.target.result);
                $('#image-2').show('slow');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function shwLOGOMEMBERADMIN(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image-3').attr('src', e.target.result);
                $('#image-3').show('slow');
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
    
    $("#image_icon").change(function () {
        showICON(this);
    });

    $("#image_logo_guest").change(function () {
        showLOGOGUEST(this);
    });
    
    $("#image_logo_member_admin").change(function () {
        shwLOGOMEMBERADMIN(this);
    });

</script>
@endsection
