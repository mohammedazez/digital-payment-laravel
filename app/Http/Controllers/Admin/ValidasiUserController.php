<?php

namespace App\Http\Controllers\Admin;

use Response;
use App\User;
use App\AppModel\Mutasi;
use App\AppModel\Antriantrx;
use App\AppModel\Transaksi;
use App\AppModel\Pembelianproduk;
use App\AppModel\Deposit;
use App\AppModel\Tagihan;
use App\AppModel\Redeem;
use App\AppModel\SMSGateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use DB;
use Auth;
use File;
use Mail;

class ValidasiUserController  extends Controller
{
    public function index()
    {
        $antrianWeb = Antriantrx::orderBy('created_at', 'DESC')->get();
        $antrianMobile = Antriantrx::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.validasi_user.index', compact('antrianWeb', 'antrianMobile'));
    }

    public function getDatatable()
    {
            $data = DB::table('users_validations')
            ->select('users_validations.id', 'users_validations.user_id', 'users_validations.img_ktp','users_validations.img_selfie','users_validations.img_tabungan','users_validations.status', 'users_validations.created_at','users.name')
            ->leftjoin('users','users_validations.user_id','users.id')
            ->orderBy('users_validations.created_at','DESC')
            ->get();
            
             return DataTables::collection($data)

             ->editColumn('id',function($data){
                    return '#'.$data->id.'';
             })


             ->editColumn('img_ktp',function($data){
                    return '<td><img src="'.asset('/img/validation/ktp/'.$data->img_ktp).'" height="20px"></td>';
             })

            ->editColumn('img_selfie',function($data){
                    return '<td><img src="'.asset('/img/validation/selfie/'.$data->img_selfie).'" height="20px"></td>';
             })

            ->editColumn('img_tabungan',function($data){
                if($data->img_tabungan == '' || 'img_tabungan' == null)
                {
                    return '<td>-</td>';
                }else{
                    return '<td><img src="'.asset('/img/validation/tabungan/'.$data->img_tabungan).'" height="20px"></td>';
                }
             })
             
             ->editColumn('status',function($data){
                if($data->status == 0){
                    return '<td><span class="label label-warning">MENUNGGU</span></td>';
                }else{
                    return '<td><span class="label label-success">TERVALIDASI</span></td>';
                }
            })

             ->editColumn('created_at',function($data){
                    return Carbon::parse($data->created_at)->format('d-m-Y H:i:s');
             })

             ->editColumn('action', function($data){
                    return '<a href="'.url('/admin/validasi-users', $data->id).'" class="btn-loading label label-primary">DETAIL</a>';
                })

             ->rawColumns(['id','img_ktp','img_selfie','img_tabungan','created_at','status','action'])
             ->make(true);
    }

    public function showDetail($id)
    {
        $data = DB::table('users_validations')
            ->select('users_validations.id','users_validations.img_kk','users_validations.img_pengguna' ,'users_validations.user_id', 'users_validations.img_ktp','users_validations.img_selfie','users_validations.img_tabungan','users_validations.status', 'users_validations.created_at','users.name', 'users.email', 'users.phone')
            ->leftjoin('users','users_validations.user_id','users.id')
            ->where('users_validations.id', $id)
            ->first();

        return view('admin.validasi_user.show', compact('data'));
    }

    public function approveValidasi($id)
    {
        DB::table('users_validations')
        ->where('id', $id)
        ->update(['status'=>'1']);
        
        $userVal = DB::table('users_validations')
        ->select('id','user_id')
        ->where('id', $id)
        ->first();
        
        $getUser = User::select('email','name','phone')->where('id', $userVal->user_id)->first();
        
        $data = ['email' => $getUser->email, 'name' => $getUser->name, 'status'=>'Tervalidasi'];
        Mail::send('emails.usersValidations', $data, function ($mail) use ($getUser)
        {
          $mail->to($getUser->email, $getUser->name);
          $mail->subject('AKUN TERVALIDASI');
        });
        
        $sms = "Yth. ".$getUser->name.", verifikasi akun Anda telah disetujui";
        SMSGateway::send($getUser->phone, $sms);

        return back()->with('alert-success', 'Status Data Berhasil di Approve');
    }

    public function nonapproveValidasi($id)
    {
        $query = DB::table('users_validations')
            ->select('img_ktp','img_selfie')
            ->where('id',$id)
            ->first();

        $filename_ktp    = public_path().'/img/validation/ktp/'.$query->img_ktp;
        $filename_selfie = public_path().'/img/validation/selfie/'.$query->img_selfie;
        File::delete([$filename_ktp, $filename_selfie]);
        
        $userVal = DB::table('users_validations')
        ->select('id','user_id')
        ->where('id', $id)
        ->first();
        
        $getUser = User::select('email','name')->where('id', $userVal->user_id)->first();
        
        $data = ['email' => $getUser->email, 'name' => $getUser->name, 'status'=>'Gagal Validasi'];
        Mail::send('emails.usersValidations', $data, function ($mail) use ($getUser)
        {
          $mail->to($getUser->email, $getUser->name);
          $mail->subject('AKUN GAGAL VALIDASI');
        });
        
        DB::table('users_validations')
        ->where('id', $id)
        ->delete();

        return redirect()->route('data.validasi-users.index')->with('alert-success', 'Behasil Meghapus Data');
    }

}