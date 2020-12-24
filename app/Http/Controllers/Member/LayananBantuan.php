<?php

namespace App\Http\Controllers\Member;

use App\AppModel\Bantuan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Mail;
use App\User;
use App\AppModel\Setting;

class LayananBantuan extends Controller
{
    
    public function index()
    {
        $layananbantuan = Bantuan::all()->toArray();
        $wa = Bantuan::where('title','WA')->first();
        $setting = Setting::first();
        // return $data;
        return view('member.layanan-bantuan.index', compact('layananbantuan','setting','wa'));
    }
}