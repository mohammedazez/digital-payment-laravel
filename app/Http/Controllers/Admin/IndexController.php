<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Auth, Pulsa, Response;
use App\AppModel\Transaksi;
use App\AppModel\Deposit;
use App\AppModel\Message;
use App\AppModel\Informasi;
use App\AppModel\Setting;
use App\AppModel\IndexModel;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Lava;
use Carbon\Carbon;

class IndexController extends Controller
{
	public function indexNew()
	{
		//PRODUK OP
		$lava3                 = new Lava; // See note below for Laravel
		$produkkategori        = Lava::DataTable();
		$produkkategori->addStringColumn('produkkategori');
		$produkkategori->addNumberColumn('Percent');
		
		$getDataProdukOperator = IndexModel::getTransaksiOperator();
		
        foreach ($getDataProdukOperator as $trxOP) {
            $produkkategori->addRow([''.$trxOP->product_name.'', intVal($trxOP->total_item)]);
        }

		Lava::PieChart('produkkategori', $produkkategori, [
		    'title' => 'Penjualan Berdasarkan Kategori Produk',
			'titleTextStyle' => [
		        'color'    => '#eb6b2c',
		    ],
		    'is3D'   => true,
		]);
		
		
		//PRODUK
		$getDataProduk = IndexModel::getTransaksiProduk();
		$lava4         = new Lava; // See note below for Laravel
		$produk        = Lava::DataTable();
		$produk->addStringColumn('produk');
		$produk->addNumberColumn('Percent');
        foreach ($getDataProduk as $pd) {
            $produk->addRow([''.$pd->product_name.' ('.$pd->code.')', intVal($pd->total_item)]);
        }

		Lava::PieChart('produk', $produk, [
		    'title' => 'Penjualan Berdasarkan Produk',
			'titleTextStyle' => [
		        'color'    => '#eb6b2c',
		    ],
		    'is3D'   => true,
		]);

		//member
		$getDataMemberTrx = IndexModel::getDataMemberTrx();
		$lava5         = new Lava; // See note below for Laravel
		$member        = Lava::DataTable();
		$member->addStringColumn('member');
		$member->addNumberColumn('Percent');
	   
        foreach ($getDataMemberTrx as $mem) {
            $member->addRow([''.$mem->name.' ('.intVal($mem->total_item).')', intVal($mem->total_item)]);
        }

		Lava::PieChart('member', $member, [
		    'title' => 'Member yang melakukan transaksi',
			'titleTextStyle' => [
		        'color'    => '#eb6b2c',
		    ],
		    'is3D'   => true,
		]);

		$countTransaksi = Transaksi::count();
		$countTransaksiBulan = Transaksi::whereMonth('created_at', '=', date('m'))->whereYear('created_at', '=', date('Y'))->count();
		$countTransaksiHari = Transaksi::whereDate('created_at', '=', date('Y-m-d'))->count();
		$trxSuccess = Transaksi::whereDate('created_at', '=' ,date('Y-m-d'))->where('status', 1)->count();
		$trxGagal = Transaksi::whereDate('created_at', '=' ,date('Y-m-d'))->where('status', 2)->count();
		$trxProses = Transaksi::whereDate('created_at', '=' ,date('Y-m-d'))->where('status', 0)->count();
		$totalTrxServerHari = Transaksi::whereDate('created_at', '=' ,date('Y-m-d'))->where('status', 1)->sum('harga_default');
		$totalKeuntunganHari = Transaksi::whereDate('created_at', '=' ,date('Y-m-d'))->where('status', 1)->sum('harga_markup');
		$totalTransaksiHari = Transaksi::whereDate('created_at', '=' ,date('Y-m-d'))->where('status', 1)->sum('total');
		
		// =============================================================
		$countDepositBulan = Deposit::whereMonth('created_at', '=' ,date('m'))->whereYear('created_at', '=' ,date('Y'))->count();
		$countDepositHari = Deposit::whereDate('created_at', '=' ,date('Y-m-d'))->count();	
		$reqSuccess = Deposit::whereDate('created_at', '=' ,date('Y-m-d'))->where('status', 1)->count();
		$reqGagal = Deposit::whereDate('created_at', '=' ,date('Y-m-d'))->where('status', 2)->count();
		$reqValidasi = Deposit::whereDate('created_at', '=' ,date('Y-m-d'))->where('status', 3)->count();
		$reqMenunggu = Deposit::whereDate('created_at', '=' ,date('Y-m-d'))->where('status', 0)->count();					

		// ==============================================================

		$countMessageHari = Message::whereDate('created_at', '=' ,date('Y-m-d'))->count();

		// ==============================================================
		
		$totalUserBalance = User::sum('saldo');
		$countUser = User::count();
		$countUserHari = User::whereDate('created_at', '=' ,date('Y-m-d'))->count();
		$newUser = User::orderBy('created_at', 'DESC')->Paginate(8);

		// ===============================================================

		$info = Informasi::orderBy('created_at', 'DESC')->paginate(8);
    	$getSaldo = Setting::where('id','1')->first();
    	$saldo = $getSaldo->saldo;
    	
        $trxs = Transaksi::selectRaw('user_id, COUNT(id) AS total')
            ->where('status', 1)
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
            
        $topUsers = [];
        
        foreach( $trxs as $trx )
        {
            $u = User::selectRaw('id, name')->find($trx->user_id);
            $u->total_trx = $trx->total;
            
            $topUsers[] = $u;
        }
	
		return view('admin.home', compact('countTransaksi', 'countTransaksiBulan', 'countUser', 'countDepositBulan', 'countTransaksiHari', 'countDepositHari', 'countMessageHari', 'countUserHari', 'totalTransaksiHari','totalKeuntunganHari','totalTrxServerHari', 'trxSuccess', 'trxProses', 'trxGagal', 'reqSuccess', 'reqMenunggu', 'reqGagal', 'newUser', 'info', 'topUsers', 'reqValidasi','lava3','produkkategori','lava4','produk','lava5','member','saldo','totalUserBalance'));
	}
	
