<?php

namespace App\Http\Controllers\Member;

use Auth, Response, DB,Hash,Validator,Mail,Exception;
use App\AppModel\Testimonial;
use App\AppModel\Mutasi;
use App\AppModel\Informasi;
use App\AppModel\MenuSubmenu;
use App\AppModel\Pin;
use App\AppModel\Users_validation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppModel\SMSGateway;
use App\AppModel\SMSGatewaySetting;
use App\User;
use App\AppModel\Setting;
use App\AppModel\PaypalModel;

class ProfilController extends Controller
{
    public function index()
    {
    	return view('member.profile.index');
    }
    
	public function biodata()
	{
    	$URL_uri = request()->segment(1).'/'.request()->segment(2);
        $datasubmenu2 = MenuSubmenu::getSubMenuOneMemberURL($URL_uri)->first();
        
        $getSetting = SMSGatewaySetting::all();
        $sms_setting = [];
        
        foreach($getSetting as $s)
        {
            $n = $s->name;
            $v = $s->value;
            
            $sms_setting[$n] = $v;
        }

        if( $datasubmenu2->status_sub != 0 )
        {
			return view('member.profile.biodata', compact('sms_setting'));
        }
        else
        {
            abort(404);
        }
    }	
    
    public function pin()
	{
		return view('member.profile.pin');
    }
    
    public function getPinSend()
    {
        $userCek  = User::where('id',Auth::user()->id)->first();
        
        $text = 'Pin anda adalah '.$userCek->pin.', simpan dan gunakan untuk transaksi';
        SMSGateway::send($userCek->phone, $text);
        
        return redirect()->route('get.profile.pin')->with('alert-success', 'Informasi PIN Anda berhasil dikirim ke no anda. Silahkan tunggu max 5 menit');
    }

    public function getPinGenerate()
    {
        $userCek  = User::where('id', Auth::user()->id)->firstOrFail();
        $generatePin = Pin::GeneratePin($userCek->id);
    		
        $text = 'Pin anda dirubah '.$generatePin.', simpan dan gunakan untuk transaksi';
        
        SMSGateway::send($userCek->phone, $text);
        
        return redirect()->route('get.profile.pin')->with('alert-success', 'PIN baru berhasil dikirim ke no anda. Silahkan tunggu max 5 menit');
    }
    
    public function ubahPin(Request $request)
    {
        foreach($request->formdata as $item){
            $formdata_proc[$item['name']]  = $item['value'];
        }
        
        $pin      = addslashes(trim($formdata_proc['newpin']));
        $password = addslashes(trim($formdata_proc['password']));
        
        if( is_numeric($pin) && strlen($pin) == 4 )
        {
            if(Hash::check($password, Auth::user()->password))
            {
                DB::table('users')
        			->where('id', Auth::user()->id)
        			->update(['pin'=>$pin]);
        		
        		return 1;
            }
            
            return 0;
        }
        
        return 2;
    }
    
	public function storeBiodata(Request $request)
	{
	    $this->validate($request, [
			'name' => 'required',
			'email' => 'required|unique:users,email,'.Auth::user()->id,
			'city' => 'required',
			'buyer' => 'max:140'
		],[
			'name.required' => 'Nama tidak boleh kosong',
			'email.required' => 'Email tidak boleh kosong',
			'email.unique' => 'Email telah digunakan akun lain',
			'city.required' => 'Kota tidak boleh kosong',
			'buyer.max' => 'Maksimal karakter adalah 140',
		]);
		$profile = Auth::user();
		$profile->email = $request->email;
		$profile->name = $request->name;
		$profile->city = $request->city;
		if (!empty($request->buyer)) {
			$profile->sms_buyer = $request->buyer;
		}else{
			$profile->sms_buyer = null;
		}
		$profile->save();
		return redirect()->back()->with('alert-success', 'Berhasil Merubah Data Profile');
	}

	public function password()
	{
		return view('member.profile.ubah-password');
	}

	public function updatePassword(Request $request)
	{
	    $user = Auth::user();

        $this->validate($request, [
            'password' => 'required|passcheck:' . $user->password,
            'new_password' => 'required|confirmed|min:6',
        ], [
            'password.required' => 'Kata Sandi tidak boleh kosong',
            'password.passcheck' => 'Kata Sandi tidak cocok',
            'new_password.required' => 'Kata Sandi Baru tidak boleh kosong',
            'new_password.confirmed' => 'Konfirmasi Kata Sandi tidak cocok',
            'new_password.min' => 'Kata Sandi minimal 6 digit',
        ]);

        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return redirect()->back()->with('alert-success', 'Kata Sandi Berhasil Diubah');
	}

	public function picture()
	{
		return view('member.profile.ubah-foto');
	}

