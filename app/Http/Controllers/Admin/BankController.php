<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\Bank;
uSe App\AppModel\Bank_kategori;
use App\AppModel\Provider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Storage;
use File;
class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$banks = Bank::paginate(5);
        $provider = Provider::with('bank')->get();
        return view('admin.pengaturan.bank.index', compact('provider'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provider = Provider::where('id',6)->get();
        $bank_kategori = Bank_kategori::where('status',1)->get();
        return view('admin.pengaturan.bank.create',compact('provider','bank_kategori'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'nama_bank' => 'nullable',
            'atas_nama' => 'nullable',
            'no_rek' => 'nullable',
            // 'bank_id' => 'nullable',
            'image' => 'required|image',
            'provider'=>'required',
            'bank_kategori_id'=>'required',
            'code_bank_integrasi'=>'required',
            //'status' => 'required'
        ],[
            // 'nama_bank.required' => 'Nama Bank tidak boleh kosong',
            // 'atas_nama.required' => 'Nama Pemilik tidak boleh kosong',
            // 'no_rek.required' => 'Nomor Rekening tidak boleh kosong',
            // 'bank_id.required' => 'Bank ID tidak boleh kosong',
            'image.required' => 'Logo / Gambar Bank tidka boleh kosong',
            'image.image' => 'Logo / Gambar Bank harus berformat gambar',
            'provider.required'=>'Harap Pilih Provider',
            'bank_kategori_id'=>'Harap Pilih kategori bank',
            'code_bank_integrasi'=>'Harap isi Kode bank untuk integrasi',
            //'status.required' => 'Status belum ditentukan'
        ]);
        $banks = new Bank();
        $banks->nama_bank = $request->nama_bank;
        $banks->atas_nama = $request->atas_nama;
        $banks->no_rek = $request->no_rek;
        // $banks->bank_id = $request->bank_id;
        $banks->provider_id = $request->provider;
        $banks->bank_kategori_id = $request->bank_kategori_id;
        $banks->code = $request->code_bank_integrasi;
        //$banks->status = @intval($request->status);

        $file       = $request->file('image');
        $fileName   = 'bank-'.str_slug($request->nama_bank, '-').'.png';
        $file->move("img/banks", $fileName);
        $banks->image = $fileName;

        $banks->save();
        return redirect()->route('bank.index')->with('alert-success', 'Behasil Menambah Data Bank Baru');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banks = Bank::findOrFail($id);
        $provider = Provider::where('id',6)->get();
        $bank_kategori = Bank_kategori::where('status',1)->get();
        return view('admin.pengaturan.bank.edit', compact('banks','provider','bank_kategori'));
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
        
        $this->validate($request,[
            // 'nama_bank' => 'required',
            // 'atas_nama' => 'required',
            // 'no_rek' => 'required',
            // 'bank_id' => 'required',
            'provider'=>'required',
            //'image' => 'required|image',
            //'status' => 'required'
             'bank_kategori_id'=>'required',
            'code'=>'required',
        ],[
            // 'nama_bank.required' => 'Nama Bank tidak boleh kosong',
            // 'atas_nama.required' => 'Nama Pemilik tidak boleh kosong',
            // 'no_rek.required' => 'Nomor Rekening tidak boleh kosong',
            // 'bank_id.required' => 'Bank ID tidak boleh kosong',
            //'image.required' => 'Logo / Gambar Bank tidka boleh kosong', 
            'image.image' => 'Logo / Gambar Bank harus berformat gambar',
            'provider.required'=>'Harap Pilih Provider',
            'bank_kategori_id'=>'Harap Pilih kategori bank',
            'code'=>'Harap isi Kode bank untuk integrasi',
            //'status.required' => 'Status belum ditentukan'
        ]); 

        $banks = Bank::findOrFail($id);
        $banks->nama_bank = $request->nama_bank;
        $banks->atas_nama = $request->atas_nama;
        $banks->no_rek = $request->no_rek;
        // $banks->bank_id = $request->bank_id;
        $banks->provider_id = $request->provider;
        $banks->bank_kategori_id = $request->bank_kategori_id;
        $banks->code = $request->code;
        //$banks->status = @intval($request->status);
        $provider = Provider::find($banks->provider_id);
        if($request->file('logo')){
            $logo = $request->file('logo');
            $target = 'img/provider/'.$provider->logo;
            if(file_exists($target)){
                File::delete('img/provider/'.$provider->logo);
            }
            $image = Str::random(20).'.'.$logo->getClientOriginalExtension();
            $logo->move('img/provider',$image);

            $provider->logo = $image;
            $provider->save();
        }

        if( $request->hasFile('image') )
        {
            $file = $request->file('image');
            $target = 'img/banks/'.$banks->image;
            if( file_exists($target) && is_file($target) ){
                unlink($target);
            }

            $fileName   = 'bank-'.str_slug($request->nama_bank, '-').'.png';
            $file->move("img/banks/", $fileName);
            $banks->image = $fileName;
        }
        $banks->save();
        return redirect()->route('bank.index')->with('alert-success', 'Behasil Mengubah Data Bank');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banks = Bank::findOrFail($id);
        $target = 'img/banks/'.$banks->image;
        if (file_exists($target) && is_file($target)) {
            unlink($target);
        }
        $banks->delete();
        return redirect()->route('bank.index')->with('alert-success', 'Behasil Menghapus Data Bank');
    }

    public function edit_data(Request $request){
        $provider = Provider::where('id',$request->id_provider)->first();
        $bank = Bank::where('provider_id',$provider->id)->get();
        if($request->api_key == ""){
            $api_key = null;
        }else{
            $api_key = $request->api_key;
        }
        if($request->private_key == ""){
            $private_key = null;
        }else{
            $private_key = $request->private_key;
        }
        if($request->merchant_code==""){
            $merchant_code = null;
        }else{
            $merchant_code = $request->merchant_code;
        }
        if($request->public_key == ""){
            $public_key = null;
        }else{
            $public_key = $request->public_key;
        }
        if($request->ipn_secret == ""){
            $ipn_secret = null;
        }else{
            $ipn_secret = $request->ipn_secret;
        }
        if($request->api_signature == ""){
            $api_signature = null;
        }else{
            $api_signature= $request->api_signature;
        }
        if($api_key==null && $api_signature == null && $private_key == null && $public_key == null 
        && $ipn_secret == null && $merchant_code == null){
            foreach($bank as $item){
                $item->update([
                    'status'=>'0'
                ]);
            }
            $kategori_id = $bank[0]->bank_kategori_id;
            $bank_kategori = Bank_kategori::where('id',$kategori_id)->first();
            $bank_kategori->status = 0;
            $bank_kategori->save();
        }
        
      
        $provider->update([
            'api_key'=>$api_key,
            'api_signature'=>$api_signature,
            'private_key'=>$private_key,
            'public_key'=>$public_key,
            'ipn_secret'=>$ipn_secret,
            'merchant_code'=>$merchant_code,
        ]);
        return redirect()->route('bank.index')->with('alert-success', 'Behasil Mengubah Data Bank');
    }

    public function edit_data_bank(Request $request){
        $bank = Bank::find($request->id);
        $bank->atas_nama = $request->atas_nama;
        $bank->no_rek = $request->no_rek;
        $bank->save();
        return redirect()->route('bank.index')->with('alert-success','Berhasil Mengubah Data Bank');
    }

    public function edit_akun_paypal(Request $request){
        $paypal = Bank::find($request->id);
        $paypal->atas_nama = $request->atas_nama;
        $paypal->no_rek = $request->email;
        $paypal->code = $request->code;
        $paypal->save();
        return redirect()->route('bank.index')->with('alert-success','Berhasil Mengubah Data Bank');

    }

    function status(Request $request){
        $bank = Bank::find($request->id);
        $bank->status = $request->status;
        $bank->save();
        $bank_kategori = Bank_kategori::where('id',$bank->bank_kategori_id)->first();
        if($request->status == 0){
            if( Bank::where('bank_kategori_id', $bank->bank_kategori_id)->where('status', 1)->count() == 0 ) {
                $bank_kategori->status =0;
                $bank_kategori->save();
            }
        }
        if($request->status == 1){
              if($bank_kategori->status== 0){
                    $bank_kategori->status = 1;
                    $bank_kategori->save();
                }
        }
      
        return response()->json($bank,201);
    }
    function akunpaypal(Request $request){
        $this->validate($request,[
            'atas_nama'=>'required',
            'email'=>'required',
            'code'=>'required',
        ],[
            'atas_nama.required'=>'Harap Isi Nama Pemilik Account Paypal',
            'email.required'=>'Harap isi Email Paypal',
            'code.required'=>'Harap isi code untuk akun paypal',
        ]);

        $bank_paypal = Provider::where('name','Paypal')->first();
        Bank::create([
            'nama_bank'=>'Paypal',
            'atas_nama'=>$request->atas_nama,
            'no_rek'=>$request->email,
            'code'=>$request->code,
            'bank_kategori_id'=>11,
            'image'=>$bank_paypal->logo,
            'type'=>'paypal',
            'provider_id'=>5,
            'status'=>1
        ]);
        return redirect()->route('bank.index')->with('alert-success', 'Behasil Menambah Akun Paypal Baru');
    }
    
}