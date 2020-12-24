<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Image;
use Session;
use \Input as Input;
class BannerMenuController extends Controller
{
    
    public function index()
    {
        $databanner = Banner::getImg();
        return view('admin.banner.index', compact('databanner'));
    }

    public function create()
    {
        return view('admin.banner.create');

    }

    public function edit($id)
    {
        $databanner = Banner::getImgWhere($id)->first();
        return view('admin.banner.edit', compact('databanner'));

    }

    public function update(Request $request)
    {
      if($request->hasFile('image_add'))
      {
        $id = $request->input('id_img');
        $image       = Input::file('image_add');
        if($request->input('type')=='slider member'){
          $dest = '/img/slider_member';
          $destination = public_path().$dest;
        }else if($request->input('type')=='slider home'){
          $dest = '/assets/images/slider';
          $destination = public_path().$dest;
        }else if($request->input('type')=='background home'){
          $dest = '/img/bakground_home';
          $destination = public_path().$dest;
        }else{
          $dest = '/img/banner';
          $destination = public_path().$dest;
        }
        $namaFoto = $request->input('name_img'). '.' .$image->getClientOriginalExtension();
        
        //proses hapus dulu
        $get = Banner::getImgWhere($id)->first();
        
        $data = public_path($get->img_path);
        if (file_exists($data)) {
            unlink($data);
        } 

        //proses upload
        $request->file('image_add')->move($destination,$namaFoto);

        //flash message jika success
        $request->session()->flash('Upload success', 'Upload success!');
        // return Redirect('uploadan');
        

        //update ke database
        $data = [
            'name_img'=> $request->input('name_img'),
            'img_path'=> $dest.'/'.$namaFoto,
            'type_img'=> $request->input('type')
        ];        

        $insert = Banner::updatetData($data,$id);

        return Redirect(route('banner.menu.index')); 
      }else{
        $id = $request->input('id_img');
        
        //update ke database
        $data = [
            'name_img'=> $request->input('name_img'),
            // 'img_path'=> $dest.'/'.$namaFoto,
            'type_img'=> $request->input('type')
        ];        

        $insert = Banner::updatetData($data,$id);
        return Redirect(route('banner.menu.index'));

      } 
    }      
      

    public function store(Request $request)
    {
      
      if($request->hasFile('image_add'))
      {
        $image       = Input::file('image_add');
        if($request->input('type')=='slider member'){
          $dest = '/img/slider_member';
          $destination = public_path().$dest;
        }else if($request->input('type')=='slider home'){
          $dest = '/assets/images/slider';
          $destination = public_path().$dest;
        }else if($request->input('type')=='background home'){
          $dest = '/img/bakground_home';
          $destination = public_path().$dest;
        }else{
          $dest = '/img/banner';
          $destination = public_path().$dest;
        }
        $namaFoto = $request->input('name_img'). '.' .$image->getClientOriginalExtension();

        //proses upload
        $request->file('image_add')->move($destination,$namaFoto);

        //flash message jika success
        $request->session()->flash('Upload success', 'Upload success!');
        // return Redirect('uploadan');
        

        //insert ke database
        $data = [
            'name_img'=> $request->input('name_img'),
            'img_path'=> $dest.'/'.$namaFoto,
            'type_img'=> $request->input('type')
        ];        

        $insert = Banner::insertData($data);

        return Redirect(route('banner.menu.index'));

        //proses rezize
      }


      $request->session()->flash('Upload fail', 'Upload fail!');
      return Redirect(route('banner.menu.create'));
    }

    public function delete($id)
    {
      $get = Banner::getImgWhere($id)->first();
      $data = public_path($get->img_path);
      if (file_exists($data)) {
            unlink($data);
      } 
      
      DB::table('banner')
          ->where('id', $id)
          ->delete();
      return Redirect(route('banner.menu.index'));
    }
}