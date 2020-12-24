<?php

namespace App\Http\Controllers\Member;

use App\User;
use Auth;
use App\AppModel\MenuSubmenu;
use App\AppModel\Bonus;
use App\AppModel\Komisiref;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB,Log;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\AppModel\Users_validation;

class ReferralController extends Controller
{
    public function referral()
    {
        $URL_uri = request()->segment(1).'/'.request()->segment(2);
        $datasubmenu2 = MenuSubmenu::getSubMenuOneMemberURL($URL_uri)->first();

        if($datasubmenu2->status_sub != 0 )
        {
            $referrals = User::where('referred_by', Auth::user()->id)->get();
            $coderef = url('/').'/register?ref='.sprintf("%04d", Auth::user()->id);
            
            $user_validation = Users_validation::where('user_id',Auth::user()->id)->first();
            
            return view('member.bonus.referral', compact('referrals','coderef','user_validation'));
        }
        else
        {
            abort(404);
        }
    }
    
    public function referralDatatables()
    {
        $referrals = User::where('referred_by', Auth::user()->id);

        return DataTables::eloquent($referrals)

         ->editColumn('id',function($data){
                return '#'.$data->id.'';
         })
         ->editColumn('level_user',function($data){
                $q = $data->roles()->first();
                return $q->display_name;
         })
         ->editColumn('status',function($data){
            if($data->status == 1){
                return '<td><label class="label label-success">AKTIF</label></td>';
            }else{
                return '<td><label class="label label-danger">TIDAK AKTIF</label></td>';
            };
        })

        ->editColumn('trx_bulan_ini',function($data){
            $sq = $data->transaksis()->where('status', 1)->whereMonth('created_at', '=' ,date('m'))->whereYear('created_at', '=' ,date('Y'))->count();
            return '<td>'.$sq.'</td>';
        })

        ->editColumn('count_trx',function($data){
            $sq = $data->transaksis->where('status', 1)->count();
            return '<td>'.$sq.'</td>';
        }) 

        ->editColumn('count_deposit_success',function($data){
            $sq = $data->deposit->where('status', 1)->count();
            return '<td>'.$sq.'</td>';
        })

        ->editColumn('created_at',function($data){
                return dateInd($data);
         })

         ->rawColumns(['id','status','trx_bulan_ini','count_trx','count_deposit_success','created_at'])
         ->make(true);
    }

    public function bonusTransaksi()
    {
        $referral = User::where('referred_by', Auth::id())->whereHas('transaksis', function ($query) {
                        $query->where('status', 1);
                    })->get();
        return view('member.bonus.bonus-transaksi', compact('referral'));
    }
    
    public function bonusKomisi()
    {
         $komisi_trx_pulsa  = Komisiref::select('mutasis_komisi.id', 'mutasis_komisi.note', 'mutasis_komisi.komisi', 'mutasis_komisi.created_at', 'mutasis_komisi.updated_at', 'users.name')
                ->where('user_id',Auth::user()->id)
                ->where('jenis_komisi',3)
                ->orwhere('jenis_komisi',4)
                ->orwhere('jenis_komisi',5)
                ->leftjoin('users','mutasis_komisi.user_id','users.id')
                ->get();


        $komisi_referreal  = Komisiref::select('mutasis_komisi.id', 'mutasis_komisi.note', 'mutasis_komisi.komisi', 'mutasis_komisi.created_at', 'mutasis_komisi.updated_at', 'users.name')
                ->where('user_id',Auth::user()->id)
                ->where('jenis_komisi',3)
                ->orwhere('jenis_komisi',4)
                ->orwhere('jenis_komisi',5)
                ->leftjoin('users','mutasis_komisi.from_reff_id','users.id')
                ->get();

        return view('member.bonus.bonus-transaksi', compact('komisi_trx_pulsa','komisi_referreal'));
    }

