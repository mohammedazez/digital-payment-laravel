<?php

namespace App\Http\Controllers\Member;

use Auth;
use App\AppModel\Tagihan;
use App\AppModel\MenuSubmenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class TagihanController extends Controller
{
    public function tagihanPembayaran()
    { 
        $URL_uri = ''.request()->segment(1).'/'.request()->segment(2).'';
        $datasubmenu2 = MenuSubmenu::getSubMenuOneMemberURL($URL_uri)->first();

        if($datasubmenu2->status_sub != 0 )
        {
            $tagihanMobile = Tagihan::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->paginate(10);
            return view('member.tagihan.index', compact('tagihanMobile'));
        }else{
            abort(404);
        }
    }

    public function tagihanPembayaranDatatables(Request $request)
    {
        $columns = array( 
                            0 =>'no', 
                            1 =>'product_name',
                            2=> 'no_pelanggan',
                            3=> 'nama',
                            4=> 'periode',
                            5=> 'via',
                            6=> 'status',
                            7=> 'expired',
                            8=> 'created_at',
                            9=> 'action',
                        );
  
        $totalData = Tagihan::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {            
            $posts = Tagihan::where('user_id', Auth::user()->id)
                         ->offset($start)
                         ->limit($limit)
                         // ->orderBy($order,$dir)
                         ->orderBy('created_at', 'DESC')
                         ->get();
        }
        else {
            $search = $request->input('search.value'); 

            if(strtoupper($search) == 'MENUNGGU'){
                $stts = '0';
            }elseif(strtoupper($search) == 'PROSES'){
                $stts = '1';
            }elseif(strtoupper($search) == 'BERHASIL'){
                $stts = '2';
            }elseif(strtoupper($search) == 'GAGAL'){
                $stts = '3';
            }elseif(strtoupper($search) == 'REFUND'){
                $stts = '4';
            }else{
                $stts = null;
            };

            if(strtoupper($search) == 'AKTIF'){
                $exp = '1';
            }elseif(strtoupper($search) == 'EXPIRED'){
                $exp = '0';
            }else{
                $exp = null;
            };
                  
            $posts =  Tagihan::select('tagihans.id','tagihans.product_name','tagihans.no_pelanggan','tagihans.nama','tagihans.jumlah_bayar','tagihans.expired','tagihans.periode','tagihans.created_at','tagihans.updated_at','tagihans.status','tagihans.expired')
                            ->where('tagihans.user_id', Auth::user()->id)
                            ->where(function($q) use ($search, $stts, $exp){
                                    $q->where('tagihans.id','LIKE',"%{$search}%");
                                    $q->orWhere('tagihans.product_name', 'LIKE',"%{$search}%");
                                    $q->orWhere('tagihans.no_pelanggan', 'LIKE',"%{$search}%");
                                    $q->orWhere('tagihans.nama', 'LIKE',"%{$search}%");
                                    $q->orWhere('tagihans.via', 'LIKE',"%{$search}%");
                                    if($exp != null){
                                        $q->orWhere('tagihans.expired', $exp);
                                    }
                                    
                                    if($stts != null){
                                        $q->orWhere('tagihans.status', $stts);
                                    }
                              })
                            ->offset($start)
                            ->limit($limit)
                            // ->orderBy($order,$dir)
                            ->orderBy('tagihans.created_at', 'DESC')
                            ->get();

            $totalFiltered = Tagihan::select('tagihans.id','tagihans.product_name','tagihans.no_pelanggan','tagihans.nama','tagihans.jumlah_bayar','tagihans.expired','tagihans.periode','tagihans.created_at','tagihans.updated_at','tagihans.status','tagihans.expired')
                            ->where('tagihans.user_id', Auth::user()->id)
                            ->where(function($q) use ($search, $stts, $exp){
                                    $q->where('tagihans.id','LIKE',"%{$search}%");
                                    $q->orWhere('tagihans.product_name', 'LIKE',"%{$search}%");
                                    $q->orWhere('tagihans.no_pelanggan', 'LIKE',"%{$search}%");
                                    $q->orWhere('tagihans.nama', 'LIKE',"%{$search}%");
                                    $q->orWhere('tagihans.via', 'LIKE',"%{$search}%");
                                    if($exp != null){
                                        $q->orWhere('tagihans.expired', $exp);
                                    }
                                    if($stts != null){
                                        $q->orWhere('tagihans.status', $stts);
                                    }
                              })
                            ->orderBy('tagihans.created_at', 'DESC')
                            ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $no = 0;
            foreach ($posts as $post)
            {
                $no++;
                $nestedData['no']            = $start+$no;
                $nestedData['product_name']  = $post->product_name;
                $nestedData['no_pelanggan']  = $post->no_pelanggan;
                $nestedData['nama']          = $post->nama;
                $nestedData['periode']       = $post->periode;
                $nestedData['via']           = '<code>'.$post->via.'</code>';
                
                if($post->status == 0){
                    $nestedData['status'] = '<td><span class="label label-warning">MENUNGGU</span></td>';
                }elseif($post->status == 1){
                    $nestedData['status'] = '<td><span class="label label-warning">PROSES</span></td>';
                }elseif($post->status == 2){
                    $nestedData['status'] = '<td><span class="label label-success">BERHASIL</span></td>';
                }else{
                    $nestedData['status'] = '<td><span class="label label-danger">GAGAL</span></td>';
                };

                if($post->expired == 1){
                    $nestedData['expired'] = '<td><span class="label label-info">AKTIF</span></td>';
                }else{
                    $nestedData['expired'] = '<td><span class="label label-danger">EXPIRED</span></td>';
                };

                $nestedData['created_at']    = Carbon::parse($post->created_at)->format('d M Y H:i:s');

                if($post->status == 0){
                    $nestedData['action'] = '<a href="'.url("/member/tagihan-pembayaran", $post->id).'" class="btn-loading label label-primary">Bayar</a>';
                }elseif($post->status == 1){
                    $nestedData['action'] = '<a href="'.url("/member/tagihan-pembayaran", $post->id).'" class="btn-loading label label-primary">Detail</a>';
                }elseif($post->status == 2){
                    $nestedData['action'] = '<a href="'.url("/member/tagihan-pembayaran", $post->id).'" class="btn-loading label label-primary">Detail</a>';
                }else{
                    $nestedData['action'] = '<a href="'.url("/member/tagihan-pembayaran", $post->id).'" class="btn-loading label label-primary">Detail</a>';
                };

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
    
    public function showTagihan($id)
    {
        $tagihan = Tagihan::where('user_id', Auth::user()->id)->findOrFail($id);
        return view('member.tagihan.show', compact('tagihan'));
    }
}