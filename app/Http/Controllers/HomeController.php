<?php

namespace App\Http\Controllers;

use Auth, Validator, Mail, DB, Response, Captcha, Cookie;
use App\AppModel\Bank;
use App\AppModel\Tos;
use App\AppModel\Pembeliankategori;
use App\AppModel\Pembayarankategori;
use App\AppModel\Pembelianoperator;
use App\AppModel\Pembelianproduk;
use App\AppModel\V_pembelianproduk_personal as Personal;
use App\AppModel\V_pembelianproduk_agen as Agen;
use App\AppModel\V_pembelianproduk_enterprise as Enterprise;
use App\AppModel\Pembayaranproduk;
use App\AppModel\Testimonial;
use App\AppModel\Faq;
use App\AppModel\Message;
use App\AppModel\Banner;
use App\AppModel\Setting;
use App\AppModel\StaticPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppModel\Pembayaranoperator;
use App\User;
use App\AppModel\Transaksi;
use App\AppModel\Rate;
use App\AppModel\PaypalSetting;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public $personal_role   = 1;
    public $admin_role      = 2;
    public $agen_role       = 3;
    public $enterprise_role = 4;

    public function index(Request $request)
    {
        if( !empty($request->ref) && empty(Cookie::get('ref')) )
        {
            Cookie::queue(Cookie::make('ref', $request->ref, (24*60)));
        }
        
    	$pembeliankategori = Pembeliankategori::where('status', 1)->limit(4)->get();
        $operator          = Pembelianoperator::inRandomOrder()->first();
        $testimonials      = Testimonial::where('status', 1)->orderBy('id', 'DESC')->Paginate(3);
        $faqs              = Faq::Paginate(6);
        
        $kategoriPLN        = Pembeliankategori::select('id')->where('type', 'PLN')->first();
        $produkPLN = [];
        
        if( $kategoriPLN )
        {
            if(Auth::check())
            {
                switch(Auth::user()->roles[0]->id)
                {
                    case 3: // agen
                        $produkPLN = Agen::where('pembeliankategori_id', $kategoriPLN->id)->get();
                        break;
                        
                    case 4: // enterprise
                        $produkPLN = Enterprise::where('pembeliankategori_id', $kategoriPLN->id)->get();
                        break;
                        
                    default:
                        $produkPLN = Personal::where('pembeliankategori_id', $kategoriPLN->id)->get();
                        break;
                }
            }
            else
            {
                $produkPLN = Enterprise::where('pembeliankategori_id', $kategoriPLN->id)->get();
            }
        }
        
        $tagihan_providers = Pembayarankategori::where('status', 1)->orderBy('product_name','ASC')->get();
        $captcha = Captcha::chars('0123456789')->length(4)->size(130, 50)->generate();
        $rate = Rate::all();
        $rateLast = Rate::orderBy('id', 'desc')->first();
        $ppsetting = [];
        
        foreach( PaypalSetting::get() as $pp )
        {
            $ppsetting[$pp->name] = $pp->value;
        }
        
        return view('home', compact('pembeliankategori','operator', 'testimonials', 'faqs','produkPLN','tagihan_providers', 'captcha','rate','rateLast','ppsetting'));
    }
    
    public function produkLevel($id)
    {
        $total_markup = upline_markup();
        if($id == 10)
        {
            if(Auth::check() == false)
            {
                $produk = Pembelianproduk::where('pembeliankategori_id', $id)->orderBy('price_default', 'ASC')->get();
            }
            elseif(Auth::user()->roles()->first()->id == $this->personal_role || Auth::user()->roles()->first()->id == $this->admin_role)
            {
                $produk = Personal::select('id','product_id','product_name','desc',DB::raw('price + '.$total_markup.' as price'),'status')->where('pembeliankategori_id', $id)->orderBy('price_default', 'ASC')->get();
            }
            elseif(Auth::user()->roles()->first()->id == $this->agen_role)
            {
                $produk = Agen::select('id','product_id','product_name','desc',DB::raw('price + '.$total_markup.' as price'),'status')->where('pembeliankategori_id', $id)->orderBy('price_default', 'ASC')->get();
            }
            elseif(Auth::user()->roles()->first()->id == $this->enterprise_role)
            {
                $produk = Enterprise::select('id', 'product_id', 'product_name', 'desc', DB::raw('price + '.$total_markup.' as price'), 'status')->where('pembeliankategori_id', $id)->orderBy('price_default', 'ASC')->get();
            }
            else
            {
                $produk = Pembelianproduk::select('id','product_id','product_name','desc','price_default','price_markup',DB::raw('price + '.$total_markup.' as price'),'status')->where('pembeliankategori_id', $id)->orderBy('price_default', 'ASC')->get();
            }
        }
        else
        {
            if(Auth::check() == false)
            {
                $produk = Pembelianproduk::where('pembelianoperator_id', $id)->orderBy('price_default', 'ASC')->get();
            }
            elseif(Auth::user()->roles()->first()->id == $this->personal_role || Auth::user()->roles()->first()->id == $this->admin_role)
            {
                $produk = Personal::select('id','product_id','product_name','desc',DB::raw('price + '.$total_markup.' as price'), 'status')->where('pembelianoperator_id', $id)->orderBy('price_default', 'ASC')->get();
            }
            elseif(Auth::user()->roles()->first()->id == $this->agen_role)
            {
                $produk = Agen::select('id','product_id','product_name','desc',DB::raw('price + '.$total_markup.' as price'), 'status')->where('pembelianoperator_id', $id)->orderBy('price_default', 'ASC')->get();
            }
            elseif(Auth::user()->roles()->first()->id == $this->enterprise_role)
            {
                $produk = Enterprise::select('id', 'product_id', 'desc', DB::raw('price + '.$total_markup.' as price') , 'status')->where('pembelianoperator_id', $id)->orderBy('price_default', 'ASC')->get();
            }
            else
            {
                $produk = Pembelianproduk::select('id','product_id','product_name','desc','price_default','price_markup',DB::raw('price + '.$total_markup.' as price'),'status')->where('pembelianoperator_id', $id)->orderBy('price_default', 'ASC')->get();
            }
        }
        
        return $produk;
    }
    
    public function findproduct(Request $request)
    {
        $id = $request->pembelianoperator_id;
        $produk = $this->produkLevel($id);
        return Response::json($produk);
    }
      
    public function getoperator(Request $request)
    {
        $pembeliankategori_id = $request->category;
        
        $operator = Pembelianoperator::where('status', 1)->where('pembeliankategori_id', $pembeliankategori_id)->orderBy('product_name','ASC')->get();
        return Response::json($operator);
    }
    
    public function findproductPembayaran(Request $request)
    {
        $pembayaranoperator_id = $request->pembayaranoperator_id;
        
        $produk = Pembayaranproduk::where('status', 1)->where('pembayarankategori_id', $pembayaranoperator_id)->orderBy('product_name','ASC')->get();
        return Response::json($produk);
    }
    
    public function prefixproduct(Request $request)
    {
        $pembeliankategori_id = $request->parent;
        $prefix = $request->prefix;
        
        $prefixBolt = ["998","999"];
        $_s = substr($prefix, 0, 3);
        
        if( in_array($_s, $prefixBolt) )
        {
            $pembelianoperator = Pembelianoperator::where('status', 1)->where('pembeliankategori_id', $pembeliankategori_id)->where('prefix', 'LIKE', '%'.$_s.'%')->get();
            $operator = Pembelianoperator::where('status', 1)->where('pembeliankategori_id', $pembeliankategori_id)->where('prefix', 'LIKE', '%'.$_s.'%')->first();
        }
        else
        {
            $pembelianoperator = Pembelianoperator::where('status', 1)->where('pembeliankategori_id', $pembeliankategori_id)->where('prefix', 'LIKE', '%'.$prefix.'%')->get();
            $operator = Pembelianoperator::where('status', 1)->where('pembeliankategori_id', $pembeliankategori_id)->where('prefix', 'LIKE', '%'.$prefix.'%')->first();
        }
        
        if( !is_null($operator) )
        {
            $pembelianoperator_id = $operator->id;
            $produk = $this->produkLevel($pembelianoperator_id); //Pembelianproduk::where('status', 1)->where('pembelianoperator_id', $pembelianoperator_id)->get();
            return Response::json(array('operator'=>$pembelianoperator, 'produk' => $produk));
        }
        
        return Response::json(array('operator' => [], 'produk' => []));
    }

    public function caraTransaksi()
    {
        return view('cara-transaksi');
    }
    
    public function deposit()
    {
        $banks = Bank::where('status',1)->get();
        return view('deposit', compact('banks'));
    }

    public function pricePembelian($title)
    {
        $kategoris = Pembeliankategori::where('slug', $title)->first();
        return view('price-pembelian', compact('kategoris'));
    }

    public function pricePembayaran($title)
    {
        $kategoris = Pembayarankategori::where('slug', $title)->first();
        return view('price-pembayaran', compact('kategoris'));
    }

    public function testimonial()
    {
        $testimonials = Testimonial::where('status', 1)->orderBy('id', 'DESC')->get();
        return view('testimoni', compact('testimonials'));
    }

    public function faq()
    {
        $faqs = Faq::orderBy('id', 'desc')->limit(10)->get();
        return view('faq', compact('faqs'));
    }

    public function sendMessage(Request $request)
    {
        $v = Validator::make($request->all(),[
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'message' => 'required|string',
            'captcha' => 'required|string',
        ]);
        
        try
        {
            if( $v->fails() ) {
                throw new \Exception($v->errors()->first());
            }
            
            if( !Captcha::validate($request->captcha_id, $request->captcha) ) {
                throw new \Exception('Kode captcha tidak valid!');
            }

            $setting = Setting::first();
            
            $body = '<b>Dari:</b> '.strip_tags($request->name).' / '.$request->email.' / '.strip_tags($request->phone);
            $body .= '<hr/>';
            $body .= strip_tags($request->message);
            $body .= '<br/><hr/>';
            $body .= 'Dikirim Dari Form Kontak '.$setting->nama_sistem;
            
            Mail::send([], [], function($mail) use ($setting, $body) {
                $mail->to($setting->email)
                    ->subject("[".$setting->nama_sistem."] PESAN BARU!")
                    ->setBody($body, "text/html");
            });

            return response()->json([
                'success'   => true,
                'message'   => 'Sukses'
            ]);
        }
        catch(\Exception $e)
        {
            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage()
            ]);
        }
    }
    
    public function staticPage(Request $request, $slug)
    {
        $page = StaticPage::where('slug', $slug)->firstOrFail();
        
        return view('static-page', compact('page'));
    }
}