	public function getByDate(Request $request)
	{
	    $dataFrom = Carbon::parse($request->input('FromDate'))->format('Y-m-d');
	   
	    $dataTo = Carbon::parse($request->input('ToDate'))->format('Y-m-d');
	    
	    //PRODUK OP
		$lava3                 = new Lava; // See note below for Laravel
		$produkkategori        = Lava::DataTable();
		$produkkategori->addStringColumn('produkkategori');
		$produkkategori->addNumberColumn('Percent');
		
		$getDataProdukOperator = IndexModel::getTransaksiOperatorWhereDate($dataFrom,$dataTo);
		
        foreach ($getDataProdukOperator as $trxOP) {
            $produkkategori->addRow([''.$trxOP->product_name.'', intVal($trxOP->total_item)]);
        }

		Lava::PieChart('produkkategori', $produkkategori, [
		    'title' => 'Penjualan Berdasarkan Kategori Produk',
			'titleTextStyle' => [
		        'color'    => '#eb6b2c',
		    ],
		    'is3D'   => true,
		]);
		
		
		//PRODUK
		$getDataProduk = IndexModel::getTransaksiProdukWhereDate($dataFrom,$dataTo);
		$lava4         = new Lava; // See note below for Laravel
		$produk        = Lava::DataTable();
		$produk->addStringColumn('produk');
		$produk->addNumberColumn('Percent');
        foreach ($getDataProduk as $pd) {
            $produk->addRow([''.$pd->product_name.' ('.$pd->code.')', intVal($pd->total_item)]);
        }

		Lava::PieChart('produk', $produk, [
		    'title' => 'Penjualan Berdasarkan Produk',
			'titleTextStyle' => [
		        'color'    => '#eb6b2c',
		    ],
		    'is3D'   => true,
		]);

		//member
		$getDataMemberTrx = IndexModel::getDataMemberTrxWhereDate($dataFrom,$dataTo);
		$lava5         = new Lava; // See note below for Laravel
		$member        = Lava::DataTable();
		$member->addStringColumn('member');
		$member->addNumberColumn('Percent');
	   
        foreach ($getDataMemberTrx as $mem) {
            $member->addRow([''.$mem->name.' ('.intVal($mem->total_item).')', intVal($mem->total_item)]);
        }

		Lava::PieChart('member', $member, [
		    'title' => 'Member yang melakukan transaksi',
			'titleTextStyle' => [
		        'color'    => '#eb6b2c',
		    ],
		    'is3D'   => true,
		]);
          
          
          $chartprodukkategori = "<?= Lava::render('PieChart', 'produkkategori', 'chart-produk-kategori-div') ?>";
          $chartproduk = "<?= Lava::render('PieChart', 'produk', 'chart-produk-div') ?>";
          $chartmember = "<?= Lava::render('PieChart', 'member', 'chart-member-trx-div') ?>";
          
          
                
        //dd($dataFrom);
       
	
		      $start = explode(" ",$dataFrom)[0]." "."00:00:00";
		     
		      $end   = explode(" ",$dataTo)[0]." "."23:59:59";
		      
              $countTrx           = Transaksi::whereBetween('created_at',[$start,$end])->count();
              $countUserHari      = User::whereBetween('created_at', [$start,$end])->count();
              $countMessageHari   = Message::whereBetween('created_at', [$start,$end])->count();	
                      
              $totalTrxServerHari = Transaksi::whereBetween('created_at',[$start,$end])->where('status', 1)->sum('harga_default');
              $totalKeuntunganHari= Transaksi::whereBetween('created_at', [$start,$end])->where('status', 1)->sum('harga_markup');
              $totalTransaksiHari = Transaksi::whereBetween('created_at',[$start,$end])->where('status', 1)->sum('total');
                	  
              $trxSuccess         = Transaksi::whereBetween('created_at',[$start,$end])->where('status', 1)->count();
              //dd($trxSuccess);
              $trxGagal           = Transaksi::whereBetween('created_at',[$start,$end])->where('status', 2)->count();
              $trxProses          = Transaksi::whereBetween('created_at',[$start,$end])->where('status', 0)->count();
              
              $countDepositHari = Deposit::whereBetween('created_at',[$start,$end])->count();
              $reqSuccess = Deposit::whereBetween('created_at',[$start,$end])->where('status', 1)->count();
              $reqGagal = Deposit::whereBetween('created_at', [$start,$end])->where('status', 2)->count();
              $reqValidasi = Deposit::whereBetween('created_at',[$start,$end])->where('status', 3)->count();
              $reqMenunggu = Deposit::whereBetween('created_at', [$start,$end])->where('status', 0)->count();
        		    
              $aktivitas='<thead>';
              $aktivitas .='<tr>';
              $aktivitas .='<td>Transaksi</td>';
              $aktivitas .='<td>:</td>';
              $aktivitas .='<td>'.$countTrx.'</td>';
              if($countTrx == '0'){
                $aktivitas .='<td><a href="#" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" disabled>Lihat</a></td>';
              }else{
                $aktivitas .='<td><a href="'.url('/admin/transaksi/produk').'" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" target="_blank">Lihat</a></td>';
              }
              $aktivitas .='</tr>';
              $aktivitas .='</thead>';
              $aktivitas .='<tbody>';
              $aktivitas .='<tr>';
              $aktivitas .='<td>Member Baru</td>';
              $aktivitas .='<td>:</td>';
              $aktivitas .='<td>'.$countUserHari.'</td>';
              
              if($countUserHari == '0'){
                  $aktivitas .='<td><a href="#" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" disabled>Lihat</a></td>';
              }else{
                $aktivitas .='<td><a href="'.route('users.index').'" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" target="_blank">Lihat</a></td>';
              }
              $aktivitas .='</tr>';
              $aktivitas .='<tr>';
              $aktivitas .='<td>Permintaan Deposit</td>';
              $aktivitas .='<td>:</td>';
              $aktivitas .='<td>'.$countDepositHari.'</td>';
              if($countDepositHari == '0'){
                $aktivitas .='<td><a href="#" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" disabled>Lihat</a></td>';
              }else{
                $aktivitas .='<td><a href="'.url('/admin/transaksi/deposit').'" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" target="_blank">Lihat</a></td>';
              }
              $aktivitas .='</tr>';
              $aktivitas .='<tr>';
              $aktivitas .='<td>Pesan Masuk</td>';
              $aktivitas .='<td>:</td>';
              $aktivitas .='<td>'.$countMessageHari.'</td>';
              if($countMessageHari == '0'){
                $aktivitas .='<td><a href="#" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" disabled>Lihat</a></td>';
              }else{
                $aktivitas .='<td><a href="'.route('messages.index').'" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" target="_blank">Lihat</a></td>';
              }
              $aktivitas .='</tr>';
              $aktivitas .='</tbody>'; $trxnya  = '<table class="table" style="font-size: 13px;">';
              
              $trxnya .= '<thead>';
              $trxnya .='<tr>';
              $trxnya .='<td>Server</td>';
              $trxnya .='<td class="text-left">&nbsp;:&nbsp;</td>';
              $trxnya .='<td class="text-right"><b>'.number_format($totalTrxServerHari, 0, '.', '.').'</b></td>';
              $trxnya .='</tr>';
              $trxnya .='</thead>';
              $trxnya .='<tbody>';
              $trxnya .='<tr>';
              $trxnya .='<td>Laba</td>';
              $trxnya .='<td class="text-left">&nbsp;:&nbsp;</td>';
              $trxnya .='<td class="text-right"><b>'.number_format($totalKeuntunganHari, 0, '.', '.').'</b></td>';
              $trxnya .='</tr>';
              $trxnya .='<tr>';
              $trxnya .='<td>Total</td>';
              $trxnya .='<td class="text-left">&nbsp;:&nbsp;</td>';
              $trxnya .='<td class="text-right"><b>'.number_format($totalTransaksiHari, 0, '.', '.').'</b></td>';
              $trxnya .='</tr>';
              $trxnya .='</tbody>';
              $trxnya .='</table>';
              $trxnya .='<div>';
              $trxnya .='<table class="table table-bordered" >';
              $trxnya .='<tr style="background-color: #F8F8F8;font-size: 10px;">';
              $trxnya .='<th style="text-align: center;">Berhasil</th>';
              $trxnya .='<th style="text-align: center;">Pending</th>';
              $trxnya .='<th style="text-align: center;">Gagal</th>';
              $trxnya .='</tr>';
              $trxnya .='<tr align="center" style="font-size: 15px;font-weight: bold;">';
              $trxnya .='<td>'.$trxSuccess.'</td>';
              $trxnya .='<td>'.$trxProses.'</td>';
              $trxnya .='<td>'.$trxGagal.'</td>';
              $trxnya .='</tr>';
              $trxnya .='</table>';
              $trxnya .='</div>';
              
              $deposit='<div style="text-align: center;margin-bottom: 10px;">';
              $deposit .=' <span style="font-size: 20px;font-weight: bold;">'.$countDepositHari.'</span><br>';
              $deposit .='</div>';
              $deposit .='<table class="table table-bordered" >';
              $deposit .='<tr style="background-color: #F8F8F8;font-size: 10px;">';
              $deposit .='<th style="text-align: center;">Menunggu</th>';
              $deposit .='<th style="text-align: center;">Validasi</th>';
              $deposit .='<th style="text-align: center;">Berhasil</th>';
              $deposit .='<th style="text-align: center;">Gagal</th>';
              $deposit .='</tr>';
              $deposit .='<tr align="center" style="font-size: 15px;font-weight: bold;">';
              $deposit .='<td>'.$reqMenunggu.'</td>';
              $deposit .='<td>'.$reqValidasi.'</td>';
              $deposit .='<td>'.$reqSuccess.'</td>';
              $deposit .='<td>'.$reqGagal.'</td>';
              $deposit .='</tr>';
              $deposit .='</table>';
		
		
        return json_encode(['aktivitas' => $aktivitas, 'trxnya' => $trxnya, 'deposit' => $deposit, 'chartprodukkategori' =>$chartprodukkategori, 'chartproduk' =>$chartproduk, 'chartmember' =>$chartmember]);
        
	}

