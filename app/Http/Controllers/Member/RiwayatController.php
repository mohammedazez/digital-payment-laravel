<?php

namespace App\Http\Controllers\Member;

use Auth, Pulsa, PDF, DB;
use App\AppModel\Transaksi;
use App\AppModel\MenuSubmenu;
use App\AppModel\Tagihan;
use App\AppModel\Setting;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

class RiwayatController extends Controller
{
    public function riwayatTransaksi()
    {
        $URL_uri = request()->segment(1).'/'.request()->segment(2);
        $datasubmenu2 = MenuSubmenu::getSubMenuOneMemberURL($URL_uri)->first();

        if($datasubmenu2->status_sub != 0 )
        {
        	$transaksisWeb = Transaksi::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get();
        	$transaksisMobile = Transaksi::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
        	return view('member.histori.index', compact('transaksisWeb', 'transaksisMobile'));
        }else{
            abort(404);
        }
    }

    public function riwayatTransaksiDatatables(Request $request)
    {

        $columns = array( 
                            0 =>'no', 
                            1 =>'id',
                            2=> 'total',
                            3=> 'target',
                            4=> 'mtrpln',
                            5=> 'pengirim',
                            6=> 'via',
                            7=> 'created_at',
                            8=> 'status',
                            9=> 'action',
                        );
  
        $totalData = Transaksi::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {            
            $posts = Transaksi::where('user_id', Auth::user()->id)
                             ->offset($start)
                             ->limit($limit)
                             ->orderBy('created_at', 'DESC')
                             ->get();
        }else {
            $search = $request->input('search.value'); 

            if(strtoupper($search) == 'PROSES'){
                $stts = '0';
            }elseif(strtoupper($search) == 'BERHASIL'){
                $stts = '1';
            }elseif(strtoupper($search) == 'GAGAL'){
                $stts = '2';
            }elseif(strtoupper($search) == 'REFUND'){
                $stts = '3';
            }else{
                $stts = null;
            };
                  
            $posts =  Transaksi::select('transaksis.id','transaksis.produk','transaksis.target','transaksis.mtrpln','transaksis.pengirim','transaksis.total','transaksis.created_at','transaksis.updated_at','transaksis.status')
                        ->where('transaksis.user_id', Auth::user()->id)
                        ->where(function($q) use ($search, $stts){
                                $q->where('transaksis.id','LIKE',"%{$search}%");
                                $q->orWhere('transaksis.produk', 'LIKE',"%{$search}%");
                                $q->orWhere('transaksis.target', 'LIKE',"%{$search}%");
                                $q->orWhere('transaksis.mtrpln', 'LIKE',"%{$search}%");
                                $q->orWhere('transaksis.via', 'LIKE',"%{$search}%");
                                if($stts != null){
                                    $q->orWhere('transaksis.status', $stts);
                                }
                          })
                        ->offset($start)
                        ->limit($limit)
                        // ->orderBy($order,$dir)
                        ->orderBy('transaksis.created_at', 'DESC')
                        ->get();

             $totalFiltered = Transaksi::select('transaksis.id','transaksis.produk','transaksis.target','transaksis.mtrpln','transaksis.pengirim','transaksis.total','transaksis.created_at','transaksis.updated_at','transaksis.status')
                                ->where('transaksis.user_id', Auth::user()->id)
                                ->where(function($q) use ($search, $stts){
                                    $q->where('transaksis.id','LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.produk', 'LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.target', 'LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.mtrpln', 'LIKE',"%{$search}%");
                                    $q->orWhere('transaksis.via', 'LIKE',"%{$search}%");
                                    if($stts != null){
                                        $q->orWhere('transaksis.status', $stts);
                                    }
                                  })
                                ->orderBy('transaksis.created_at', 'DESC')
                                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $no = 0;
            foreach ($posts as $post)
            {
                $no++;
                $nestedData['no']         = $start+$no;
                $nestedData['id']         = '#'.$post->id;
                $nestedData['produk']     = $post->produk;
                $nestedData['total']      = '<td>Rp. '.number_format($post->total, 0, '.', '.').'</td>';
                $nestedData['target']     = $post->target;
                $nestedData['mtrpln']     = $post->mtrpln;
                $nestedData['pengirim']   = $post->pengirim;
                $nestedData['via']        = '<code>'.$post->via.'<code>';
                $nestedData['created_at'] = Carbon::parse($post->created_at)->format('d M Y H:i:s');

                if($post->status == 0){
                    $nestedData['status'] = '<td><span class="label label-warning">PROSES</span></td>';
                }elseif($post->status == 1){
                    $nestedData['status'] = '<td><span class="label label-success">BERHASIL</span></td>';
                }elseif($post->status == 2){
                    $nestedData['status'] = '<td><span class="label label-danger">GAGAL</span></td>';
                }elseif($post->status == 3){
                    $nestedData['status'] = '<td><span class="label label-primary">REFUND</span></td>';
                };
                $nestedData['action'] = '<td><a href="'.url('/member/riwayat-transaksi', $post->id).'" class="btn-loading label label-primary">Detail</a></td>';
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        return json_encode($json_data);
    }

    public function showTransaksi($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::user()->id)->findOrFail($id);
        return view('member.histori.show', compact('transaksi'));
    }
    
    public function printShow($id)
    {
        $user = Auth::user();
        
        $trx              = Transaksi::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        $user             = User::where('id', $trx->user_id)->firstOrFail();
        $tagihan = null;
        if(!empty($trx->tagihan_id)){
            $tagihan          = Tagihan::where('tagihan_id', $trx->tagihan_id)->firstOrFail();    
        }
        
        $GeneralSettings  = setting();
        
        if( !empty($tagihan) )
        {
            $pdf         = new PDF();
            $customPaper = array(0,0,200,300);
            $pdf         = PDF::loadView('member.histori.print_pembayaran', compact('trx','tagihan','user','GeneralSettings'))->setPaper($customPaper);
        }
        else
        {
            $pdf         = new PDF();
            $customPaper = array(0,0,200,250);
            $pdf         = PDF::loadView('member.histori.print_pembelian', compact('trx','user','GeneralSettings'))->setPaper($customPaper);
        }
        
        $SavePrintName = 'trx_'.strtolower($trx->code).'_'.(!empty($trx->mtrpln) && $trx->mtrpln != '-' ? $trx->mtrpln : $trx->target).'-'.date('d-m-Y_H-i-s');
        
        return $pdf->stream($SavePrintName.'.pdf', array("Attachment" => 0));
    }
    public function printEdit($id)
    {
        $trx        = Transaksi::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
      
        $user       = User::where('id', $trx->user_id)->first();
        $tagihan = null;
        if(!empty($trx->tagihan_id)){
            $tagihan          = Tagihan::where('tagihan_id', $trx->tagihan_id)->firstOrFail();    
        }
        
        if( !empty($tagihan) )
        {
            return view('member.histori.edit_print_pembayaran', compact('trx','tagihan','user','GeneralSettings'));
        }
        else
        {
            return view('member.histori.edit_print_pembelian', compact('trx','user','GeneralSettings'));
        }
    }
}