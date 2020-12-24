@extends('layouts.member')
<style type="text/css">
 
#share-buttons img {
width: 35px;
padding: 5px;
border: 0;
box-shadow: 0;
display: inline;
}


.product__list ul li{
    margin-bottom: 0.8rem;
    background: #C8F1C8;
    border: 1px solid #32CD32;
    color: #48465B;
    padding: 1.4rem 2rem;
    cursor: pointer;
}

.product__list ul li label{
    cursor: pointer;
}

.product__flex{
    display: flex;
}

.product__right{
    margin-left: auto;
}

.product__title{
    font-size: 16px;
    font-weight: 400;
    color: #595d6e;
}

.product__desc{
    font-size: 12px;
    color: #74788d;
    font-weight: 400;
}

.product__price{
    font-size: 16px;
    font-weight: 600;
    color: #48465b;
}

.product__poin{
    font-size: 14px;
    color: #ffb822;
}


.product__flex{
    display: flex;
}

.product__right{
    margin-left: auto;
}

.product__width{
    margin-left: 1.4rem; 
    width: 100%;
}

.product__custom-input{
    border: 1px solid #366cf3;
}

.product__radio input[type=radio]{
    visibility: hidden;
    margin-top: -10px;
}

.product__radio .check{
    display: block;
    border: 2px solid #497DED;
    border-radius: 100%;
    height: 18px;
    width: 18px;
    z-index: 5;
    transition: border .25s linear;
    -webkit-transition: border .25s linear;
}

.product__radio:hover .check{
    border: 2px solid #497DED;
}

.product__radio::before{
    display: block;
    position: absolute;
	content: '';
    border-radius: 100%;
    height: 5px;
    width: 5px;
    top: 5px;
	left: 5px;
    margin: auto;
	transition: background 0.25s linear;
	-webkit-transition: background 0.25s linear;
}

input[type=radio]:checked ~ .check {
  border: 3px solid #0DFF92;
}

input[type=radio]:checked ~ .check::before{
  background: #0DFF92;
}

.modal__text{
    text-align: center;
    font-size: 18px;
    color: #48465B;
}

.modal__text span{
    font-weight: 600;
}

#modalPIN .modal-header .modal-title{
    color: #48465B;
    font-weight: 600;
}

.input__group-margin{
    margin-top: 3rem;
    margin-bottom: 1rem;
}
 
</style>
@section('content')
<section class="content-header hidden-xs">
    <h1>Markup<small> Downline</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{url('/member')}}" class="btn-loading"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Markup Downline</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header">
                    <h3 class="box-title"><a href="{{url('/member')}}" class="btn-loading hidden-lg"><i class="fa fa-arrow-left custom__text-green" style="margin-right:10px;"></i></a>Markup Downline</h3>
                </div>
                <form role="form" action="{{url('/member/markup-downline/update')}}" method="post">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label>Markup Downline</label>
                            <input type="number"class="form-control" name="markup" value="{{Auth::user()->referral_markup}}">
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                        <small>Settingan Markup downline ini adalah settingan markup produk yang anda kenakan untuk member downline anda</small>
                    </div>
                </form>
            </div>
        </div>
     
    </div>
   
  

</section>




@endsection
@section('js')

<script type="text/javascript">

</script>
@endsection