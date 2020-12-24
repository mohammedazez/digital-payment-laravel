<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=<charset>" />
    <title>Struk Transfer Bank</title>
  </head>

  <style type="text/css">
/* http://meyerweb.com/eric/tools/css/reset/ 
   v2.0 | 20110126
   License: none (public domain)
*/

html, body, div, span, applet, object, iframe,
h1, h2, h3, h4, h5, h6, p, blockquote, pre,
a, abbr, acronym, address, big, cite, code,
del, dfn, em, img, ins, kbd, q, s, samp,
small, strike, strong, sub, sup, tt, var,
b, u, i, center,
dl, dt, dd, ol, ul, li,
fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td,
article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, 
menu, nav, output, ruby, section, summary,
time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	/*font-size: 100%;*/
	/*font: inherit;*/
	vertical-align: baseline;
}
/* HTML5 display-role reset for older browsers */
article, aside, details, figcaption, figure, 
footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1;
}
ol, ul {
	list-style: none;
}
blockquote, q {
	quotes: none;
}
blockquote:before, blockquote:after,
q:before, q:after {
	content: '';
	content: none;
}
table {
	/*border-collapse: collapse;*/
	border-spacing: 3;
}
</style>

<style type="text/css">

#content{
	font-family: "Courier New", Courier, "Lucida Sans Typewriter", "Lucida Typewriter", monospace;
	margin:5px;
	font-size: 10px;
	padding: 5px;
}

.info{
	text-transform: uppercase;
}

.service{
	margin-bottom:5px;
}

.tex-col{
	padding: 10px;
	text-align: center;
}
  
}

hr {
  border:none;
  border-top:1px dotted black;
  /*color:#fff;*/
  /*background-color:#fff;*/
  height:1px;
  width:100%;
}

  </style>
  <body>
<br>
<div id="content">
      <div class="logo"></div>
      <div class="info"> 
      	<center>
        	<h4>{{$GeneralSettings->nama_sistem}}</h4><br>
        	<h4>Struk Transfer Bank</h4>
    	</center>
      </div>
		<hr>
			<table>
				  <tr>
					<td>OUTLET</td>
					<td>:</td>
					<td>{{isset($user->name)?$user->name:'-'}}</td>
				  </tr>
				  <tr>
					<td>ORDER ID</td>
					<td>:</td>
					<td>{{isset($transaksi->id)?$transaksi->id:'-'}}</td>
				  </tr>
				  <tr>
					<td>TANGGAL</td>
					<td>:</td>
					<td>{{date("d M Y", strtotime($transaksi->created_at))}} {{date("H:i:s", strtotime($transaksi->created_at))}} WIB</td>
				  </tr>
			</table>
		<hr>
            <table>
                     <tr>
                        <td>ID Trx</td>
                        <td>:</td>
                        <td>#{{$transaksi->id}}</td>
                     </tr>
                     <tr>
                        <td>Kode Bank</td>
                        <td>:</td>
                        <td>{{$transaksi->code_bank}}</td>
                     </tr>
                     <tr>
                        <td>Nama Bank</td>
                        <td>:</td>
                        <td>{{$transaksi->jenis_bank}}</td>
                     </tr>
                     <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{$transaksi->penerima}}</td>
                     </tr>
                     <tr>
                        <td>No.Rekening</td>
                        <td>:</td>
                        <td>{{$transaksi->no_rekening}}</td>
                     </tr>
                     <tr>
                        <td>Nominal</td>
                        <td>:</td>
                        <td>Rp. {{number_format($transaksi->nominal, 0, '.', '.')}}</td>
                     </tr>
                     <tr>
                        <td>Keterangan</td>
                        <td>:</td>
                        <td>{!!$transaksi->note!!}</td>
                     </tr>
                     <tr>
                        <td>Status</td>
                        <td>:</td>
                        @if($transaksi->status == 0)
                        <td><span class="label label-warning">PROSES</span></td>
                        @elseif($transaksi->status == 1)
                        <td><span class="label label-success">BERHASIL</span></td>
                        @elseif($transaksi->status == 2)
                        <td><span class="label label-danger">BERHASIL</span></td>
                        @elseif($transaksi->status == 3)
                        <td><span class="label label-primary">REFUND</span></td>
                        @endif
                     </tr>
                  </table>
            <hr>
			<p align="center">
				<i>
				TERIMA KASIH<br>
				"Informasi Lanjut Hubungi Admin {{isset($GeneralSettings->nama_sistem)?$GeneralSettings->nama_sistem:''}}" 
				</i>
			</p>
		<hr>
</div>
  </body>
</html>