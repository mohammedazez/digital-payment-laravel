<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function autocomplete(Request $request)
    {
        $users = User::select("email as name")->where("email","LIKE","%{$request->input('query')}%")->get();
        return response()->json($users);
    }

    public function search(Request $request){
  		$read = "";
  		$post = $request->all();
  		// $query = DB::table('products')->where('product_name','like','%' . $post['search'] . '%')->get();
  		$query = User::where('email','like','%' . $post['search'] . '%')
  						->orWhere('phone','like','%' . $post['search'] . '%')->get();
  		$no=1;

  		foreach($query as $data){
  			if ($data->status == 1) {
  				$read .="
      			<tr class='gradeX even' role='row'>
       				<td>".$no++."</td>
                    <td>".$data->name."</td>
                    <td>".$data->email."</td>
                    <td>".$data->phone."</td>
                    <td>".$data->city."</td>
                    <td>Rp ".number_format($data->saldo, 0, '.', '.')."</td>
                    <td>".$data->roles->first()->display_name."</td>
                   	<td><label class='label label-success'>Aktif<label></td>
                    <td>
                        <form method='POST' action='". route('users.destroy', $data->id) ."' accept-charset='UTF-8'>
                           <input name='_method' type='hidden' value='DELETE'>
                           <input name='_token' type='hidden' value='{{ csrf_token() }}'>
                           <button type='button' class='btn btn-warning btn-sm detail' style='padding: 3px 7px;'><i class='fa fa-search'></i></button>
                           <a href='".route('users.edit', $data->id)."' class='btn btn-success btn-sm' style='padding: 3px 7px;'><i class='fa fa-pencil'></i></a>
                           <button class='btn btn-danger btn-sm' onclick='return confirm('Anda yakin akan menghapus data ?');' type='submit' style='padding: 3px 7px;'><i class='fa fa-trash'></i></button>
                        </form>
                    </td>
                </tr>";
  			}else{
  				$read .="
      			<tr class='gradeX even' role='row'>
       				<td>".$no++."</td>
                    <td>".$data->name."</td>
                    <td>".$data->email."</td>
                    <td>".$data->phone."</td>
                    <td>".$data->city."</td>
                    <td>Rp ".number_format($data->saldo, 0, '.', '.')."</td>
                    <td>".$data->roles->first()->display_name."</td>
                   	<td><label class='label label-danger'>Tidak Aktif<label></td>
                    <td>
                        <form method='POST' action='". route('users.destroy', $data->id) ."' accept-charset='UTF-8'>
                           <input name='_method' type='hidden' value='DELETE'>
                           <input name='_token' type='hidden' value='{{ csrf_token() }}'>
                           <button type='button' class='btn btn-warning btn-sm detail' style='padding: 3px 7px;'><i class='fa fa-search'></i></button>
                           <a href='".route('users.edit', $data->id)."' class='btn btn-success btn-sm' style='padding: 3px 7px;'><i class='fa fa-pencil'></i></a>
                           <button class='btn btn-danger btn-sm' onclick='return confirm('Anda yakin akan menghapus data ?');' type='submit' style='padding: 3px 7px;'><i class='fa fa-trash'></i></button>
                        </form>
                    </td>
                </tr>";
  			}
  			
 		}
  		return $read;
 	}
}