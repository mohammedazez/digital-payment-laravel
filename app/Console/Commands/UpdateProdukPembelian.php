<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Pulsa, DB,DigiFlazz,Exception ,Log;
use App\AppModel\Pembeliankategori;
use App\AppModel\Pembelianoperator;
use App\AppModel\Pembelianproduk;
use App\AppModel\Apiserver;
use App\AppModel\Prefix_phone;
use Carbon\Carbon;
class UpdateProdukPembelian extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'produkpembelian:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'FOR UPDATE PRODUCT';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        DB::statement("SET session wait_timeout=600");

        $kategori = Pulsa::kategori_pembelian();
        $kategori = $kategori->data;
        
        foreach($kategori as $item){
            switch($item->product_name){
                case 'PULSA ALL OPERATOR': 
                    $icon = 'mobile';
                    break;
                case 'PAKET DATA': 
                    $icon = 'internet-explorer';
                    break;
                case 'VOUCHER GOOGLE PLAY': 
                    $icon = 'google-wallet';
                    break;
                case 'PULSA SMS TELEPHONE': 
                    $icon = 'envelope';
                    break;
                case 'PULSA TRANSFER': 
                    $icon = 'forward';
                    break;
                case 'ITUNES GIFT CARD': 
                    $icon = 'music';
                    break;
                case 'VOUCHER GAME': 
                    $icon = 'gamepad';
                    break;
                case 'PUBG MOBILE UC': 
                    $icon = 'gamepad';
                    break;
                case 'VOUCHER WIFI.ID': 
                    $icon = 'wifi';
                    break;
                case 'E-MONEY': 
                    $icon = 'money';
                    break;
                case 'TOKEN LISTRIK': 
                    $icon = 'bolt';
                    break;
                case 'E-TOLL': 
                    $icon = 'road';
                    break;
                case 'FREE FIRE DIAMOND': 
                    $icon = 'gamepad';
                    break;
                case 'MALAYSIA TOPUP': 
                    $icon = 'mobile';
                    break;
                case 'SINGAPORE TOPUP': 
                    $icon = 'mobile';
                    break;
                default: 
                break;
            }
            $kategori_produk = Pembeliankategori::firstOrNew([
                'id'=>$item->id,
            ]);
            $kategori_produk->id = $item->id;
            $kategori_produk->apiserver_id = 2;
            $kategori_produk->sort_product = 0;
            $kategori_produk->product_name = $item->product_name;
            $kategori_produk->type         = $item->type;
            $kategori_produk->icon         = $icon;
            $kategori_produk->slug         = str_slug($item->product_name);
            $kategori_produk->status       = $item->status;
            $kategori_produk->jenis        = 'pembelian';
            $kategori_produk->save();
        }

        $operator = Pulsa::operator_pembelian();
        $operator = $operator->data;

        foreach($operator as $data){
            $operator_produk = Pembelianoperator::firstOrNew([
                'id'=>$data->id,
            ]);
            $operator_produk->id                    = $data->id;
            $operator_produk->apiserver_id          = 2;
            $operator_produk->product_id            = $data->product_id;
            $operator_produk->product_name          = $data->product_name;
            $operator_produk->prefix                = $data->prefix;
            $operator_produk->status                = $data->status;
            $operator_produk->pembeliankategori_id  = $data->pembeliankategori_id;
            $operator_produk->save();
        }

        $produk = Pulsa::produk_pembelian();
        $produk = $produk->data;

        foreach($produk as $res){
            $produk_pembelian = Pembelianproduk::firstOrNew([
                'id'=>$res->id,
            ]);
            $produk_pembelian->id           = $res->id;
            $produk_pembelian->product_id   = $res->code;
            $produk_pembelian->apiserver_id = 2;
            $produk_pembelian->pembelianoperator_id = $res->pembelianoperator_id;
            $produk_pembelian->pembeliankategori_id = $res->pembeliankategori_id;
            $produk_pembelian->product_name         = $res->product_name;
            $produk_pembelian->desc                 = $res->product_name;
            $produk_pembelian->price_default        = $res->price;
            $produk_pembelian->price_markup         = !empty($produk_pembelian->price_markup) ? $produk_pembelian_markup : 0;
            $produk_pembelian->price                = intval($produk_pembelian->price_default) + ($produk_pembelian->price_markup);
            $produk_pembelian->status               = $res->status;
            $produk_pembelian->save();
        }
    }

    
}