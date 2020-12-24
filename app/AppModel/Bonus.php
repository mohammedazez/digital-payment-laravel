<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class Bonus extends Model
{
    public static function getKomisi($id)
    {
      $query = DB::table('settings_komisi')
            ->select('*')
            ->where('id',$id)
            ->first();

        return $query;
    }

 	public static function getKomisiTrx($id)
    {
      $komisi_trx_pulsa  = DB::table('mutasis_komisi')
                // ->select('*')
        ->select('mutasis_komisi.id', 'mutasis_komisi.note', 'mutasis_komisi.komisi', 'mutasis_komisi.created_at', 'mutasis_komisi.updated_at', 'users.name')
        ->where('user_id',$id)
        ->where('jenis_komisi',1)
        ->leftjoin('users','mutasis_komisi.user_id','users.id')
        ->get();
        
        return $komisi_trx_pulsa;
    }

 	public static function getKomisiReff($id)
    {
      $komisi_referreal  = DB::table('mutasis_komisi')
        // ->select('*')
        ->select('mutasis_komisi.id', 'mutasis_komisi.note', 'mutasis_komisi.komisi', 'mutasis_komisi.created_at', 'mutasis_komisi.updated_at', 'users.name')
        ->where('user_id',$id)
        ->where('jenis_komisi',2)
        ->leftjoin('users','mutasis_komisi.from_reff_id','users.id')
        ->get();

        return $komisi_referreal;
    }

}