<?php

namespace App\Http\Controllers\Member;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\AppModel\MenuMember;
use DB,Auth;
class MarkupDownlineController extends Controller
{
    public function index(){
        $user_role = Auth::user()->roles()->first()->id;
        if($user_role == 1){
            return redirect('/member');
        }else{
            return view('member.markup-downline');   
        }
    }

    public function update(Request $request){
        $this->validate($request,[
            'markup'=>'required|integer',
        ]);

        $user = User::where('id',auth()->user()->id)->update([
            'referral_markup'=>$request->markup
        ]);

        return redirect()->back()->with('alert-success','Berhasil Mengubah Data Markup downline');
    }
}
