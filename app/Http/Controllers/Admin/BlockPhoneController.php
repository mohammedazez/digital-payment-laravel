<?php

namespace App\Http\Controllers\Admin;

use Mail, Response, Input, Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use DB;
use App\AppModel\BlockPhone;

class BlockPhoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blockPhoneWeb = BlockPhone::getDataPhone();
        $blockPhoneMobile = BlockPhone::getDataPhoneMobile();
        return view('admin.blokir-telephone.index', compact('blockPhoneWeb','blockPhoneMobile'));
    }


    public function store(Request $request)
    {
        if (strpos($request->phone, ',')  === false){
            $formatDeletText = preg_replace('/[^0-9\,]/', '', $request->phone);
            $formatKomaGanda = str_replace(',,', ',', $formatDeletText);
            $formatPhone     = trim(preg_replace('/\s+/', '', $formatKomaGanda));
            $arr_phone       = array($formatPhone);
        }else{
            $formatDeletText = preg_replace('/[^0-9\,]/', '', $request->phone);
            $formatKomaGanda = str_replace(',,', ',', $formatDeletText);
            $formatPhone     = trim(preg_replace('/\s+/', '', $formatKomaGanda));
            $arr_phone       = explode (",",$formatPhone);
        }
            for($i=0; $i < count($arr_phone); $i++)
            {
                $cekPhone = BlockPhone::getDataPhoneWhere($arr_phone[$i]);
                if( !$cekPhone )
                {
            	    DB::table('blokir_telephone')
            	    ->insert([
                       'phone'      => trim($arr_phone[$i]),
                       'created_at' => date('Y-m-d H:i:s'),
                       'updated_at' => date('Y-m-d H:i:s'),
        	    	]);
                }else{
                    DB::table('blokir_telephone')
                      ->where('phone', $arr_phone[$i])
                      ->update([
                           'phone'      => $arr_phone[$i],
                        //   'created_at' => date('Y-m-d H:i:s'),
                           'updated_at' => date('Y-m-d H:i:s'),
                            ]);
                }
            }
            
            return redirect()->route('admin.blokir.telephone.index')->with('alert-success', 'Berhasil Menambah Data Blokir');
    } 
    
    public function update(Request $request)
    {
        $formatDeletText = preg_replace('/[^0-9]/', '', $request->phone);
        $formatPhone     = trim(preg_replace('/\s+/', '', $formatDeletText));
        $cekPhone = BlockPhone::getDataPhoneWhereNotIn($request->id, $formatPhone);
        
        if( count($cekPhone) == 0 )
        {
        	 DB::table('blokir_telephone')
              ->where('id', $request->id)
              ->update([
                   'phone'      => $formatPhone,
                //   'created_at' => date('Y-m-d H:i:s'),
                   'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                    
            return redirect()->route('admin.blokir.telephone.index')->with('alert-success', 'Berhasil Mengupdate Data Blokir');
        }else{
            return redirect()->route('admin.blokir.telephone.index')->with('alert-error', 'Data Telephone sudah berada di daftar Blokir');
        }
    }

    public function destroy($id)
    {
    	DB::table('blokir_telephone')
    	->where('id', $id)
    	->delete();
    	
        return redirect()->route('admin.blokir.telephone.index')->with('alert-success', 'Berhasil Menghapus Data Blokir');
    }
    
}