    public function bonusKomisiDatatablesOne(Request $request)
    {
        $columns = array( 
                            0 =>'no', 
                            1 =>'name',
                            2=> 'note',
                            3=> 'komisi',
                            4=> 'created_at',
                        );

        $id        = Auth::user()->id;
        $totalData = Komisiref::select('mutasis_komisi.id', 'mutasis_komisi.note', 'mutasis_komisi.komisi', 'mutasis_komisi.created_at', 'mutasis_komisi.updated_at', 'users.name')
        ->where('user_id',$id)
        ->where('jenis_komisi',3)
        ->orwhere('jenis_komisi',4)
        ->orwhere('jenis_komisi',5)
        ->leftjoin('users','mutasis_komisi.from_reff_id','users.id')
        ->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {             
            $posts =  Komisiref::select('mutasis_komisi.id', 'mutasis_komisi.note', 'mutasis_komisi.komisi', 'mutasis_komisi.created_at', 'mutasis_komisi.updated_at', 'users.id as usid', 'users.name')
                        ->leftjoin('users','mutasis_komisi.from_reff_id','users.id')
                        ->where('user_id',$id)
                        ->where('jenis_komisi',3)
                        ->orwhere('jenis_komisi',4)
                        ->orwhere('jenis_komisi',5)
                         ->offset($start)
                         ->limit($limit)
                         // ->orderBy($order,$dir)
                         ->orderBy('mutasis_komisi.created_at', 'DESC')
                         ->get();

        }else {
            $search = $request->input('search.value'); 
                  
            $posts =  Komisiref::select('mutasis_komisi.id', 'mutasis_komisi.note', 'mutasis_komisi.komisi', 'mutasis_komisi.created_at', 'mutasis_komisi.updated_at', 'users.id as usid', 'users.name')
                        ->leftjoin('users','mutasis_komisi.from_reff_id','users.id')
                        ->where('mutasis_komisi.user_id', Auth::user()->id)
                        ->where('mutasis_komisi.jenis_komisi',3)
                        ->orwhere('mutasis_komisi.jenis_komisi',4)
                        ->orwhere('mutasis_komisi.jenis_komisi',5)
                        ->where(function($q) use ($search){
                                $q->where('users.name','LIKE',"%{$search}%");
                                $q->orWhere('mutasis_komisi.note', 'LIKE',"%{$search}%");
                          })
                        ->offset($start)
                        ->limit($limit)
                        // ->orderBy($order,$dir)
                        ->orderBy('mutasis_komisi.created_at', 'DESC')
                        ->get();

             $totalFiltered = Komisiref::select('mutasis_komisi.id', 'mutasis_komisi.note', 'mutasis_komisi.komisi', 'mutasis_komisi.created_at', 'mutasis_komisi.updated_at', 'users.id as usid', 'users.name')
                                ->leftjoin('users','mutasis_komisi.from_reff_id','users.id')
                                ->where('mutasis_komisi.user_id', Auth::user()->id)
                                ->where('mutasis_komisi.jenis_komisi',3)
                                ->orwhere('mutasis_komisi.jenis_komisi',4)
                                ->orwhere('mutasis_komisi.jenis_komisi',5)
                                ->where(function($q) use ($search){
                                        $q->where('users.name','LIKE',"%{$search}%");
                                        $q->orWhere('mutasis_komisi.note', 'LIKE',"%{$search}%");
                                  })
                                ->orderBy('mutasis_komisi.created_at', 'DESC')
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
                $nestedData['name']       = '<td><a href="'.url('/admin/users', (isset($post->user->id)?''.$post->user->id.'':''.$post->usid.'')).'" class="btn-loading">'.(isset($post->user->name)?''.$post->user->name.'':''.$post->name.'').'</a></td>';
                $nestedData['note']       = $post->note;
                $nestedData['komisi']     = '<td>Rp. '.number_format($post->komisi, 0, '.', '.').'</td>';
                $nestedData['created_at'] = Carbon::parse($post->created_at)->format('d M Y H:i:s');

                $data[]                   = $nestedData;

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

    public function bonusKomisiDatatables(Request $request)
    {
        $columns = array( 
                            0 =>'no', 
                            1 =>'name',
                            2=> 'note',
                            3=> 'komisi',
                            4=> 'created_at',
                        );

        $id        = Auth::user()->id;
        $totalData = Komisiref::select('mutasis_komisi.id', 'mutasis_komisi.note', 'mutasis_komisi.komisi', 'mutasis_komisi.created_at', 'mutasis_komisi.updated_at', 'users.name')
        ->where('user_id',$id)
        ->where('jenis_komisi',2)
        ->leftjoin('users','mutasis_komisi.from_reff_id','users.id')
        ->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {             
            $posts =  Komisiref::select('mutasis_komisi.id', 'mutasis_komisi.note', 'mutasis_komisi.komisi', 'mutasis_komisi.created_at', 'mutasis_komisi.updated_at', 'users.id as usid', 'users.name')
                        ->leftjoin('users','mutasis_komisi.from_reff_id','users.id')
                        ->where('user_id',$id)
                        ->where('jenis_komisi',3)
                        ->orwhere('jenis_komisi',4)
                        ->orwhere('jenis_komisi',5)
                         ->offset($start)
                         ->limit($limit)
                         // ->orderBy($order,$dir)
                         ->orderBy('mutasis_komisi.created_at', 'DESC')
                         ->get();

        }else {
            $search = $request->input('search.value'); 
                  
            $posts =  Komisiref::select('mutasis_komisi.id', 'mutasis_komisi.note', 'mutasis_komisi.komisi', 'mutasis_komisi.created_at', 'mutasis_komisi.updated_at', 'users.id as usid', 'users.name')
                        ->leftjoin('users','mutasis_komisi.from_reff_id','users.id')
                        ->where('mutasis_komisi.user_id', Auth::user()->id)
                        ->where('mutasis_komisi.jenis_komisi',3)
                        ->orwhere('mutasis_komisi.jenis_komisi',4)
                        ->orwhere('mutasis_komisi.jenis_komisi',5)
                        ->where(function($q) use ($search){
                                $q->where('users.name','LIKE',"%{$search}%");
                                $q->orWhere('mutasis_komisi.note', 'LIKE',"%{$search}%");
                          })
                        ->offset($start)
                        ->limit($limit)
                        // ->orderBy($order,$dir)
                        ->orderBy('mutasis_komisi.created_at', 'DESC')
                        ->get();

             $totalFiltered = Komisiref::select('mutasis_komisi.id', 'mutasis_komisi.note', 'mutasis_komisi.komisi', 'mutasis_komisi.created_at', 'mutasis_komisi.updated_at', 'users.id as usid', 'users.name')
                                ->leftjoin('users','mutasis_komisi.from_reff_id','users.id')
                                ->where('mutasis_komisi.user_id', Auth::user()->id)
                                ->where('mutasis_komisi.jenis_komisi',3)
                                ->orwhere('mutasis_komisi.jenis_komisi',4)
                                ->orwhere('mutasis_komisi.jenis_komisi',5)
                                ->where(function($q) use ($search){
                                        $q->where('users.name','LIKE',"%{$search}%");
                                        $q->orWhere('mutasis_komisi.note', 'LIKE',"%{$search}%");
                                  })
                                ->orderBy('mutasis_komisi.created_at', 'DESC')
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
                $nestedData['name']       = '<td><a href="'.url('/admin/users', (isset($post->user->id)?''.$post->user->id.'':''.$post->usid.'')).'" class="btn-loading">'.(isset($post->user->name)?''.$post->user->name.'':''.$post->name.'').'</a></td>';
                $nestedData['note']       = $post->note;
                $nestedData['komisi']     = '<td>Rp. '.number_format($post->komisi, 0, '.', '.').'</td>';
                $nestedData['created_at'] =  Carbon::parse($post->created_at)->format('d M Y H:i:s');


                $data[]                   = $nestedData;

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
    
    public function kode_referral(Request $request){
        
        $ref_id = ltrim($request->referred_by,'0');
        $user_ref = User::where('id',$ref_id)->first();
        
        if(!$user_ref){
            return redirect()->back()->with('alert-error','User Referral tidak dapat ditemukan');
        }
        
        $user_id = auth()->user()->id;
        $user = User::where('id',$user_id)->first();
        
        if($ref_id == $user->id){
            return redirect()->back()->with('alert-error','Anda Tidak bisa Memasukkan Kode referral anda sendiri');
        }
        
        if(!empty($user->referred_by)){
            return redirect()->back()->with('alert-error','Anda Sudah Mempunyai referral user');
        }
        
        if($user->update([
                'referred_by'=>$ref_id          
            ])){
                 return redirect()->back()->with('alert-success','Berhasil Menambahkan user referral');
            }
            
    }

}