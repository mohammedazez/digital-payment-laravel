<?php

namespace App\Http\Controllers\Admin;

use Mail, Response, Input, Validator;
use App\AppModel\Bank;
use App\AppModel\Transaksi;
use App\AppModel\Deposit;
use App\AppModel\Mutasi;
use App\AppModel\SMSGateway;
use App\AppModel\Pin;
use App\Mail\SendEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use DB;
use Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usersMobile = User::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.users.index', compact('usersMobile'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'saldo' => 'required',
            'city' => 'required',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'phone.required' => 'Nomor Handphone tidak boleh kosong',
            'email.required' => 'Alamat Email tidak boleh kosong',
            'email.email' => 'Format Email tidak cocok',
            'password.required' => 'Kata Sandi tidak boleh kosong',
            'password.min' => 'Kata Sandi minimal 6 digit',
            'saldo.required' => 'Saldo tidak boleh kosong',
            'city.required' => 'Kota Sekarang tidak boleh kosong',
        ]);
        $users = new User();
        $users->name = $request->name;
        $users->phone = $request->phone;
        $users->email = $request->email;
        $users->city = $request->city;
        $users->password = bcrypt($request->password);
        $users->saldo = str_replace(".", "", $request->saldo);
        //$users->api_key = bin2hex(openssl_random_pseudo_bytes(30));
        $users->save();
        
        $generatePin = Pin::GeneratePin($users->id);
        
        $authorRole = Role::where('name', $request->role)->first();
        $users->attachRole($authorRole);
        Mail::to($request->email)->queue(new SendEmail($users));
        return redirect()->route('users.index')->with('alert-success', 'Berhasil Membuat User Baru');
    }
    
    public function datataBlesUsers(Request $request)
    {
        $columns = array( 
                        0 =>'no', 
                        1 =>'name',
                        2=> 'email',
                        3=> 'phone',
                        4=> 'city',
                        5=> 'pin',
                        6=> 'saldo',
                        7=> 'status',
                        8=> 'akses',
                        9=> 'created_at',
                        7=> 'action_view',
                        8=> 'action_edit',
                        9=> 'action_hapus',
                    );
                    
        $totalData = User::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
            
        if(empty($request->input('search.value')))
        {            
            $posts = User::offset($start)
                         ->limit($limit)
                         // ->orderBy($order,$dir)
                         ->orderBy('created_at', 'DESC')
                         ->get();
        }else {
            $search = $request->input('search.value'); 

            if(strtoupper($search) == 'NONAKTIF'){
                $stts = '0';
            }elseif(strtoupper($search) == 'AKTIF'){
                $stts = '1';
            };
            
            $posts =  User::where('name','LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->orWhere('phone', 'LIKE',"%{$search}%")
                            ->orWhere('city', 'LIKE',"%{$search}%")
                            ->orWhere('pin', 'LIKE',"%{$search}%")
                            ->orWhere('status', @$stts)
                            ->offset($start)
                            ->limit($limit)
                            // ->orderBy($order,$dir)
                            ->orderBy('created_at', 'DESC')
                            ->get();

            $totalFiltered = User::where('name','LIKE',"%{$search}%")
                            ->orWhere('email', 'LIKE',"%{$search}%")
                            ->orWhere('phone', 'LIKE',"%{$search}%")
                            ->orWhere('city', 'LIKE',"%{$search}%")
                            ->orWhere('pin', 'LIKE',"%{$search}%")
                            ->orWhere('status', @$stts)
                            ->orderBy('created_at', 'DESC')
                            ->count();
        }
        
            $data = array();
            if(!empty($posts))
            {
                $no = 0;
                foreach ($posts as $post)
                {
                    $no++;
                    $nestedData['no']       = $start+$no;
                    $nestedData['name']     = '<td><a href="'.route('users.show', $post->id).'" class="btn-loading">'.$post->name.'</a>';
                    $nestedData['email']    = $post->email;
                    $nestedData['phone']    = $post->phone;
                    $nestedData['city']     = $post->city;
                    $nestedData['pin']      = $post->pin;
                    $nestedData['saldo']    = '<td>Rp.'.number_format($post->saldo, 0, '.', '.').'</span></td>';
                    if($post->status == 0){
                        $nestedData['status'] = '<td><div><label class="label label-danger">NONAKTIF</label></div></td>';
                    }elseif($post->status == 1){
                        $nestedData['status'] = '<td><div><label class="label label-success">AKTIF</label></div></td>';
                    }
    
                    $nestedData['akses']             = $post->roles()->first()['display_name'];
                    $nestedData['created_at']        = Carbon::parse($post->created_at)->format('d M Y H:i:s');
                    if($post->status == 0){
                        $nestedData['action_lock']  = '<td><a href="#" data-trans-id="'.$post->id.'" onClick="buttonUnlock(this);" class="btn-loading btn btn-success btn-sm detail btn-block" style="padding: 2px 5px;font-size:10px;"><i class="fa fa-unlock"></i></a></td>';
                    }else{
                        $nestedData['action_lock']  = '<td><a href="#" data-trans-id="'.$post->id.'" onClick="buttonLock(this);" class="btn-loading btn btn-danger btn-sm detail btn-block" style="padding: 2px 5px;font-size:10px;"><i class="fa fa-lock"></i></a></td>';
                    }
                    $nestedData['action_view']  = '<td><a href="'.route('users.show', $post->id).'" class="btn-loading btn btn-primary btn-sm detail btn-block" style="padding: 2px 5px;font-size:10px;"><i class="fa fa-eye"></i></a></td>';
                    $nestedData['action_edit']  = '<td><a href="'.route('users.edit', $post->id).'" class="btn-loading btn btn-success btn-sm btn-block" style="padding: 2px 5px;font-size:10px;"><i class="fa fa-pencil"></i></a></td>';
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
    
    public function show($id)
    {
        $users = User::findOrFail($id);
        $bank = Bank::all();
        $referred_by = User::where('id', $users->referred_by)->first();
        $referrals = User::where('referred_by', $users->id)->get();
        $mutasi = Mutasi::where('user_id', $users->id)->orderBy('created_at', 'DESC')->limit(500);
        $transaksi = Transaksi::where('user_id', $users->id)->orderBy('created_at', 'DESC')->limit(500);
        return view('admin.users.show', compact('users', 'bank', 'referred_by', 'referrals', 'mutasi', 'transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $users = User::findOrFail($id);
        $roles = Role::all();
        return view('admin.users.edit', compact('users', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'city' => 'required',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'phone.required' => 'Nomor Handphone tidak boleh kosong',
            'city.required' => 'Kota Sekarang tidak boleh kosong',
        ]);

        $users = User::findOrFail($id);
        $users->name = $request->name;
        $users->phone = $request->phone;
        $users->city = $request->city;
        $users->status = $request->status;
        if( !empty($request->new_password) )
        {
            $users->password = bcrypt($request->new_password);
        }
        $users->save();
        if ($users->roles->first()->name != $request->role) {
            $users->roles()->sync([]);
            $authorRole = Role::where('name', $request->role)->first();
            $users->attachRole($authorRole);
        }
        return redirect()->route('users.index')->with('alert-success', 'Berhasil Merubah Data User');
    }
    
    public function depositManual(Request $request)
    {
        $rules = array (
				'nominal' => 'required' 
		);
		$validator = Validator::make ( Input::all (), $rules );
		if ($validator->fails ()){
			return Response::json ( array (
					
					'errors' => $validator->getMessageBag ()->toArray () 
			) );
		} else {
            $banks = Bank::findOrFail($request->bank);
        	$users = User::findOrFail($request->user);
            $deposit = new Deposit();
        	$deposit->bank_id = $request->bank;
            $deposit->code_unik = null;
        	$deposit->nominal = str_replace(".", "", $request->nominal);
        	$deposit->nominal_trf = str_replace(".", "", $request->nominal);
        	$deposit->status = 1;
        	$deposit->expire = 0;
            $deposit->note = "Deposit sebesar Rp ".number_format($deposit->nominal_trf, 0, '.', '.')." berhasil ditambahkan secara MANUAL. Saldo anda saat ini adalah Rp ".number_format($users->saldo + $deposit->nominal_trf, 0, '.', '.');
            $deposit->user_id = $users->id;
        	$deposit->save();
        	
        	$saldo = $users->saldo + $deposit->nominal_trf;
        	$users->saldo = $saldo;
        	$users->save();
    
            $pesan = 'Yth. '.$users->name.', Deposit Rp '.number_format($deposit->nominal_trf, 0, '.', '.').' SUKSES via Deposit MANUAL. Saldo sekarang Rp '.number_format($saldo, 0, '.', '.');
            $notification = SMSGateway::send($users->phone, $pesan);
            
            $mutasi = new Mutasi();
            $mutasi->user_id = $users->id;
            $mutasi->type = 'credit';
            $mutasi->trxid = $deposit->id;
            $mutasi->nominal = $deposit->nominal_trf;
            $mutasi->saldo = $saldo;
            $mutasi->note = 'DEPOSIT/TOP-UP SALDO MANUAL';
            $mutasi->save();
        	
            return Response::json();   
        }
    }
    
    public function ubahSaldoManual(Request $request)
    {
        $rules = array (
                'nominal_saldo' => 'required' 
        );
        $validator = Validator::make ( Input::all (), $rules );
        if ($validator->fails ()){
            return Response::json ( array (
                    
                    'errors' => $validator->getMessageBag ()->toArray () 
            ) );
        } else {

            $note        = $request->note;
            $aksi        = $request->aksi;
            $saldo_input = str_replace(".", "", $request->nominal_saldo);

            $users = User::findOrFail($request->user);
            if($aksi == '+'){
                $saldo = $users->saldo + $saldo_input;
            }else{
                $saldo = $users->saldo - $saldo_input;
            }
            // dd($saldo);
            $users->saldo = $saldo;
            $users->save();
            
            $mutasi = new Mutasi();
            $mutasi->user_id = $users->id;
            if($aksi == '+'){
                $mutasi->type = 'kredit';
            }else{
                $mutasi->type = 'debet';
            }

            $mutasi->nominal = $saldo_input;
            $mutasi->saldo = $saldo;
            $mutasi->note = $request->note?$request->note:''.$aksi.' SALDO MANUAL Rp.'.$saldo_input.'';
            $mutasi->save();
            
            return Response::json();   
        }
    }
    
    public function getPinGenerate(Request $request)
    {
        $id = $request->id;
        $generatePin = Pin::GeneratePin($id);
        return $generatePin;
    }
    
    public function lockUsers(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->id;
            $user = User::findOrFail($id);
            $user->status = '0';
            $user->save();
            DB::commit();
            return response()->json([
                'success'=>'true', 
                'id'  => $id, 
                'message'=>'Lock user success.',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success'=>'false', 
                'message'=> $e->getMessage(),
            ]);
        }
    }    
    
    public function unlockUsers(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = $request->id;
            $user = User::findOrFail($id);
            $user->status = '1';
            $user->save();
            DB::commit();
            return response()->json([
                'success'=>'true', 
                'id'  => $id, 
                'message'=>'Unlock user success.',
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success'=>'false', 
                'message'=> $e->getMessage(),
            ]);
        }
    }
    
    public function lockSaldo($id){
        $user = User::findOrfail($id);
        
        $user->update([
                'status_saldo'=>0
            ]);
        return redirect()->back()->with('alert-succes','Berhasil Memblokir saldo user');
    }
    
    public function unlockSaldo($id){
        $user = User::findOrfail($id);
        
        $user->update([
                'status_saldo'=>1
            ]);
        return redirect()->back()->with('alert-success','Berhasil Membuka pemblokiran saldo user');
    }
}