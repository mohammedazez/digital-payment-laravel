<?php

namespace App\Http\Controllers\Member;

use Auth, Validator, Response, Input;
use App\AppModel\Membership;
use App\AppModel\Transaksi;
use App\AppModel\BlockPhone;
use App\AppModel\Setting;
use App\AppModel\Deposit;
use App\Role;
use App\AppModel\Mutasi;
use App\AppModel\Users_validation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DateTime;
use DB;
class MembershipController extends Controller
{

  //role user
  public $personal_role   = 1;
  public $admin_role      = 2;
  public $agen_role       = 3;
  public $enterprise_role = 4;
  
  public function __construct()
  {
      $this->settings = Setting::first();
  }

  public function index()
  {
      $roleId = Auth::user()->roles()->first()->id;
      $setting = Setting::first();
      
      if($roleId == $this->personal_role || $roleId == $this->admin_role)
      {
        $tgl1 =  Carbon::parse(Auth::user()->created_at)->format('Y-m-d');
      }
      elseif($roleId == $this->agen_role)
      {
        $membership = Membership::where('user_id', Auth::user()->id)->where('to_role', $roleId)->first();
        $tgl1 = ($membership->tgl_validasi !=NULL)?$membership->tgl_validasi:Carbon::parse(Auth::user()->created_at)->format('Y-m-d');
      }
      elseif($roleId == $this->enterprise_role)
      {
        $membership = Membership::where('user_id', Auth::user()->id)->where('to_role', $roleId)->first();
        $tgl1 = ($membership->tgl_validasi !=NULL)?$membership->tgl_validasi:Carbon::parse(Auth::user()->created_at)->format('Y-m-d');
      }
        
      $awal = $tgl1;
      $akhir= date('Y-m-d');
      $tglAwal = strtotime($awal);
      $tglAkhir = strtotime($akhir);
      $jeda = abs($tglAkhir - $tglAwal);
      $hari =  floor($jeda/(60*60*24));
      $countFinish =  floor($hari/30);
      
      $timestampPlus = strtotime($tgl1);
      for ($i = 0; $i < $countFinish; $i++) {
          $timestampPlus = strtotime('+30 day', $timestampPlus);
      }

      $timestampMinus = date('Y-m-d', strtotime('-30 day', $timestampPlus));
      $endedTimestamp = date('Y-m-d', strtotime('+30 day', $timestampPlus));

      $diffDay = abs($timestampPlus - strtotime(date('Y-m-d')));
      $minusDay = floor($diffDay/(60*60*24));
      $toDay = date('d-m-Y',$timestampPlus);
      
      $start_date = new DateTime(date('Y-m-d'));
      $end_date = new DateTime($endedTimestamp);
      $interval = $start_date->diff($end_date);
      $selisihhari = $interval->days;

      if($roleId == $this->personal_role || $roleId == $this->admin_role)
      {
        $count = Transaksi::where('user_id',Auth::user()->id);
        $countTransaksiSuccesBulan = $count->where('status', '1')->count();
        $countTransaksiGagalBulan =  $count->where('status', '2')->count();
        $countTransaksiProsesBulan = $count->where('status', '0')->count();
      }
      else
      {
        $count = Transaksi::where('user_id',Auth::user()->id)->where('created_at', '>=', date("Y-m-d", $timestampPlus))->where('created_at', '<=', $endedTimestamp);
        $countTransaksiSuccesBulan = $count->where('status', '1')->count();
        $countTransaksiGagalBulan =  $count->where('status', '2')->count();
        $countTransaksiProsesBulan = $count->where('status', '0')->count();
      }

      return view('member.membership.index', compact('selisihhari','endedTimestamp','timestampMinus','awal','minusDay','toDay','countTransaksiSuccesBulan','countTransaksiGagalBulan','countTransaksiProsesBulan','setting'));
  }