	public function bulanToInt($bulan)
    {
        Switch ($bulan){
            case "January"   : $bulan="01";
                Break;
            case "February"  : $bulan="02";
                Break;
            case "March"     : $bulan="03";
                Break;
            case "April"     : $bulan="04";
                Break;
            case "May"       : $bulan="05";
                Break;
            case "June"      : $bulan="06";
                Break;
            case "July"      : $bulan="07";
                Break;
            case "August"    : $bulan="08";
                Break;
            case "September" : $bulan="09";
                Break;
            case "October"   : $bulan="10";
                Break;
            case "November"  : $bulan="11";
                Break;
            case "December"  : $bulan="12";
                Break;
            }
        return $bulan;
    }

	public function getByMonth(Request $request)
	{
		
              $data   = $request->bulan;
              $pecah  = explode('-', $data);
              $mounth = $pecah[0];
              $year   = $pecah[1];
              
              $convMount = $this->bulanToInt($mounth);
              
              $countTrx           = Transaksi::whereMonth('created_at', $convMount)->whereYear('created_at', $year)->count();
              $countUserHari      = User::whereMonth('created_at', $convMount)->whereYear('created_at', $year)->count();
              $countMessageHari   = Message::whereMonth('created_at', $convMount)->whereYear('created_at', $year)->count();	
                      
              $totalTrxServerHari = Transaksi::whereMonth('created_at', $convMount)->whereYear('created_at', $year)->where('status', 1)->sum('harga_default');
              $totalKeuntunganHari= Transaksi::whereMonth('created_at', $convMount)->whereYear('created_at', $year)->where('status', 1)->sum('harga_markup');
              $totalTransaksiHari = Transaksi::whereMonth('created_at', $convMount)->whereYear('created_at', $year)->where('status', 1)->sum('total');
                	  
              $trxSuccess         = Transaksi::whereMonth('created_at', $convMount)->whereYear('created_at', $year)->where('status', 1)->count();
              $trxGagal           = Transaksi::whereMonth('created_at', $convMount)->whereYear('created_at', $year)->where('status', 2)->count();
              $trxProses          = Transaksi::whereMonth('created_at', $convMount)->whereYear('created_at', $year)->where('status', 0)->count();
              
              $countDepositHari = Deposit::whereMonth('created_at',$convMount)->whereYear('created_at', $year)->count();
              $reqSuccess = Deposit::whereMonth('created_at',$convMount)->whereYear('created_at', $year)->where('status', 1)->count();
              $reqGagal = Deposit::whereMonth('created_at', $convMount)->whereYear('created_at', $year)->where('status', 2)->count();
              $reqValidasi = Deposit::whereMonth('created_at', $convMount)->whereYear('created_at', $year)->where('status', 3)->count();
              $reqMenunggu = Deposit::whereMonth('created_at', $convMount)->whereYear('created_at', $year)->where('status', 0)->count();
              
              
              //PRODUK OP
		$getDataProdukOperator = IndexModel::getTransaksiOperator();
		$lava3                 = new Lava; // See note below for Laravel
		$produkkategori        = Lava::DataTable();
		$produkkategori->addStringColumn('produkkategori');
		$produkkategori->addNumberColumn('Percent');
		$dataOpertor = array();
	      foreach ($getDataProdukOperator as $trxOP) {
	      	$produkkategori->addRow([$trxOP->product_name, $trxOP->total_item]);
	    	array_push($dataOpertor, ''.$trxOP->product_name.' ('.$trxOP->total_item.')');
	       }

		Lava::PieChart('produkkategori', $produkkategori, [
		    'title' => 'Penjualan Berdasarkan Kategori Produk',
			'titleTextStyle' => [
		        'color'    => '#eb6b2c',
		    ],
		    'is3D'   => true,
		]);
		
		//PRODUK
		$getDataProduk = IndexModel::getTransaksiProduk();
		$lava4         = new Lava; // See note below for Laravel
		$produk        = Lava::DataTable();
		$produk->addStringColumn('produk');
		$produk->addNumberColumn('Percent');
		$dataProduk = array();
	      foreach ($getDataProduk as $pd) {
	      	$produk->addRow([''.$pd->produk.' ('.$pd->code.')' , $pd->total_item]);
	    	array_push($dataProduk, ''.$pd->produk.' ('.$pd->total_item.')');
	       }

		Lava::PieChart('produk', $produk, [
		    'title' => 'Penjualan Berdasarkan Produk',
			'titleTextStyle' => [
		        'color'    => '#eb6b2c',
		        // 'fontSize' => 14
		    ],
		    'is3D'   => true,
		]);

		//member
		$getDataMemberTrx = IndexModel::getDataMemberTrx();
		// dd($getDataMemberTrx);
		$lava5         = new Lava; // See note below for Laravel
		$member        = Lava::DataTable();
		$member->addStringColumn('member');
		$member->addNumberColumn('Percent');
		$dataMemberTrx = array();
	      foreach ($getDataMemberTrx as $memtrx) {
	      	$member->addRow([''.$memtrx->name.' ('.$memtrx->total_item.')' , $memtrx->total_item]);
	    	array_push($dataMemberTrx, ''.$memtrx->name.' ('.$memtrx->total_item.')');
	       }

		Lava::PieChart('member', $member, [
		    'title' => 'Member yang melakukan transaksi',
			'titleTextStyle' => [
		        'color'    => '#eb6b2c',
		        // 'fontSize' => 14
		    ],
		    'is3D'   => true,
		]);
        		    
              $aktivitas='<thead>';
              $aktivitas .='<tr>';
              $aktivitas .='<td>Transaksi</td>';
              $aktivitas .='<td>:</td>';
              $aktivitas .='<td>'.$countTrx.'</td>';
              if($countTrx == '0'){
                $aktivitas .='<td><a href="#" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" disabled>Lihat</a></td>';
              }else{
                $aktivitas .='<td><a href="'.url('/admin/transaksi/produk').'" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" target="_blank">Lihat</a></td>';
              }
              $aktivitas .='</tr>';
              $aktivitas .='</thead>';
              $aktivitas .='<tbody>';
              $aktivitas .='<tr>';
              $aktivitas .='<td>Member Baru</td>';
              $aktivitas .='<td>:</td>';
              $aktivitas .='<td>'.$countUserHari.'</td>';
              if($countUserHari == '0'){
                  $aktivitas .='<td><a href="#" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" disabled>Lihat</a></td>';
              }else{
                $aktivitas .='<td><a href="'.route('users.index').'" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" target="_blank">Lihat</a></td>';
              }
              $aktivitas .='</tr>';
              $aktivitas .='<tr>';
              $aktivitas .='<td>Permintaan Deposit</td>';
              $aktivitas .='<td>:</td>';
              $aktivitas .='<td>'.$countDepositHari.'</td>';
              if($countDepositHari == '0'){
                $aktivitas .='<td><a href="#" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" disabled>Lihat</a></td>';
              }else{
                $aktivitas .='<td><a href="'.url('/admin/transaksi/deposit').'" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" target="_blank">Lihat</a></td>';
              }
              $aktivitas .='</tr>';
              $aktivitas .='<tr>';
              $aktivitas .='<td>Pesan Masuk</td>';
              $aktivitas .='<td>:</td>';
              $aktivitas .='<td>'.$countMessageHari.'</td>';
               if($countMessageHari == '0'){
                $aktivitas .='<td><a href="#" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" disabled>Lihat</a></td>';
              }else{
                $aktivitas .='<td><a href="'.route('messages.index').'" class="btn-loading btn btn-primary" style="font-size: 10px;padding: 3px 5px;" target="_blank">Lihat</a></td>';
              }
              $aktivitas .='</tr>';
              $aktivitas .='</tbody>'; $trxnya  = '<table class="table" style="font-size: 13px;">';
              
              $trxnya .= '<thead>';
              $trxnya .='<tr>';
              $trxnya .='<td>Server</td>';
              $trxnya .='<td class="text-left">&nbsp;:&nbsp;</td>';
              $trxnya .='<td class="text-right"><b>'.number_format($totalTrxServerHari, 0, '.', '.').'</b></td>';
              $trxnya .='</tr>';
              $trxnya .='</thead>';
              $trxnya .='<tbody>';
              $trxnya .='<tr>';
              $trxnya .='<td>Laba</td>';
              $trxnya .='<td class="text-left">&nbsp;:&nbsp;</td>';
              $trxnya .='<td class="text-right"><b>'.number_format($totalKeuntunganHari, 0, '.', '.').'</b></td>';
              $trxnya .='</tr>';
              $trxnya .='<tr>';
              $trxnya .='<td>Total</td>';
              $trxnya .='<td class="text-left">&nbsp;:&nbsp;</td>';
              $trxnya .='<td class="text-right"><b>'.number_format($totalTransaksiHari, 0, '.', '.').'</b></td>';
              $trxnya .='</tr>';
              $trxnya .='</tbody>';
              $trxnya .='</table>';
              $trxnya .='<div>';
              $trxnya .='<table class="table table-bordered" >';
              $trxnya .='<tr style="background-color: #F8F8F8;font-size: 10px;">';
              $trxnya .='<th style="text-align: center;">Berhasil</th>';
              $trxnya .='<th style="text-align: center;">Pending</th>';
              $trxnya .='<th style="text-align: center;">Gagal</th>';
              $trxnya .='</tr>';
              $trxnya .='<tr align="center" style="font-size: 15px;font-weight: bold;">';
              $trxnya .='<td>'.$trxSuccess.'</td>';
              $trxnya .='<td>'.$trxProses.'</td>';
              $trxnya .='<td>'.$trxGagal.'</td>';
              $trxnya .='</tr>';
              $trxnya .='</table>';
              $trxnya .='</div>';
              
              $deposit='<div style="text-align: center;margin-bottom: 10px;">';
              $deposit .=' <span style="font-size: 20px;font-weight: bold;">'.$countDepositHari.'</span><br>';
              $deposit .='</div>';
              $deposit .='<table class="table table-bordered" >';
              $deposit .='<tr style="background-color: #F8F8F8;font-size: 10px;">';
              $deposit .='<th style="text-align: center;">Menunggu</th>';
              $deposit .='<th style="text-align: center;">Validasi</th>';
              $deposit .='<th style="text-align: center;">Berhasil</th>';
              $deposit .='<th style="text-align: center;">Gagal</th>';
              $deposit .='</tr>';
              $deposit .='<tr align="center" style="font-size: 15px;font-weight: bold;">';
              $deposit .='<td>'.$reqMenunggu.'</td>';
              $deposit .='<td>'.$reqValidasi.'</td>';
              $deposit .='<td>'.$reqSuccess.'</td>';
              $deposit .='<td>'.$reqGagal.'</td>';
              $deposit .='</tr>';
              $deposit .='</table>';

              
            return json_encode(['aktivitas' => $aktivitas, 'trxnya' => $trxnya, 'deposit' => $deposit]);
        
	}
	
