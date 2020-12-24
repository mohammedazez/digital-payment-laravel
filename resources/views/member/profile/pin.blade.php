@extends('member.profile.index')

@section('profile')
<div class="box box-solid">
    <div class="box-header with-border">
        <i class="fa fa-key"></i>
        <h3 class="box-title">Data Pin</h3>
    </div>
    <div class="box-body">
            <div class="box-body">
                    <label class="col-sm-3 control-label">PIN : </label>
                    <div class="col-sm-9">
                        <div class="form-group">
                            <input type="password" name="pin" class="form-control" value="secret" disabled>
                        </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <button class="btn custom__btn-green btn-block" id="getpin" onclick="getPin()"><i class="fa fa-telegram"></i> Request PIN</button>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <!--<button class="btn custom__btn-green btn-block" id="generatepin" onclick="generatePin()"><i class="fa fa-refresh"></i> Regenerate PIN</button>-->
                                <button type="button" id="editpin" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal"><i class="fa fa-refresh"></i> Ubah Pin</button>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
    </div>
    </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Ubah Pin</h4>
        </div>
        <div class="modal-body">
            <form id="formubahpin">
                <div class="form-group">
                    <label for="newpin">New Pin:</label>
                    <input type="number" name="newpin" id="newpin" class="form-control" placeholder="Masukkan Pin Baru" maxlength="4" minlength="4" oninput="maxLengthCheck(this)" required>
                </div>
                <div class="form-group">
                    <label for="password">You Password:</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan Password anda" required>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="submit" id="ubahpin" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('js')
<script>

function maxLengthCheck(object)
  {
    if (object.value.length > object.maxLength)
      object.value = object.value.slice(0, object.maxLength)
  }
  
$("#myModal").on("hidden.bs.modal", function(){
     $("#newpin").val('');
     $("#password").val('');
     $('.form-group').removeClass('has-success');
     $('.form-group').removeClass('has-error');
});

 $(function() {
     $("button#ubahpin").click(function(){
         
         var newpin   = $('#newpin');
         var password = $('#password');
         if(!newpin.val()) {
            newpin.closest('.form-group').removeClass('has-success').addClass('has-error');
            // e.preventDefault();
            return false;
         } else {
            newpin.closest('.form-group').removeClass('has-error').addClass('has-success');
         }
         
         if(!password.val()) {
            password.closest('.form-group').removeClass('has-success').addClass('has-error');
            // e.preventDefault();
            return false;
         } else {
            password.closest('.form-group').removeClass('has-error').addClass('has-success');
         }
         
        //  $('#ubahpin').text('');
         $('.fa-save').removeClass('fa-save').addClass('fa-spinner fa-spin');
         var formdata = $('#formubahpin').serializeArray();
         $.ajax({
             type: "POST",
             url: "{{route('get.profile.ubah.pin')}}",
             data: {_token:"{{ csrf_token() }}", formdata},
             success: function(msg){
                //  console.log(msg);
                if(msg == 1){
                    location.href = "{{ route('get.profile.ubah.pin.success') }}";
                } else if(msg == 2){
                    location.href = "{{ route('get.profile.ubah.pin.invalid') }}";
                } else {
                    location.href = "{{ route('get.profile.ubah.pin.error') }}";
                }
             },
            error: function(){
                alert("failure");
            }
      });
    });
});

function getPin()
{
    document.getElementById("getpin").disabled = true;
    // document.getElementById("generatepin").disabled = true;
    document.getElementById("editpin").disabled = true;
    $("#getpin").val('');
    $('.fa-telegram').removeClass('fa-telegram').addClass('fa-spinner fa-spin');
    $.ajax({
        url: "{{route('get.profile.request.pin')}}",
        type: 'GET',
        data: {_token:"{{ csrf_token() }}"},
        success: function(response){
            location.href = "{{ route('get.profile.request.pin.success') }}";
        }
    });
}

function generatePin()
{
    document.getElementById("getpin").disabled = true;
    document.getElementById("generatepin").disabled = true;
    $("#generatepin").val('');
    $('.fa-refresh').removeClass('fa-refresh').addClass('fa-spinner fa-spin');
    $.ajax({
        url: "{{route('get.profile.generate.pin')}}",
        type: 'GET',
        data: {_token:"{{ csrf_token() }}"},
        success: function(response){
            location.href = "{{ route('get.profile.generate.pin.success') }}";
        }
    });
}
</script>
@endsection