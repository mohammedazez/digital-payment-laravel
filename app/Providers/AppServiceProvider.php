<?php

namespace App\Providers;

use Pulsa, DB, Auth;
use App\AppModel\Pembayarankategori;
use App\AppModel\Pembeliankategori;
use App\AppModel\Setting;
use App\AppModel\Message;
use App\AppModel\Tagihan;
use App\AppModel\Logo;
use App\AppModel\Users_validation;
use App\AppModel\Pengumuman;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {   
        date_default_timezone_set('Asia/Jakarta');
        
        define("ENCRYPTION_KEY", "fn#haPysI5%GhZB&9YwymqI");
        
        View::composer(['layouts.member', 'layouts.admin'], function($view)
        {
            $view->with('ctmsg', Message::select('id')->where('to',Auth::user()->id)->where('status',0)->count());
        });
        
        View::composer(['layouts.member'], function($view)
        {
          $data = Message::select('messages.*','users.name','users.email','users.phone','users.image')->leftjoin('users','messages.from','users.id')->orderBy('messages.updated_at', 'DESC')->where('type','direct')->where('messages.from',Auth::user()->id)->take(5)->get();
            
          $results=[];
          foreach ($data as $d ) {
              
              $sql = Message::where('type','reply')->where('induk_message', $d->id)->where('messages.status',0)->count();
              
                $results[] = [
                    'id'           => $d->id,
                    'from'         => $d->from,
                    'to'           => $d->to,
                    'type'         => $d->type,
                    'id_rely'      => $d->id_rely,
                    'induk_message'=> $d->induk_message,
                    'subject'      => $d->subject,
                    'message'      => $d->message,
                    'status'       => $d->status,
                    'name'         => $d->name,
                    'image'        => $d->image,
                    'created_at'   => $d->created_at,
                    'updated_at'   => $d->updated_at,
                    'reply_count'  => $sql,
                ];
            }
            
            $view->with('detailMessage', $results);
        });
        
             
        View::composer(['layouts.member','member.home'], function($view)
        {
            $view->with('countTagihan', Tagihan::select('id')->where('user_id',Auth::user()->id)->where('status',0)->where('expired',1)->count());
        });
        
        View::composer(['layouts.member','member.home'], function($view)
        {
          $data = Tagihan::select('tagihans.*','users.name','users.image')->where('user_id',Auth::user()->id)->leftjoin('users','tagihans.user_id','users.id')->orderBy('tagihans.created_at', 'DESC')->where('tagihans.status','0')->where('tagihans.expired','1')->get();
          
          $results=[];
          foreach ($data as $d ) {
              
              $sql = Message::select('*')->where('type','reply')->where('induk_message', $d->id)->where('messages.status',0)->count();
              
                $results[] = [
                    'id'            => $d->id,
                    'tagihan_id'    => $d->tagihan_id,
                    'product_name'  => $d->product_name,
                    'phone'         => $d->phone,
                    'no_pelanggan'  => $d->no_pelanggan,
                    'nama'          => $d->nama,
                    'periode'       => $d->periode,
                    'status'        => $d->status,
                    'expired'       => $d->expired,
                    'jumlah_tagihan'=> $d->jumlah_tagihan,
                    'admin'         => $d->admin,
                    'jumlah_bayar'  => $d->jumlah_bayar,
                    'via'           => $d->via,
                    'name'          => $d->name,
                    'image'         => $d->image,
                    'created_at'    => $d->created_at,
                    'updated_at'    => $d->updated_at,
                    // 'reply_count'  => $sql,
                ];
            }
            
          $view->with('tagihanNonBuy', $data);
        });
        
        View::composer(['layouts.admin'], function($view)
        {
          $data = Message::select('messages.*','users.name','users.email','users.phone','users.image')->leftjoin('users','messages.from','users.id')->orderBy('messages.updated_at', 'DESC')->where('type','direct')->where('messages.to',Auth::user()->id)->where('messages.status',0)->take(5)->get();
            
          $results=[];
          foreach ($data as $d ) {
              
              $sql = Message::select('*')->where('type','reply')
              ->whereNotIn('from', [Auth::user()->id])->where('induk_message', $d->id)->where('messages.status',0)->count();
              
                $results[] = [
                    'id'           => $d->id,
                    'from'         => $d->from,
                    'to'           => $d->to,
                    'type'         => $d->type,
                    'id_rely'      => $d->id_rely,
                    'induk_message'=> $d->induk_message,
                    'subject'      => $d->subject,
                    'message'      => $d->message,
                    'status'       => $d->status,
                    'name'         => $d->name,
                    'image'        => $d->image,
                    'created_at'   => $d->created_at,
                    'updated_at'   => $d->updated_at,
                    'reply_count'  => $sql,
                ];
            }
            
            $view->with('detailMessage', $results);
        });
        
        View::composer('layout.member', function($view)
        {
            $view->with('notifValidation', Users_validation::getUseralidation(Auth::user()->id));
        });
        
        View::composer('member.profile.index', function($view)
        {
            $view->with('notifValidation', Users_validation::getUseralidation(Auth::user()->id));
        });
        
        View::composer(['layouts.member', 'member.profile.index'], function($view)
        {
            $view->with('notifValidation', Users_validation::getUseralidation(Auth::user()->id));
        });
        
        $notifMessage = Message::where('status', 0)->count();
        view()->share('notifMessage', $notifMessage);

        $GeneralSettings = Setting::first();
        view()->share('GeneralSettings', $GeneralSettings);
        
        $allLogo = Logo::all();
        view()->share('logoku', $allLogo);

        $KategoriPembelian = Pembeliankategori::where('status', 1)->get();
        view()->share('KategoriPembelian', $KategoriPembelian);

        $KategoriPembayaran = Pembayarankategori::all();
        view()->share('KategoriPembayaran', $KategoriPembayaran);
        
        \Validator::extend('passcheck', function ($attribute, $value, $parameters) { return \Hash::check($value, $parameters[0]); });
        
        $pengumuman = Pengumuman::where('id', '1')->first();
        if( !is_null($pengumuman) ) {
            view()->share('pengumuman', $pengumuman);
        }
        else {
            view()->share('pengumuman', '');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