	public function mode(Request $request){
	    $value = $request->value;
	    $mode = Setting::first();
	    if($value == 'live'){
	        $mode->status = 1;
	    }else{
	        $mode->status = 0;
	    }
	    $mode->save();
	    return Response::json($mode);
	}

	public function getMember(Request $request)
	{
	    if( empty($request->input('q')) ) {
	        return [];
	    }
	    
		$params = [
            'search_text' => $request->input('q'),
        ];

		$data = User::where('name', 'like','%'.strtolower((isset($params['search_text'])?$params['search_text']:'')).'%')->limit(100)->get();
        $results = [];
        
        foreach ($data as $key ) {
            $results[] = [
              'id'     => $key->id,
              'text'   => $key->name,
            ];
        }
        
        return $results;
	}
	
	public function ceksaldo(Request $request)
	{

		$jenis  = $request->input('jenis');
		$member = $request->input('member');

        if($jenis == 'saldo_server')
        {
	        $saldo = Pulsa::cek_saldo();
	        if($saldo->success != true )
	        {
	            return 'error';
	        }
	        else
	        {
			    $ceksaldo = 'Sisa Saldo Utama : Rp '.number_format($saldo->data, 0, '.', '.');
			    return Response::json($ceksaldo);
			}
		 }
		 else
		 {
		 	$data = User::where('id',$member)->first();
		 	if( !$data ) {
		 	    return 'User tidak ditemukan';
		 	}
		 	return 'Saldo '.$data->name.' Rp. '.number_format($data->saldo, 0, '.', '.').'';
		 }
	}

	public function sendInformasi(Request $request)
	{
		$this->validate($request,[
			'isi_informasi' => 'required',
		],[
			'isi_informasi.required' => 'Isi Informasi tidak boleh kosong',
		]);
		$info = new Informasi();
		$info->user_id = Auth::user()->id;
		$info->isi_informasi = $request->isi_informasi;
		$info->save();
		return redirect()->back()->with('alert-success', 'Informasi Berghasil Dikirim');
	}

	public function deleteInformasi($id)
	{
		$info = Informasi::findOrFail($id);
		$info->delete();
		return redirect()->back()->with('alert-success', 'Berhasil Menghapus Data Informasi');
	}
}