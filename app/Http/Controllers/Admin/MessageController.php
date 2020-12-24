<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\Message;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Auth;

class MessageController extends Controller
{
    
    public function index()
    {
        $messages = Message::select('messages.*','users.name','users.email','users.phone')->leftjoin('users','messages.from','users.id')->orderBy('messages.updated_at', 'DESC')->where('type','direct')->paginate(12);
        return view('admin.messages.index', compact('messages'));
    }


    public function create()
    {
        //
    }
    
    public function store(Request $request)
    {
        $type       = $request->type;
        $id_induk   = $request->id_induk;
        $id_balas   = $request->id_balas;
        $from       = $request->from;
        $to         = $request->to;
        $isipesan   = addslashes(trim($request->isipesan));
        $isisubject = addslashes(trim($request->isisubject));
        
        $simpan = DB::table('messages')
        ->insertGetId([
          'from'         => $from,
          'to'           => $to,
          'type'         => $type,
          'id_reply'     => ($type == 'reply')?''.$id_balas.'':'-',
          'induk_message'=> $id_induk,
          'subject'      => $isisubject,
          'message'      => $isipesan,
          'status'       => '0',
          'created_at'   => date('Y-m-d H:i:s'),
          'updated_at'   => date('Y-m-d H:i:s'),
        ]);
        
        DB::table('messages')
              ->where('id', $simpan)
              ->update(['induk_message' => $simpan]);
              
        return redirect(url('/admin/messages'))->with('alert-success', 'Berhasil Mengirim Pesan');
    }
    
    public function reply(Request $request)
    {
        $type     = $request->type;
        $id_induk = $request->id_induk;
        $id_balas = $request->id_balas;
        $from     = $request->from;
        $to       = $request->to;
        $isipesan = addslashes(trim($request->isipesan));
        
        DB::table('messages')
        ->insert([
          'from'         => $from,
          'to'           => $to,
          'type'         => $type,
          'id_reply'     => ($type == 'reply')?''.$id_balas.'':'-',
          'induk_message'=> $id_induk,
          'subject'      => '-',
          'message'      => $isipesan,
          'status'       => '0',
          'created_at'   => date('Y-m-d H:i:s'),
          'updated_at'   => date('Y-m-d H:i:s'),
        ]);
        
        
        DB::table('messages')
              ->where('id', $id_induk)
              ->update(['status' => 0, 'updated_at' => date('Y-m-d H:i:s')]);
              
        // return redirect()->back()->with('alert-success', 'Berhasil Membalas Pesan Masuk');
        
        return redirect(url('/admin/messages'))->with('alert-success', 'Berhasil Membalas Pesan Masuk');
    }

    public function show($id)
    {
        DB::table('messages')
              ->whereNotIn('id', [$id])
              ->where('to', Auth::user()->id)
              ->where('induk_message', $id)
            //   ->update(['status' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
              ->update(['status' => 1]);
              
        $chckmessage = Message::where('induk_message', $id)->whereNotIn('id', [$id])->where('status', 0)->count();
        
        if($chckmessage == 0){
            DB::table('messages')
              ->where('id', $id)
            //   ->update(['status' => 1, 'updated_at' => date('Y-m-d H:i:s')]);
              ->update(['status' => 1]);
        }
        
        $induk_messages = Message::select('messages.*','users.name','users.email','users.phone','users.image')->leftjoin('users','messages.from','users.id')->orderBy('messages.updated_at', 'ASC')->where('messages.id',$id)->first();
        
        $messages = Message::select('messages.*','users.name','users.email','users.phone','users.image')->leftjoin('users','messages.from','users.id')->orderBy('messages.updated_at', 'ASC')->where('messages.induk_message',$id)->get();
        
        return view('admin.messages.show', compact('induk_messages','messages'));
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }
    
    public function destroy($id)
    {
        $messages = Message::findOrFail($id);
        $messages->delete();
        
        DB::table('messages')
              ->where('induk_message', $id)
              ->delete();
              
        return redirect()->back()->with('alert-success', 'Berhasil Menghapus Pesan Masuk');
    }
}