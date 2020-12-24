@extends('member.profile.index')

@section('profile')
<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-image"></i>
        <h3 class="box-title">Ubah Foto Profile</h3>
    </div>
    <div class="box-body">
        <div id="upload-demo-i" align="center" style="margin-bottom:10px;">
            @if(Auth::user()->image != null)
            <img src="{{asset('admin-lte/dist/img/avatar/'.Auth::user()->image)}}">
            @else
            <img src="{{asset('/ibh/images/default-avatar.svg')}}" width="160px" height="160px">
            @endif
        </div>
        <div align="center">
            <button type="button" class="btn custom__btn-green" data-toggle="modal" data-target="#myModal"><i class="fa fa-upload margin-r-5"></i> Upload Foto Profile</button>
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                       <h4 class="modal-title" id="myModalLabel">Upload Image Event</h4>
                    </div>
                    <div class="modal-body">
                        <style>
                           .fileUpload {
                            position: relative;
                            overflow: hidden;
                            /*margin: 10px;*/
                        }
                        .fileUpload input.upload {
                            position: absolute;
                            top: 0;
                            right: 0;
                            margin: 0;
                            padding: 0;
                            font-size: 20px;
                            cursor: pointer;
                            opacity: 0;
                            filter: alpha(opacity=0);
                        }
                        </style>
                        <div align="center">
                            <div id="upload-demo" style="width:350px"></div>
                            <div class="input-group">
                                <input id="uploadFile" placeholder="Pilih File..." class="form-control" disabled="disabled" />
                                <span class="input-group-btn">
                                    <div class="fileUpload btn btn-primary">
                                        <span><i class="fa fa-folder-open"></i> Browse Image Event</span>
                                        <input id="upload" type="file" class="upload" accept="image/*"/>
                                    </div>
                                </span>
                            </div>
                            <div style="margin-top: 10px;">
                                <a href="javascript:;" class="btn btn-primary btn-block upload-result">Upload Image</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript">
$uploadCrop = $('#upload-demo').croppie({
    enableExif: true,
    viewport: {
        width: 160,
        height: 160
    },
    boundary: {
        width: 280,
        height: 280
    }
});

$('#upload').on('change', function () { 
   var reader = new FileReader();
    reader.onload = function (e) {
      $uploadCrop.croppie('bind', {
         url: e.target.result
      }).then(function(){
         console.log('jQuery bind complete');
      });
      
    }
    reader.readAsDataURL(this.files[0]);
});

$('.upload-result').on('click', function (ev) {
   $('#myModal').modal('hide');
   $uploadCrop.croppie('result', {
      type: 'canvas',
      size: 'viewport'
   }).then(function (resp) {
      html = '<img src="' + resp + '" />';
      $("#upload-demo-i").html(html);

      $.ajax({
         url: "/member/picture",
         type: "POST",
         data: {
            "image":resp,
            "_token":"{{csrf_token()}}",
         },
         success: function (data) {
            location.reload();
         }
      });
   });
});
</script>
@endsection