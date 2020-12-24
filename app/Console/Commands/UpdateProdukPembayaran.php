<?php

namespace App\Console\Commands;

use DB, Exception, Pulsa, DigiFlazz,Log;
use Illuminate\Console\Command;
use App\AppModel\Pembayarankategori;
use App\AppModel\Pembayaranoperator;
use App\AppModel\Pembayaranproduk;
use App\AppModel\Apiserver;
use App\AppModel\Prefix_phone;
use Carbon\Carbon;
class UpdateProdukPembayaran extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'produkpembayaran:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update produk pembayaran';

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
        $now = Carbon::now()->subHours(1)->toDateTimeString();

        $kategori = Pulsa::kategori_pembayaran();
        $kategori = $kategori->data;
        
        foreach($kategori as $item){
            switch($item->name){
                case 'PEMBAYARAN PLN': 
                    $icon = 'lightbulb-o';
                    break;

                case 'PEMBAYARAN BPJS': 
                    $icon = 'heartbeat';
                    break;
                case 'PEMBAYARAN KERETA API':
                    $icon = 'train';
                    break;
                case 'PEMBAYARAN ASURANSI':
                    $icon = 'slideshare';
                    break;
                case 'PEMBAYARAN TV': 
                    $icon = 'television';
                    break;
                case 'PEMBAYARAN PDAM': 
                    $icon = 'tint';
                    break;
                case 'PEMBAYARAN TELEPHONE KABEL': 
                    $icon = 'tty';
                    break; 
                case 'PEMBAYARAN PASCABAYAR': 
                    $icon = 'volume-control-phone'; 
                    break;
                case 'ZAKAT': 
                    $icon = 'asl-interpreting'; 
                    break;
                case 'PEMBAYARAN MULTIFINANCE': 
                    $icon = 'handshake-o';
                    break;
                default: 
                    break;
            }

            $kategori_pembayaran = Pembayarankategori::firstOrNew([
                'id'=>$item->id,
            ]);
            $kategori_pembayaran->id                = $item->id;
            $kategori_pembayaran->apiserver_id      = 2;
            $kategori_pembayaran->product_name      = strtoupper($item->name);
            $kategori_pembayaran->icon              = $icon;
            $kategori_pembayaran->slug              = str_slug($item->name);
            $kategori_pembayaran->type              = strtoupper($item->name);
            $kategori_pembayaran->status            = $item->status;
            $kategori_pembayaran->jenis             = 'pembayaran';
            $kategori_pembayaran->save();
        }

        $operator = Pulsa::operator_pembayaran();
        $operator = $operator->data;

        foreach($operator as $data){
            $operator_pembayaran = Pembayaranoperator::firstOrNew([
                'id'=>$data->id
            ]);
            $operator_pembayaran->id = $data->id;
            $operator_pembayaran->apiserver_id = 2;
            $operator_pembayaran->product_name = $data->product_name;
            $operator_pembayaran->status       = $data->status;
            $operator_pembayaran->pembayarankategori_id = $data->pembayarankategori_id;
            $operator_pembayaran->save();
        }

        $produk = Pulsa::produk_pembayaran();
        $produk = $produk->data;

        foreach($produk as $res){
            $produk_pembayaran = Pembayaranproduk::firstOrNew([
                'id'=>$res->id,
                'code'=>$res->code,
            ]);
            $produk_pembayaran->id = $res->id;
            $produk_pembayaran->apiserver_id = 2;
            $produk_pembayaran->pembayaranoperator_id = $res->pembayaranoperator_id;
            $produk_pembayaran->pembayarankategori_id = $res->pembayarankategori_id;
            $produk_pembayaran->product_name = $res->product_name;
            $produk_pembayaran->code        = $res->code;
            $produk_pembayaran->price_default = 0;
            $produk_pembayaran->markup = !empty($produk_pembayaran->price_markup) ? $produk_pembayaran->price_markup : 0;
            $produk_pembayaran->price_markup       = intval($produk_pembayaran->price_default) + intval($produk_pembayaran->price_markup);
            $produk_pembayaran->status = $res->status;
            $produk_pembayaran->save();
        }
       
    }
}