	public function updatePicture(Request $request)
	{
	    $users = Auth::user();
		if ($users->image != null) {
			$target = 'admin-lte/dist/img/avatar/'.$users->image;
	        if (file_exists($target)) {
	            unlink($target);
	        }
		}
		
		$data = $request->image;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);

        $data = base64_decode($data);
        $imageName = time().'.jpg';
        file_put_contents('admin-lte/dist/img/avatar/'.$imageName, $data);

        $users->image = $imageName;
        $users->save();
        return Response::json($users);
	}

	public function testimonial()
	{
		return view('member.profile.kirim-testimonial');
	}
	
	public function rekening()
	{
	    $cek = DB::table('users_bank')
			->select('users_bank.nama_pemilik_bank','users_bank.no_rekening','bank_swifs.name','bank_swifs.code')
			->leftjoin('bank_swifs','users_bank.id_bank','bank_swifs.id')
			->where('users_bank.user_id',Auth::user()->id)
			->first();
		$sesi = $cek ? 'VIEW' : 'CREATE';
		return view('member.profile.rekening',compact('sesi','cek'));
	}

	public function insertRekening(Request $request)
	{
	    $this->validate($request, [
              'nama_pemilik_bank' => 'required',
              'jenis_rek'         => 'required',
              'rek'               => 'required',
		],[
           'nama_pemilik_bank.required' => 'Nama Pemilik Bank tidak boleh kosong.',
           'jenis_rek.required'         => 'Jenis Bank tidak boleh kosong.',
           'rek.required'               => 'No Rekening tidak boleh kosong.'
		]);
		
		DB::table('users_bank')
        ->insert([
          'user_id'          => Auth::user()->id,
          'id_bank'        => $request->jenis_rek,
          'nama_pemilik_bank'=> strtoupper(addslashes(trim($request->nama_pemilik_bank))),
          'no_rekening'      => addslashes(trim($request->rek)),
        ]);
    
		return redirect()->route('index.rekening-bank')->with('alert-success', 'Menambah Alamat Bank success.');
	}

	public function sendTestimonial(Request $request)
	{
	    $this->validate($request, [
		    'rate' => 'required',
			'review' => 'required',
		],[
			'review.required' => 'Review/Isi Testimonial tidak boleh kosong.',
			'rate.required' => 'Rate/Penilaian tidak boleh kosong.'
		]);
		$testimonials = new Testimonial();
		$testimonials->user_id = Auth::user()->id;
		$testimonials->review = $request->review;
		$testimonials->rate = $request->rate;
		$testimonials->save();
		return redirect()->back()->with('alert-success', 'Terimakasih telah mengirimkan testimonial anda.');
	}

	public function pusatInformasi()
	{
	    $info = Informasi::orderBy('created_at', 'DESC')->paginate(20);
		return view('member.profile.pusat-informasi', compact('info'));
	}

	public function rekeningPayPal()
	{
	    $user = User::findOrFail(Auth::user()->id);
	    $validation = Users_validation::where('user_id', $user->id)->first();
	    
	    if( !$validation ) {
	        return redirect()->back()->with('alert-error', "Silahkan lakukan validasi akun terlebih dahulu");
	    }
	    elseif( $validation->status != '1' ) {
	        return redirect()->back()->with('alert-error', "Proses validasi Anda belum disetujui");
	    }
	    
		return view('member.profile.rekening-paypal', compact('user'));
	}

	public function insertRekeningPayPal(Request $request)
	{
        if($request->is('member/*'))
        {
    	    $this->validate($request, [
                  'email' => 'required|email',
                  'verification_code' => 'required|numeric',
    		],[
               'email.required' => 'Email PayPal tidak boleh kosong.',
               'verification_code.required' => 'Kode verifikasi tidak boleh kosong.',
    		]);
        }
        elseif($request->is('api/*'))
        {
    	    $validator = Validator::make($request->all(), [
                      'email' => 'required|email',
                      'verification_code' => 'required|numeric',
        		],[
                   'email.required' => 'Email PayPal tidak boleh kosong.',
                    'verification_code.required' => 'Kode verifikasi tidak boleh kosong.',
        		]);
        		
            if($validator->fails()){
              $message = $validator->errors()->first();
              return redirect()->back()->with('alert-error',$message);
            }
        }
        
		DB::beginTransaction();
		
		try
		{
		    if( $request->verification_code != session('pp_vc', '') ) {
		        throw new \Exception("Kode verifikasi tidak cocok!");
		    }
		    
		    $user = User::findOrFail(Auth::user()->id);
		    $email = $request->email;
		    
		    $check = (int) User::where('paypal_email', $email)->count();
	        $check2 = (int) PayPalModel::where('payer_email', $email)->where('user_id', '!=', $user->id)->limit(1)->count();
	        
	        if( $user->paypal_email == $email ) {
	            throw new Exception("Email PayPal ini sudah terhubung dengan akun Anda");
	        }
	        elseif( $check > 0 ) {
	            throw new Exception("Maaf, email PayPal telah dihubungkan ke akun lain");
	        }
	        elseif( $check2 > 0 ) {
	            throw new Exception("Maaf, email PayPal sudah pernah digunakan untuk bertransaksi oleh pengguna lain");
	        }
		    
		    $user->paypal_email = $email;
		    $user->save();
		    
		    DB::commit();
		    
            return redirect()->back()->with('alert-success', "Rekening PayPal berhasil ditambahkan");
	    }
	    catch(\Exception $e)
	    {
    	    DB::rollBack();
    	    
    	    if( $e instanceof \Illuminate\Database\QueryException ) {
    	        \Log::error($e);
    	        return redirect()->back()->with('alert-error', "Kesalahan internal");
    	    }
    	    
            return redirect()->back()->with('alert-error', $e->getMessage());
        }
	}
	
	public function sendPayPalEmailVerificationCode(Request $request)
	{
		$setting = Setting::first();
	    $v = Validator::make($request->all(), [
	        'email' => 'required|email'
	        ]);
	        
	    if( $v->fails() ) {
	        return response()->json([
	            'success'   => false,
	            'message'   => 'Masukkan alamat email yang valid!'
	            ]);
	    }
	    
	    $requestCount = (int) session('pp_vc_count', 0);
	    $requestLastTime = (int) session('pp_vc_last', (time()-200));
	    $requestId = 'ID'.mt_rand(1111, 9999);
	    $code = mt_rand(111111, 999999);
	    
	    if( ($requestCount >= 3) && ($requestLastTime+900) > time() ) {
	        return response()->json([
	            'success'   => false,
	            'message'   => 'Anda telah mencapai limit request kode. Silahkan ulangi 30 menit kedepan!'
	            ]);
	    }
	    
	    if( ($requestLastTime+180) > time() ) {
	        return response()->json([
	            'success'   => false,
	            'message'   => 'Silahkan tunggu 3 menit sebelum request ulang kode verifikasi!'
	            ]);
	    }
	    
	    try
	    {
	        $user = Auth::user();
	        $email = $request->email;
	        
	        $check = (int) User::where('paypal_email', $email)->count();
	        $check2 = (int) PayPalModel::where('payer_email', $email)->where('user_id', '!=', $user->id)->limit(1)->count();
	        
	        if( $user->paypal_email == $email ) {
	            throw new Exception("Email PayPal ini sudah terhubung dengan akun Anda");
	        }
	        elseif( $check > 0 ) {
	            throw new Exception("Maaf, email PayPal telah dihubungkan ke akun lain");
	        }
	        elseif( $check2 > 0 ) {
	            throw new Exception("Maaf, email PayPal sudah pernah digunakan untuk bertransaksi oleh pengguna lain");
	        }
	        
	        $body = 'Yth. Pelanggan,<br/>';
	        $body .= 'Ini adalah email konfirmasi perihal aktifitas penambahan rekening PayPal Anda dengan email <b>'.$email.'</b> ke akun '.$setting->nama_sistem.' dengan email <b>'.$user->email.'</b>. Jika Anda mengenali aktifitas ini, masukkan kode konfirmasi dibawah ini pada kolom yang tersedia untuk mengonfirmasi penambahan. <span style="color:red">Kode ini bersifat <b>RAHASIA</b></span><br/><br/>';
	        $body .= '<b><span style="font-size:21px">'.$code.'</span></b><br/><br/>';
	        $body .= 'Apabila Anda tidak mengenali aktifitas ini, segera hubungi layanan pelanggan '.$setting->nama_sistem.' dengan cara membalas email ini. Harap waspada dengan segala bentuk upaya penipuan dari pihak manapun yang mencoba untuk meminta kode konfirmasi ini.<br/>';
	        $body .= '<hr/><br/>Request ID: '.$requestId;
	        
	        Mail::send([], [], function($mail) use ($email, $body) {
	            $mail->to($email)
	                ->subject('Verifikasi Penambahan Rekening PayPal')
	                ->setBody($body, 'text/html');
	        });
	        
	        session([
	            'pp_vc' => $code,
	            'pp_vc_count' => ($requestCount+1),
	            'pp_vc_last' => time()
	        ]);
	        
	        return response()->json([
	            'success'   => true,
	            'message'   => 'Berhasil',
	            'request_id' => $requestId,
	            'email' => $email
	            ]);
	    }
	    catch(\Exception $e)
	    {
	        $m = $e->getMessage();
	        
	        if( $e instanceof \Swift_TransportException ) {
    	        $m = 'Kesalahan internal. Tidak dapat mengirim kode verifikasi ke email tujuan!';
	        }
	        
	        return response()->json([
    	            'success'   => false,
    	            'message'   => $m
    	            ]);
	    }
	}
}