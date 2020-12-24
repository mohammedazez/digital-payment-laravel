@extends('layouts.admin')

@section('content')
<section class="content-header hidden-xs hidden-sm">
    <h1>Data <small>Voucher</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/admin')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{route('voucher.index')}}" class="btn-loading"> Voucher</a></li>
        <li class="active">Tambah Voucher</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{route('users.index')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Tambah Voucher</h3>
                </div>
                <form role="form" action="{{route('voucher.store')}}" method="post">
                {{csrf_field()}}
                    <div class="box-body">
                        <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                            <label>Code Voucher : </label>
                            <div class="input-group">
                                <!--<input type="text" name="code" class="form-control" value="{{old('code')}}">-->
                                <input type="text" name="code" class="form-control">
                                <span class="input-group-btn">
                                    <a id="generate-code" class="btn btn-primary"><i class="fa fa-refresh"></i> Generate Code</a>
                                </span>
                            </div>
                            {!! $errors->first('code', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                            
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel panel-default" id="panelbox">
                                  <div class="panel-body">
                                      
                                    <div class="row">
                                        <div class="col-md-3">
                                            <input type="checkbox" data-toggle="toggle" data-size="mini" class="chk_filter" name="filtering[]" id="masa-bergabung" value="B"><br>Masa bergabung
                                        </div>
                                        <div class="col-md-3">
                                            <input type="checkbox" data-toggle="toggle" data-size="mini" class="chk_filter" name="filtering[]" id="status-verifikasi" value="C"><br>Status verifikasi
                                        </div>
                                        <div class="col-md-3">
                                            <input type="checkbox" data-toggle="toggle" data-size="mini" class="chk_filter" name="filtering[]" id="min-saldo-option" value="D"><br>Minimal saldo user
                                        </div>
                                        <div class="col-md-3">
                                            <input type="checkbox" data-toggle="toggle" data-size="mini" class="chk_filter" name="filtering[]" id="max-saldo-option" value="E"><br>Maximal saldo user
                                        </div>
                                        <div class="col-md-3">
                                            <input type="checkbox" data-toggle="toggle" data-size="mini" class="chk_filter" name="filtering[]" id="level-user" value="F"><br>Level user
                                        </div>
                                    </div>
                                    <div id="date" style="display: none">
                                      <div class="form-group{{ $errors->has('date_masa_bergabung') ? ' has-error' : '' }}">
                                            <label>Masa bergabung : </label>
                                            <input type="text" name="date_masa_bergabung" id="date_masa_bergabung" class="form-control" placeholder="Input Date">
                                            {!! $errors->first('date_masa_bergabung', '<p class="help-block"><small>:message</small></p>') !!}
                                      </div>
                                    </div>
                                    
                                    <div id="select_level" style="display: none">
                                      <div class="form-group{{ $errors->has('select_level') ? ' has-error' : '' }}">
                                          <label>Status verifikasi : </label>
                                          <select class="form-control" name="select_level" id="select_level" style="width:100% !important";>
                                              <option value="1">Membership Personal</option>
                                              <option value="3">Membership Agen</option>
                                              <option value="4">Membership Enterprise</option>
                                          </select>
                                          {!! $errors->first('select_level', '<p class="help-block"><small>:message</small></p>') !!}
                                      </div>
                                    </div>
                                    
                                    <div id="verif" style="display: none">
                                      <div class="form-group{{ $errors->has('select_verif') ? ' has-error' : '' }}">
                                          <label>Status verifikasi : </label>
                                          <select class="form-control" name="select_verif" id="select_verif" style="width:100% !important";>
                                              <option value="no verification">Non Verification</option>
                                              <option value="verification">Verification</option>
                                          </select>
                                          {!! $errors->first('select_verif', '<p class="help-block"><small>:message</small></p>') !!}
                                      </div>
                                    </div>
                                    
                                    <div id="min-saldo" style="display: none">
                                      <div class="form-group{{ $errors->has('minimal_saldo') ? ' has-error' : '' }}">
                                            <label>Minimal saldo user : </label>
                                            <input type="number" name="minimal_saldo" id="minimal_saldo" class="form-control" placeholder="Input Minimal saldo">
                                            {!! $errors->first('minimal_saldo', '<p class="help-block"><small>:message</small></p>') !!}
                                      </div>
                                    </div>
                                    <div id="max-saldo" style="display: none">
                                      <div class="form-group{{ $errors->has('maximal_saldo') ? ' has-error' : '' }}">
                                            <label>Maximal saldo user : </label>
                                            <input type="number" name="maximal_saldo" id="maximal_saldo" class="form-control" placeholder="Input Maximal saldo">
                                            {!! $errors->first('maximal_saldo', '<p class="help-block"><small>:message</small></p>') !!}
                                      </div>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('bonus') ? ' has-error' : '' }}">
                            <label>Bonus Saldo : </label>
                            <div class="input-group">
                                <div class="input-group-addon">Rp. </div>
                                <input type="number" name="bonus" class="form-control" value="{{old('bonus')}}">
                            </div>
                            {!! $errors->first('bonus', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('expired_date') ? ' has-error' : '' }}">
                            <label>Expired Date : </label>
                            <input type="text" id="datepicker" name="expired_date" class="form-control" value="{{date('m/d/Y')}}" readonly>
                            {!! $errors->first('expired_date', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('quant') ? ' has-error' : '' }}">
                            <label>Qty : </label>
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-number"  data-type="minus" data-field="quant[2]">
                                        <span class="glyphicon glyphicon-minus"></span>
                                    </button>
                                </span>
                                <input type="text" name="quant[2]" class="form-control input-number" value="1" min="1" max="100" readonly>
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary btn-number" data-type="plus" data-field="quant[2]">
                                        <span class="glyphicon glyphicon-plus"></span>
                                    </button>
                                </span>
                            </div>
                            {!! $errors->first('quant', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                            <label>Status</label>
                            <div class="pull-right"><input type="checkbox" name="status" value="1" checked data-toggle="toggle" data-size="mini" data-width="85" data-on="AKTIF" data-off="TIDAK AKTIF"></div>
                            <div class="clearfix"></div>
                            {!! $errors->first('status', '<p class="help-block"><small>:message</small></p>') !!}
                        </div>
                    </div>
                    
                    <div class="box-footer">
                        <button type="submit" class="submit btn btn-primary btn-block">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script>
$('#generate-code').on('click', generateCode);

function generateCode()
{
    $('input[name=code]').val('Generate Code...');
    document.getElementById("generate-code").disabled = true;
    $('.fa-refresh').removeClass('fa-refresh').addClass('fa-refresh fa-spin');
    $.ajax({
        url: "{{route('voucher.generateCode')}}",
        type: 'POST',
        data: {_token:"{{ csrf_token() }}"},
        success: function(response){
            $('input[name=code]').val(response);
            $('.fa-spin').removeClass('fa-spin');
            document.getElementById("generate-code").disabled = false;
        }
    });
}

$('#masa-bergabung').change(function(){
    if(this.checked){
        $('#date').show();
    }else{
        $('#date').hide();
    }
});

$('#status-verifikasi').change(function(){
    if(this.checked){
        $('#verif').show();
    }else{
        $('#verif').hide();
    }
});

$('#level-user').change(function(){
    if(this.checked){
        $('#select_level').show();
    }else{
        $('#select_level').hide();
    }
});


$('#min-saldo-option').change(function(){
    if(this.checked){
        $('#minimal_saldo').val('');
        $('#min-saldo').show();
    }else{
        $('#minimal_saldo').val('');
        $('#min-saldo').hide();
    }
});

$('#max-saldo-option').change(function(){
    if(this.checked){
        $('#maximal_saldo').val('');
        $('#max-saldo').show();
    }else{
        $('#maximal_saldo').val('');
        $('#max-saldo').hide();
    }
});

$("#date_masa_bergabung").datepicker({
    // dateFormat: "dd-mm-yy"
    format: "dd-mm-yyyy"
}).datepicker("setDate", "0");


$('.btn-number').click(function(e){
    e.preventDefault();
    
    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
        if(type == 'minus') {
            
            if(currentVal > input.attr('min')) {
                input.val(currentVal - 1).change();
            } 
            if(parseInt(input.val()) == input.attr('min')) {
                $(this).attr('disabled', true);
            }

        } else if(type == 'plus') {

            if(currentVal < input.attr('max')) {
                input.val(currentVal + 1).change();
            }
            if(parseInt(input.val()) == input.attr('max')) {
                $(this).attr('disabled', true);
            }

        }
    } else {
        input.val(0);
    }
});
$('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
});
$('.input-number').change(function() {
    
    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());
    
    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
        $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the minimum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
        $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
        alert('Sorry, the maximum value was reached');
        $(this).val($(this).data('oldValue'));
    }
    
    
});
$(".input-number").keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
         // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) || 
         // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
             // let it happen, don't do anything
             return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
});
$(function () {
    $("#datepicker").datepicker({ 
        autoclose: true, 
        todayHighlight: true
    });
});
</script>
@endsection