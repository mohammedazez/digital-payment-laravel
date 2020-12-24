<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class IndexModel extends Model
{

    public static function getTransaksiOperator()
    {
         $query = DB::table('transaksis')
            ->select('pembelianproduks.product_id','produk','pembelianoperators.product_name','code', DB::raw('count(*) as total_item'))
            ->leftjoin('pembelianproduks', DB::raw('transaksis.code'),DB::raw('pembelianproduks.product_id'))
            ->leftjoin('pembelianoperators', DB::raw('pembelianproduks.pembelianoperator_id'),DB::raw('pembelianoperators.id'))
            ->where('transaksis.status',1)
            ->groupby(['pembelianoperators.product_name'])
            ->orderBy('total_item','desc')
            ->get();

        return $query;
    }
    
    public static function getTransaksiOperatorWhereDate($date_start, $date_end)
    {
         $query = DB::table('transaksis')
            ->select('pembelianproduks.product_id','produk','pembelianoperators.product_name','code', DB::raw('count(*) as total_item'))
            ->leftjoin('pembelianproduks', DB::raw('transaksis.code'),DB::raw('pembelianproduks.product_id'))
            ->leftjoin('pembelianoperators', DB::raw('pembelianproduks.pembelianoperator_id'),DB::raw('pembelianoperators.id'))
            ->where('transaksis.status',1)
            ->where('pembelianoperators.created_at','>=',$date_start)
            ->where('pembelianoperators.updated_at','<=',$date_end)
            ->groupby(['pembelianoperators.product_name'])
            ->orderBy('total_item','desc')
            ->get();

        return $query;
    }


    public static function getTransaksiProduk()
    {
         $query = DB::table('transaksis')
            ->select('pembelianproduks.product_id','produk','pembelianoperators.product_name','code', DB::raw('count(*) as total_item'))
            ->leftjoin('pembelianproduks', DB::raw('transaksis.code'),DB::raw('pembelianproduks.product_id'))
            ->leftjoin('pembelianoperators', DB::raw('pembelianproduks.pembelianoperator_id'),DB::raw('pembelianoperators.id'))
            ->where('transaksis.status',1)
            ->groupby(['code'])
            ->orderBy('total_item','desc')
            ->get();

        return $query;
    }
    
    public static function getTransaksiProdukWhereDate($date_start, $date_end)
    {
         $query = DB::table('transaksis')
            ->select('pembelianproduks.product_id','produk','pembelianoperators.product_name','code', DB::raw('count(*) as total_item'))
            ->leftjoin('pembelianproduks', DB::raw('transaksis.code'),DB::raw('pembelianproduks.product_id'))
            ->leftjoin('pembelianoperators', DB::raw('pembelianproduks.pembelianoperator_id'),DB::raw('pembelianoperators.id'))
            ->where('transaksis.status',1)
            ->where('pembelianproduks.created_at','>=',$date_start)
            ->where('pembelianproduks.updated_at','<=',$date_end)
            ->groupby(['code'])
            ->orderBy('total_item','desc')
            ->get();

        return $query;
    }

    public static function getDataMemberTrx()
    {
         $query = DB::table('transaksis')
            ->select('users.name','pembelianproduks.product_id','produk','pembelianoperators.product_name','code', DB::raw('count(*) as total_item'))
            ->leftjoin('pembelianproduks', DB::raw('transaksis.code'),DB::raw('pembelianproduks.product_id'))
            ->leftjoin('pembelianoperators', DB::raw('pembelianproduks.pembelianoperator_id'),DB::raw('pembelianoperators.id'))
            ->leftjoin('users', DB::raw('transaksis.user_id'),DB::raw('users.id'))
            ->where('transaksis.status',1)
            ->groupby(['user_id'])
            ->orderBy('total_item','desc')
            ->get();

        return $query;
    }

    public static function getDataMemberTrxWhereDate($date_start, $date_end)
    {
         $query = DB::table('transaksis')
            ->select('users.name','pembelianproduks.product_id','produk','pembelianoperators.product_name','code', DB::raw('count(*) as total_item'))
            ->leftjoin('pembelianproduks', DB::raw('transaksis.code'),DB::raw('pembelianproduks.product_id'))
            ->leftjoin('pembelianoperators', DB::raw('pembelianproduks.pembelianoperator_id'),DB::raw('pembelianoperators.id'))
            ->leftjoin('users', DB::raw('transaksis.user_id'),DB::raw('users.id'))
            ->where('transaksis.status',1)
            ->where('transaksis.created_at','>=',$date_start)
            ->where('transaksis.updated_at','<=',$date_end)
            ->groupby(['user_id'])
            ->orderBy('total_item','desc')
            ->get();

        return $query;
    }
}