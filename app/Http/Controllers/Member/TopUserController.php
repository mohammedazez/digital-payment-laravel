<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\AppModel\Transaksi;

class TopUserController extends Controller
{
    public function index(Request $request)
    {
        $trxs = Transaksi::selectRaw('user_id, COUNT(id) AS total')
            ->where('status', 1)
            ->groupBy('user_id')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();
            
        $users = [];
        
        foreach( $trxs as $trx )
        {
            $u = User::selectRaw('id, name')->find($trx->user_id);
            $u->total_trx = $trx->total;
            
            $users[] = $u;
        }
        
        return view('member.top-users', compact('users'));
    }
}