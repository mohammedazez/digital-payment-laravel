<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/icon" href="{{asset('img/logo/favicon.png')}}"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <title>Pembayaran PayPal</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    
    <!-- Custom styles for this template -->
    <link href="https://getbootstrap.com/docs/4.1/examples/cover/cover.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
   <!--[if lt IE 9]>
   <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
   <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
   <![endif]-->
    
    <style type="text/css">
      html, body
      {
          text-shadow: none;
          background-color: #3094ff;
          background: url({{ url('img/va') }}/grass.jpg) no-repeat center center fixed; 
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;  
      }
      .modal .card-header {padding: 0}
      .modal .card-body {padding: 10px 0 0 0}
      .btn-link{color: #495057}
      .btn-link:hover{color: #333333}
      .logo {
        height: 60px;
        }

    </style>
  </head>

  <body class="text-center">

    <div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
      <header class="masthead mb-auto">
        <div class="inner">
        </div>
      </header>

      <main role="main" class="inner cover">
        <img class="logo" src="{{ url('img/va') }}/your_logo.png" alt="logo">
        <br><br>
        <div class="card border-light text-body"  style="text-align: left;">
          <div class="card-header"><b>Pembayaran PayPal</b> <img src="{{ isset($bank->nama_bank) ? url('img/banks/').'/'.$bank->image : '' }}" alt="logo" style="height: 24px;float: right;">
            <br><small>Pastikan anda mentransfer dana sebelum masa berlaku habis
dan dengan nominal dan catatan yang tepat. Setelah melakukan transfer klik tombol KONFIRMASI PEMBAYARAN. Pembayaran harus dikirim melalui email paypal yang terdaftar diprofil ({{ $user->paypal_email }})</small>
          </div>
          <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    @if(Session::has('alert-error'))
                        <div class="alert alert-danger">{{ Session::get('alert-error') }}</div>
                    @endif
                    @if(Session::has('alert-success'))
                        <div class="alert alert-success">{{ Session::get('alert-success') }}</div>
                    @endif
                </div>
                <div class="col-md-6">
                  <kbd>Nomor Order</kbd><br><p class="h6">{{ $pp->id }}</p>
                  <kbd>Nama Penerima</kbd><br><p class="h6">{{ $pp->paypal_name }}</p>
                  <kbd>Masa Berlaku Hingga</kbd><br><p class="h6">{{ $pp->expired_at->format('d-m-Y H:i:s') }} WIB</p>
                  <kbd>Status</kbd><br><p class="h6">
                      @if( $pp->status == 0 )
                      WAITING CONFIRMATION
                      @elseif( $pp->status == 1 )
                      VALIDATION
                      @elseif( $pp->status == 2 )
                      SUCCESS
                      @elseif( $pp->status == 3 )
                      FAILED / EXPIRED
                      @elseif( $pp->status == 4 )
                      ON HOLD
                      @endif
                    </p>
                  @if($pp->status != 0)
                  <kbd>Email Pengirim</kbd><br><p class="h6">{{ $pp->payer_email }}</p>
                  @endif
                  @if(!empty($pp->additional_info) && preg_match("/(review.*paypal|tidak.*terdaftar)/i", $pp->additional_info))
                  <kbd>Keterangan Tambahan</kbd><br><p class="h6">{{ $pp->additional_info }}</p>
                  @endif
                </div>
                <div class="col-md-6">
                  <div style="padding-top: 0px">Email PayPal Tujuan</div>
                  <div class="input-group mb-2 mr-sm-2">
                    <input id="email_pp" class="form-control form-control-sm" type="text" value="{{ $pp->paypal_email }}" readonly="">
                    <div class="input-group-prepend" style="width: 40px;background: #fff;border: 1px solid #e9ecef;border-radius: .2rem;">
                      <a href="Javascript:;" class="copy-text" style="margin:auto; color: #333" onclick="copyToClipboard('email_pp')"><i class="fa fa-clone"></i></a>
                    </div>
                  </div>
                  <div style="padding-top: 15px">Jumlah Deposit<span style="float: right">Kurs/$</span></div>
                  <div class="input-group mb-2 mr-sm-2">
                    <input class="form-control form-control-sm" type="text" value="Rp {{ number_format($pp->amount_idr, 0, '', '.') }}" disabled="">
                    <div class="input-group-prepend" style="width: 90px">
                      <input class="form-control form-control-sm" type="text" value="Rp {{ number_format($pp->kurs, 0, '', '.') }}" disabled="">
                    </div>
                  </div>
                  <div style="padding-top: 5px">Nominal Transfer (USD)</div>
                  <div class="input-group mb-2 mr-sm-2">
                    <input id="amount_trf" class="form-control form-control-sm" type="text" value="{{ number_format($pp->amount_usd, 2 , '.', '') }}" readonly="">
                    <div class="input-group-prepend" style="width: 40px;background: #fff;border: 1px solid #e9ecef;border-radius: .2rem;">
                      <a href="Javascript:;" class="copy-text" style="margin:auto; color: #333" onclick="copyToClipboard('amount_trf')"><i class="fa fa-clone"></i></a>
                    </div>
                  </div>
                  <div style="padding-top: 5px">Catatan</div>
                  <div class="input-group mb-2 mr-sm-2">
                    <input id="note" class="form-control form-control-sm" type="text" value="{{ $pp->note }}" readonly="">
                    <div class="input-group-prepend" style="width: 40px;background: #fff;border: 1px solid #e9ecef;border-radius: .2rem;">
                      <a href="Javascript:;" class="copy-text" style="margin:auto; color: #333" onclick="copyToClipboard('note')"><i class="fa fa-clone"></i></a>
                    </div>
                  </div>
                </div>
            </div>
          </div>
          <div class="card-footer">
              <button type="button" class="btn btn-info" onclick="backPage();">Back</button>
              <button type="button" class="btn custom__btn-greenHover" data-toggle="modal" data-target="#exampleModalCenter">Cara Pembayaran</button>
              @if( $pp->status == 0 )
                <button type="button" class="btn custom__btn-greenHover" data-toggle="modal" data-target="#confirmModal">Konfirmasi Pembayaran</button>
              @endif
          </div>
        </div>
      </main>


<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-body" id="exampleModalCenterTitle">Cara Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left text-secondary">

      <div class="accordion" id="accordionExample">
      <div class="card">
        <div class="card-header">
          <h5 class="mb-0">
            <button class="btn btn-link" type="button">
              <b>Pembayaran melalui PayPal</b>
            </button>
          </h5>
        </div>
        <div class="card-body">
            <ol>
             <li>Masuk ke <mark>Akun PayPal</mark> Anda</li>
             <li>Pilih menu <mark>Kirim Pembayaran</mark></li>
             <li>Pilih jenis pembayaran <mark>Teman & Keluarga / Family & Friends</mark></li>
             <li>Masukkan jumlah <mark>${{ number_format($pp->amount_usd, 2 , '.', '') }} USD</mark></li>
             <li>Isi kolom <mark>CATATAN</mark> dengan <mark>{{ $pp->note }}</mark></li>
             <li>Klik <mark>SELANJUTNYA</mark> dan ikuti petunjuk untuk menyelesaikan proses transfer</li>
             <li>Lakukan konfirmasi pembayaran dengan mengklik tombol <mark>KONFIRMASI PEMBAYARAN</mark></li>
             <li>Pembayaran akan segera divalidasi sistem</li>
            </ol>
          </div>
      </div>
    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn custom__btn-greenHover" data-dismiss="modal">Ok !</button>
      </div>
    </div>
  </div>
</div>

@if( $pp->status == 0 )
<!-- Modal -->
<div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-body" id="confirmModalTitle">Konfirmasi Pembayaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-left text-secondary">

      <form action="{{ route('payments.paypal.confirm', ['id' => $pp->id]) }}" method="POST" id="confirm_form" name="confirm_form">
          {{ csrf_field() }}
          <label for="email">Email PayPal Pengirim:</label>
          <input type="email" name="email" class="form-control">
      </form>

      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">BATAL</button>
        <button type="button" class="btn custom__btn-greenHover" onclick="document.confirm_form.submit();">KIRIM</button>
      </div>
    </div>
  </div>
</div>
@endif

      <footer class="mastfoot mt-auto">
        <div class="inner">
          <p>Secure payment by <a href="https://tripay.co.id/">Hijaupay</a>, Copyright © <a href="https://tridi.net">PT. TRIDI</a>.</p>
        </div>
      </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    
    <script>

        $(function() {
           $("#exampleModalCenter").modal('show'); 
        });
    
        toastr.options = {
           "positionClass": "toast-bottom-center",
        }
        
        function copyToClipboard(elementId) {
            var copyText = document.getElementById(elementId);
            copyText.select();
            document.execCommand("copy");
            toastr.success("Teks disalin ke papan klip");
        }
        
        @if($pp->status == 0)
            $(function() {
              swal("Penting!", "Jika sudah mengirim PayPal jangan tinggalkan halaman ini tanpa menekan tombol (Konfirmasi Pembayaran) ya", "info"); 
            });
        @endif
        
        function backPage()
        {
            window.location.href = "{{ url('/member/deposit') }}";
        }
        
    </script>
  
  </body>
</html>