<?php

namespace App\Http\Controllers\Admin;

use Pulsa, Response, Freesms4Us, Notif;
use App\User;
use App\Role;
use App\AppModel\Role_user;
use App\AppModel\Membership;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;
use Auth;
use File;
use Mail;

class MembershipController  extends Controller
{
    public function index()
    {
        $membershipWeb = Membership::get();
        $membershipMobile = Membership::orderBy('created_at', 'DESC')->paginate(10);
        return view('admin.validasi_membership.index', compact('membershipWeb', 'membershipMobile'));
    }
    
    public function getDatatable(Request $request)
    {
        $columns = array( 
                            0  =>'no', 
                            1  =>'id',
                            2  => 'username',
                            3  => 'roleup',
                            4  => 'created_at',
                            5  => 'tgl_validasi',
                            6  => 'status',
                            7  => 'action',
                        );
  
        $totalData = Membership::count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if(empty($request->input('search.value')))
        {            
            $posts = Membership::select('memberships.*','users.name','roles_from.display_name as from_role_name', 'roles_to.display_name as to_role_name')
                                ->leftjoin('users','memberships.user_id','users.id')
                                ->leftjoin('roles as roles_from','memberships.from_role','roles_from.id')
                                ->leftjoin('roles as roles_to','memberships.to_role','roles_to.id')
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy('created_at', 'DESC')
                                ->get();
        }else {
            $search = $request->input('search.value'); 

            if(strtoupper($search) == 'MENUNGGU'){
                $stts = '0';
            }elseif(strtoupper($search) == 'TERVALIDASI'){
                $stts = '1';
            }elseif(strtoupper($search) == 'TIDAK TERVALIDASI'){
                $stts = '2';
            }else{
                $stts = null;
            };
                  
            $posts =  Membership::select('memberships.*','users.name','roles_from.display_name as from_role_name', 'roles_to.display_name as to_role_name')
                                ->leftjoin('users','memberships.user_id','users.id')
                                ->leftjoin('roles as roles_from','memberships.from_role','roles_from.id')
                                ->leftjoin('roles as roles_to','memberships.to_role','roles_to.id')
                                ->where(function($q) use ($search, $stts){
                                        $q->where('memberships.id','LIKE',"%{$search}%");
                                        $q->orWhere('roles_from.display_name', 'LIKE',"%{$search}%");
                                        $q->orWhere('roles_to.display_name', 'LIKE',"%{$search}%");
                                        $q->orWhere('users.name', 'LIKE',"%{$search}%");
                                        if($stts != null){
                                            $q->orWhere('memberships.status', $stts);
                                        }
                                     })
                                ->offset($start)
                                ->limit($limit)
                                ->orderBy('memberships.created_at', 'DESC')
                                ->get();

            $totalFiltered = Membership::select('memberships.*','users.name','roles_from.display_name as from_role_name', 'roles_to.display_name as to_role_name')
                                        ->leftjoin('users','memberships.user_id','users.id')
                                        ->leftjoin('roles as roles_from','memberships.from_role','roles_from.id')
                                        ->leftjoin('roles as roles_to','memberships.to_role','roles_to.id')
                                        ->where(function($q) use ($search, $stts){
                                                $q->where('memberships.id','LIKE',"%{$search}%");
                                                $q->orWhere('roles_from.display_name', 'LIKE',"%{$search}%");
                                                $q->orWhere('roles_to.display_name', 'LIKE',"%{$search}%");
                                                $q->orWhere('users.name', 'LIKE',"%{$search}%");
                                                if($stts != null){
                                                    $q->orWhere('memberships.status', $stts);
                                                }
                                            })
                                        ->orderBy('memberships.created_at', 'DESC')
                                        ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            $no = 0;
            foreach ($posts as $post)
            {
                
                $no++;
                $nestedData['no']          = $start+$no;
                $nestedData['id']          = '<td><a href="'.url('/admin/transaksi/produk', $post->id).'">#'.$post->id.'</a><br>'.$post->code.'</td>';
                $toltip = '#'.(isset($post->user->id)?''.$post->user->id.'':''.$post->usid.'').' | ';
                $toltip .= ''.(isset($post->user->name)?''.$post->user->name.'':''.$post->name.'').' | ';
                $toltip .= 'Status user : '.((isset($post->user->status)?$post->user->status:$post->ustat) == '1'?'Aktif':'Nonaktif').' | ';
                $toltip .= 'Status validasi : '.((isset($post->user->users_validation->status)?$post->user->users_validation->status:$post->status_validation) == '1'?'Tervalidasi':'Tidak Tervalidasi').'';
                
                $nestedData['username']     = '<td><a href="'.url('/admin/users', (isset($post->user->id)?''.$post->user->id.'':''.$post->usid.'')).'" class="btn-loading" data-toggle="tooltip" data-placement="bottom" title="'.$toltip.'">'.(isset($post->user->name)?''.$post->user->name.'':''.$post->name.'').'</a><br>'.$post->pengirim.'</td>';
                $nestedData['roleup']       = '<td>'.$post->from_role_name.' <i class="fa fa-arrow-right fa-fw"></i> '.$post->to_role_name.'<td>';
                $nestedData['created_at']   = Carbon::parse($post->created_at)->format('d M Y').'<br>'.Carbon::parse($post->created_at)->format('H:i:s');
                $nestedData['tgl_validasi']  = Carbon::parse($post->tgl_validasi)->format('d M Y').'<br>'.Carbon::parse($post->tgl_validasi)->format('H:i:s');
                if($post->status           == 0){
                    $nestedData['status'] = '<td><span class="label label-warning">MENUNGGU</span></td>';
                }elseif($post->status == 1){
                    $nestedData['status'] = '<td><span class="label label-success">TERVALIDASI</span></td>';
                }elseif($post->status == 2){
                    $nestedData['status'] = '<td><span class="label label-danger">TDAK TERVALIDASI</span></td>';
                };
                $nestedData['detail'] = '<td><a href="'.url('/admin/membership/show',$post->id).'"><span class="label label-warning">Detail</span></a></td>';
                $nestedData['action'] = '<div class="dropdown" style="padding: 2px 5px;font-size:10px;">
                                          <button class="btn btn-xs btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                            Action
                                            <span class="caret"></span>
                                          </button>
                                          <ul class="dropdown-menu dropdown-menu-left">
                                            <li><a href="'.url('/admin/membership/approve', $post->id).'"><i class="fa fa-check-square-o fa-fw"></i>Approve</a></li>
                                            <li><a href="'.url('/admin/membership/nonapprove', $post->id).'"><i class="fa fa-close"></i>Not Approve</a></li>
                                            <li role="separator" class="divider"></li>';
                                            $nestedData['action']     .= '<li><a href="'.url('/admin/users', $post->user->id).'"><i class="fa fa-user-circle fa-fw"></i>Go To Profile</a></li>';
                                            
                    $nestedData['action'] .='</ul>
                                        </div>';
                                        
                                                  

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
    
    
    public function approveValidasi($id){
        DB::beginTransaction();
        try{
            $updateMember = Membership::findOrFail($id);
           
            $updateMember->tgl_validasi = date("Y-m-d H:i:s");
            $updateMember->status = '1';
            $updateMember->save();
            
            $updateRoleUser = Role_user::findOrFail($updateMember->user_id);
           
            $updateRoleUser->role_id = $updateMember->to_role;
            $updateRoleUser->save();
            
            DB::commit();
            return redirect()->back()->with('alert-success', 'Berhasil Merubah Data');
        }catch (\Exception $e){
            DB::rollback();
            dd($e);
        }
    }
    
    public function nonapproveValidasi($id){
        
        DB::beginTransaction();
        try{
            $updateMember = Membership::findOrFail($id);
            $updateMember->tgl_validasi = date("Y-m-d H:i:s");
            $updateMember->status = '2';
            $updateMember->save();
            DB::commit();
            return redirect()->back()->with('alert-success', 'Berhasil Merubah Data');
        }catch (\Exception $e){
            DB::rollback();
            dd($e);
        }
    }
    
    public function show($id){
        $data = Membership::select('memberships.*','users.name','roles_from.display_name as from_role_name', 'roles_to.display_name as to_role_name','users.email','users.phone')
                                ->leftjoin('users','memberships.user_id','users.id')
                                ->leftjoin('roles as roles_from','memberships.from_role','roles_from.id')
                                ->leftjoin('roles as roles_to','memberships.to_role','roles_to.id')
                                ->where('memberships.id',$id)
                                ->first();
       
        return view('admin.validasi_membership.show', compact('data'));
    }
    
}
