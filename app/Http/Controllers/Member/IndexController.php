<?php

namespace App\Http\Controllers\Member;

use Auth, Validator, Response, Input;
use App\AppModel\Informasi;
use App\AppModel\Transaksi;
use App\AppModel\Testimonial;
use App\AppModel\Deposit;
use App\AppModel\Pembeliankategori;
use App\AppModel\Pembayarankategori;
use App\AppModel\MenuSubmenu;
use App\AppModel\Banner;
use App\AppModel\MenuDashboard;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppModel\Temptransaksi;
use Pulsa,Log;

class IndexController extends Controller
{
    public $personal_role   = '1';
    public $admin_role      = '2';
    public $agen_role       = '3';
    public $enterprise_role = '4';

    public function index()
    {
        $info = Informasi::orderBy('created_at', 'DESC')->paginate(4);

        $pembeliankategori = Pembeliankategori::where('status', 1)->orderBy('sort_product', 'ASC')->get();
        $pembayarankategori = Pembayarankategori::where('status', 1)->get();
          
        $kategori_merge = array_merge($pembeliankategori->toArray(), $pembayarankategori->toArray());

        $kategori_merge = array_merge($kategori_merge, [
            ['jenis' => 'manual', 'slug' => 'transfer-bank', 'icon' => 'random', 'product_name' => 'TRANSFER KE BANK'],
            ['jenis' => 'other', 'slug' => 'layanan-bantuan', 'icon' => 'envelope', 'product_name' => 'LAYANAN BANTUAN'],
            ['jenis' => 'other', 'slug' => 'faq', 'icon' => 'question-circle', 'product_name' => 'F.A.Q']
        ]);
        
        $menu_dashboard = MenuDashboard::orderBy('sort_menu','ASC')->get();
        $menu_dashboard = $menu_dashboard->toArray();
        
        $getimages = Banner::getImgSliderMember();
        return view('member.home', compact('info', 'pembeliankategori', 'pembayarankategori','getimages','kategori_merge','menu_dashboard'));
    }
    
    public function pricePembelian($title)
    {
        $kategoris = Pembeliankategori::where('slug', $title)->first();
        return view('member.price-pembelian', compact('kategoris'));
    }

    public function pricePembayaran($title)
    {
        $kategoris = Pembayarankategori::where('slug', $title)->first();
        return view('member.price-pembayaran', compact('kategoris'));
    }

    public function triggerOnline(Request $request)
    {
        $user = $request->user();

        if( $user )
        {
            $user->update([
                'online'    => 1,
                'last_online'   => date('Y-m-d H:i:s')
                ]);
                
            return response()->json([
                'success'   => true
                ]);
        }
        
        return response()->json([
                'success'   => false
                ]);
    }
}