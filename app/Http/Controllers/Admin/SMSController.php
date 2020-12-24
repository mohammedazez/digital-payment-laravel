<?php

namespace App\Http\Controllers\Admin;

use Response;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\AppModel\SMSGateway;
use App\AppModel\SMSGatewaySetting;
use App\AppModel\SMSGatewayOutbox;
use DB;
use Carbon\Carbon;

class SMSController extends Controller
{
    public function outbox()
    {
        $outbox = SMSGatewayOutbox::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.sms-gateway.outbox', compact('outbox'));
    }
    
    public function outboxDatatables(Request $request)
    {
        $columns = array( 
                            0 => 'no', 
                            1 => 'id',
                            2 => 'sent_to',
                            3 => 'message',
                            4 => 'status',
                            5 => 'note',
                            6 => 'updated_at',
                            7 => 'action_hapus',
                        );
  
        $totalData = SMSGatewayOutbox::count();
            
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');


        if(empty($request->input('search.value')))
        {            
            $posts = SMSGatewayOutbox::offset($start)
                         ->limit($limit)
                         ->orderBy('id', 'DESC')
                         ->get();
        } else {
            $search = $request->input('search.value'); 

            if( strtoupper($search) == 'PENDING' )
            {
                $stts = 'pending';
            }
            elseif(strtoupper($search) == 'TERKIRIM')
            {
                $stts = 'sent';
            }
            elseif(strtoupper($search) == 'GAGAL')
            {
                $stts = 'failed';
            };
                  
            $posts =  SMSGatewayOutbox::select('id','sent_to','message','status', 'note', 'updated_at')
                            ->where('sent_to', "{$search}")
                            ->orWhere('status', @$stts)
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy('id', 'DESC')
                            ->get();

            $totalFiltered = SMSGatewayOutbox::select('id','sent_to','message','status', 'note', 'updated_at')
                            ->where('sent_to', "{$search}")
                            ->orWhere('status', @$stts)
                            ->orderBy('id', 'DESC')
                            ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $no = 0;
            foreach ($posts as $post)
            {
                $no++;
                $nestedData['no']           = $start+$no;
                $nestedData['id']           = '#'.$post->id;
                $nestedData['sent_to']      = $post->sent_to;
                $nestedData['message']      = $post->message;
                if($post->status == "pending"){
                    $nestedData['status'] = '<td><span class="label label-warning">PENDING</span></td>';
                }elseif($post->status == "sent"){
                    $nestedData['status'] = '<td><span class="label label-success">TERKIRIM</span></td>';
                }else{
                    $nestedData['status'] = '<td><span class="label label-danger">GAGAL</span></td>';
                }
                $nestedData['note']      = $post->note;
                $nestedData['updated_at']    = Carbon::parse($post->updated_at)->format('d M Y H:i:s');
                $nestedData['action_hapus']  = '<td><form method="POST" action="'.url('/admin/sms-gateway/outbox/hapus', $post->id).'" accept-charset="UTF-8">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="_token" type="hidden" value="'.csrf_token().'">
                            <button class="btn btn-danger btn-sm" onClick=\"return confirm(Anda yakin akan menghapus data ?")\" type="submit" style="padding: 2px 5px;font-size:10px;">Hapus</button>
                            </form></td>';
                $data[] = $nestedData;

            }
        }
          
        $json_data = array(
                    "draw"            => intval($request->input('draw')),  
                    "recordsTotal"    => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data
                    );
            
        return json_encode($json_data);
    }
    
    public function outboxDelete(Request $request, $id)
    {
        $id = @intval($id);
        
        if( $id > 0 )
        {
            $deleted = SMSGatewayOutbox::where('id', $id)->delete();
            
            return redirect()->back()->with('alert-success', 'Berhasil menghapus pesan');
        }
        
        return redirect()->back();
    }
    
    public function setting()
    {
        $getSetting = SMSGatewaySetting::all();
        $setting = [];
        
        foreach($getSetting as $s)
        {
            $n = $s->name;
            $v = $s->value;
            
            $setting[$n] = $v;
        }
            
        return view('admin.sms-gateway.setting', compact('setting'));
    }
    
    public function updateSetting(Request $request)
    {
        $this->validate($request, [
            'enable' => ['required', 'numeric'],
            'zenziva_userkey'   => ['required', 'string'],
            'zenziva_passkey'   => ['required', 'string'],
            'log_db'            => ['required', 'numeric'],
            'enable_sms_buyer'  => ['required', 'numeric'],
            'sms_buyer_cost'    => ['required', 'numeric'],
            ]);
            
        foreach(['enable', 'zenziva_userkey', 'zenziva_passkey', 'log_db', 'enable_sms_buyer', 'sms_buyer_cost'] as $setting)
        {
            if( $request->has($setting) ) {
                SMSGatewaySetting::where('name', $setting)
                                ->update([
                                    'value'     => $request->{$setting}
                                    ]);
            }
        }
        
        return redirect()->back()->with('alert-success', 'Berhasil memperbarui pengaturan SMS');
    }
}