  public function upgradelevel(Request $request)
  {
    
    if(empty($request->file('siup_membership'))){
        return response()->json(['success'=>false,'message'=>'Mohon sertakan Surat ijin usaha atau tanda daftar perusahaan anda'],500);
    }
    
    $siup = $request->file('siup_membership')->getClientOriginalExtension();
    if(!in_array($siup,['png','jpeg','jpg'])){
        return response()->json(['success'=>false,'message'=>'Format File yang anda upload tidak didukung'],500);
    }
    
    $cekPhoneUser = BlockPhone::where('phone',Auth::user()->phone)->count();
    if($cekPhoneUser == '1')
    {
      return response()->json([
          'success' => false,
          'message' => 'Maaf, status no.handphone anda ada dalam daftar blokir kami!.',
      ], 200);
    }
    
    $roleId = Auth::user()->roles()->first()->id;
    
    if($request->to_level == $roleId){
            return response()->json([
                'success' => false,
                'message' => 'Maaf, Status membership anda sudah di level '.Auth::user()->roles()->first()->display_name.'.',
            ], 200);
    }
    
    if(($roleId == 1 || $roleId == 2) && $request->to_level == 4){
            return response()->json([
                'success' => false,
                'message' => 'Maaf, level membership anda adalah '.Auth::user()->roles()->first()->display_name.', anda belum berhak untuk upgrade ke Level '.Role::find($request->to_level)->display_name.'.',
            ], 200); 
    }
    
    if(($roleId == 1) && $request->to_level == 2){
            return response()->json([
                'success' => false,
                'message' => 'Error upgrade.',
            ], 200); 
    }
    
    if($request->to_level < $roleId){
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak bisa mendowngrade level anda sendiri karena sistem kami sudah berjalan otomatis!.',
            ], 200);
    }


    $check = Membership::where('user_id', Auth::user()->id)->where('from_role', $roleId)->where('status', 0)->first();
    if( !is_null($check) && $check->status == '0'){
      return response()->json([
          'success' => false,
          'message' => 'Data anda sudah ada dalam pengajuan upgrade, dan belom di Approve!.',
      ], 200);
    }

    if( !is_null($check) ) {
      return response()->json([
          'success' => false,
          'message' => 'Data anda sudah ada dalam pengajuan Upgrade!.',
      ], 200);
    }
    
    $query = Users_validation::where('user_id', Auth::user()->id)->count();
    if( $query == 0 && $this->settings->force_verification == 1 )
    {
        return response()->json([
            'success' => false,
            'message' => 'Fitur upgrade membership hanya diperuntukkan oleh user yang tervalidasi, silahkan lakukan validasi terlebih dahulu!.',
        ], 200);
    }
    
    $currentBalance = Auth::user()->saldo;

    // jika mau upgrade ke AGEN
    if($request->to_level == $this->agen_role)
    {
        $count = Deposit::where('user_id', Auth::user()->id)
                        ->where('created_at', '>=', Carbon::now()->subDays(3)->toDateTimeString())
                        ->where('nominal','>=', 250000)
                        ->where('status', 1)
                        ->count();
                    
        if($count == 0)
        {
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan deposit minimal Rp.250.000 dihitung sejak 3 hari kebelakang',
            ], 200);
        }
    }

    // jika mau upgrade ke ENTERPRISE
    if($request->to_level == $this->enterprise_role)
    {
        $count = Deposit::where('user_id', Auth::user()->id)
                        ->where('created_at', '>=', Carbon::now()->subDays(3)->toDateTimeString())
                        ->where('nominal','>=', 500000)
                        ->where('status', 1)
                        ->count();
                        
        if($count == '0'){
            return response()->json([
                'success' => false,
                'message' => 'Anda belum melakukan deposit minimal Rp. 500.000 dihitung sejak 3 hari kebelakang',
            ], 200);
        }
    }

    if( !$check )
    {
      DB::beginTransaction();
      
      try
      {
          $siup = $request->file('siup_membership');
          $filename = str_random(20).'.'.$siup->getClientOriginalExtension();
          
          $siup->move('img/membership/siup/',$filename);
          
          $addToUpgrade = new Membership();
          $addToUpgrade->user_id =  Auth::user()->id;
          $addToUpgrade->from_role = $roleId;
          $addToUpgrade->to_role = $request->to_level;
          $addToUpgrade->img_siup = $filename;
          $addToUpgrade->save();
          
          DB::commit();
          
          return response()->json([
              'success' => true,
              'message' => 'anda berhasil melakukan pengajuan upgrade, selanjutnya akan divalidasi oleh admin!.',
          ], 200);
      }
      catch (\Exception $e)
      {
          DB::rollback();
          report($e);
          return response()->json([
              'success' => false,
              'message' => 'Gagal melakukan pengajuan upgrade, silahkan ulangi beberaapa saat!.',
          ], 200);
      }
    }

  }

}
