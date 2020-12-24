@extends('layouts.admin')
@section('meta', '<meta http-equiv="refresh" content="60">')

@section('content')
<section class="content-header hidden-xs">
    <h1>Layanan <small>Bantuan</small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Layanan Bantuan</a></li>
        <li class="active">Layanan Bantuan</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-green">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{url('/admin')}}" class="hidden-lg btn-loading"><i class="fa fa-arrow-left" style="margin-right:10px;"></i></a>Layanan Bantuan</h3>
                </div>
                <div class="box-body" style="min-height:350px;">
                        <div class="col-md-12">
                            <div class="form-group">
                                <button type="button" class="btn btn-sm custom__btn-greenHover" onclick="refresh_fields()"><i class="fa fa fa-refresh"></i></button>
                                <button type="button" class="btn btn-sm custom__btn-greenHover" onclick="add_fields()"><i class="fa fa fa-plus"></i></button>
                                <button type="button" class="btn btn-sm custom__btn-greenHover" onclick="remove_fields()"><i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-sm custom__btn-greenHover" onclick="store()"><i class="fa fa-save"></i></button>
                            </div>
                            <div class="row">
                                <form class="form-horizontal" action="{{url('admin/setting-layanan-bantuan/store')}}" method="post" role="form">
                                    {{csrf_field()}}
                                        <div id="input_fileds">
                                        </div>
                                </form>
                            </div>
                        </div>
                   <!--  <div class="col-md-6">

                         Testttt
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')

<script type="text/javascript">
    $(window).on('load', function() {
        var layanan = <?php echo json_encode($layanan) ?>;
        if(layanan.length == '0'){
            var objTo = document.getElementById('input_fileds')
            var divtest = document.createElement("div");
            divtest.setAttribute("id", "info_1");
            divtest.innerHTML = '<div class="col-md-6"><label>Info 1:</label><div class="well well-sm"><div class="form-group"><div class="col-md-12"><div class="row"><div class="col-md-6"><div class="input-group"><span class="input-group-addon" id="basic-addon1" style="background-color: #32CD32 !important;color: #fff;">fa fa-</span><input type="text" class="form-control" name="icon_1" placeholder="icon"></div></div><div class="col-md-6"><input type="text" class="form-control" name="title_1" placeholder="title"></div></div></div></div><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="description_1" placeholder="description"></div></div></div></div>';
                                    
            objTo.appendChild(divtest)
        }else{
            for (var i = 0; i < layanan.length; i++){
                var objTo = document.getElementById('input_fileds')
                var divtest = document.createElement("div");
                var info=i+1;
                divtest.setAttribute("id", "info_"+info+"");
                divtest.innerHTML = '<div class="col-md-6"><label>Info '+info+':</label><div class="well well-sm"><div class="form-group"><div class="col-md-12"><div class="row"><div class="col-md-6"><div class="input-group"><span class="input-group-addon" id="basic-addon1" style="background-color: #32CD32;color: #fff;">fa fa-</span><input type="text" class="form-control" name="icon_'+info+'" value="'+layanan[i].icon+'" placeholder="icon"></div></div><div class="col-md-6"><input type="text" class="form-control" name="title_'+info+'" value="'+layanan[i].title+'" placeholder="title"></div></div></div></div><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="description_'+info+'" value="'+layanan[i].description+'" placeholder="description"></div></div></div></div>';
                                        
                objTo.appendChild(divtest);

            }      
        }
    })

    function refresh_fields(){

        $('#input_fileds div').remove();

        var layanan = <?php echo json_encode($layanan) ?>;
        if(layanan.length == '0'){
            var objTo = document.getElementById('input_fileds')
            var divtest = document.createElement("div");
            divtest.setAttribute("id", "info_1");
            divtest.innerHTML = '<div class="col-md-6"><label>Info 1:</label><div class="well well-sm"><div class="form-group"><div class="col-md-12"><div class="row"><div class="col-md-6"><div class="input-group"><span class="input-group-addon" id="basic-addon1" style="background-color: #32CD32;color: #fff;">fa fa-</span><input type="text" class="form-control" name="icon_1" placeholder="icon"></div></div><div class="col-md-6"><input type="text" class="form-control" name="title_1" placeholder="title"></div></div></div></div><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="description_1" placeholder="description"></div></div></div></div>';
                                    
            objTo.appendChild(divtest)
        }else{
            for (var i = 0; i < layanan.length; i++){
                var objTo = document.getElementById('input_fileds')
                var divtest = document.createElement("div");
                var info=i+1;
                divtest.setAttribute("id", "info_"+info+"");
                divtest.innerHTML = '<div class="col-md-6"><label>Info '+info+':</label><div class="well well-sm"><div class="form-group"><div class="col-md-12"><div class="row"><div class="col-md-6"><div class="input-group"><span class="input-group-addon" id="basic-addon1" style="background-color: #32CD32;color: #fff;">fa fa-</span><input type="text" class="form-control" name="icon_'+info+'" value="'+layanan[i].icon+'" placeholder="icon"></div></div><div class="col-md-6"><input type="text" class="form-control" name="title_'+info+'" value="'+layanan[i].title+'" placeholder="title"></div></div></div></div><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="description_'+info+'" value="'+layanan[i].description+'" placeholder="description"></div></div></div></div>';
                                        
                objTo.appendChild(divtest);

            }      
        }
    }

    function add_fields() {
        var countDiv = $('#input_fileds > div').length;
        var info = countDiv+1;

        if(info >= 9+1){
         toastr.error("Maaf, Untuk kolom info maksimal 9 kolom!"); 
         return false;
        }
        var objTo = document.getElementById('input_fileds')
        var divtest = document.createElement("div");
        divtest.setAttribute("id", "info_"+info+"");
        divtest.innerHTML = '<div class="col-md-6"><label>Info '+info+':</label><div class="well well-sm"><div class="form-group"><div class="col-md-12"><div class="row"><div class="col-md-6"><div class="input-group"><span class="input-group-addon" id="basic-addon1" style="background-color: #32CD32;color: #fff;">fa fa-</span><input type="text" class="form-control" name="icon_'+info+'" placeholder="icon"></div></div><div class="col-md-6"><input type="text" class="form-control" name="title_'+info+'" placeholder="title"></div></div></div></div><div class="form-group"><div class="col-md-12"><input type="text" class="form-control" name="description_'+info+'" placeholder="description"></div></div></div></div>';
                                
        objTo.appendChild(divtest)
    }

    function remove_fields() {
        var countDiv = $('#input_fileds > div').length;
        if(countDiv <= 1){
         toastr.error("Maaf, Untuk kolom info minimal 1 kolom!"); 
         return false;
        }
        var lastChildID = document.getElementById("input_fileds").lastChild.id
        var elem = document.getElementById(lastChildID);
        return elem.parentNode.removeChild(elem);
    }

    function store(){
        var countDiv = $('#input_fileds > div').length;
        
        var arrOut = [];
        for(var i=1; i < countDiv+1; i++){
            var arr2 = [];
            $("#input_fileds > #info_"+i+" :input").each(function(e){   
              arr2[arr2.length] = this.value;
            });
            arrOut.push(arr2);
        }

      $.blockUI({ css: { 
            border: 'none', 
            padding: '15px', 
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff' 
        } })
        $.ajax({
            url: "{{url('admin/setting-layanan-bantuan/store')}}",
            method: "POST",
            data: {_token:"{{ csrf_token() }}",arrOut},
            success: function(response){
                location.reload();
                // $.unblockUI();
            },
            error: function(response){
                console.log(response.responseText);
            }
        })
    }
</script>
@endsection
