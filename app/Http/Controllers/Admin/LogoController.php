<?php

namespace App\Http\Controllers\Admin;

use Pulsa;
use App\AppModel\Setting;
use App\AppModel\Logo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use File;
use DB;
use Uuid;
use \Input as Input;

class LogoController extends Controller
{
    public function index()
    { 
    	$dataLogo = Logo::all();
        return view('admin.pengaturan.logo.index', compact('dataLogo'));
    }
    
    public function store(Request $request)
    {
        $getimg = Logo::all();
        if($request->hasFile('image_icon')) {
            
            //proses hapus dulu
            if(isset($getimg[0])){
                if($getimg[0]->img !='' || $getimg[0]->img !=null){
                    if (file_exists(public_path('/img/logo/'.$getimg[0]->img.''))) {
                        unlink(public_path('/img/logo/'.$getimg[0]->img.''));
                    } 
                }
            }
        
            $image     = Input::file('image_icon');
            $uuid      = Uuid::generate();
            $imageName = ''.$uuid->string.'.'.$image->getClientOriginalExtension();
            $temp      = public_path('/img/logo/temp');
            $dest      = public_path('/img/logo');
            
            if (!file_exists($dest)) {
                mkdir($dest, 755, true);
            }
            
            if (!file_exists($temp)) {
                mkdir($temp, 755, true);
            }
            
            $image->move($temp, $imageName);
            
            
            $imageResize = Image::make($temp.'/'.$imageName);
            $imageResize->resize(152, 152, function ($constraint) {
                                $constraint->aspectRatio();
                            });
            $imageResize->resizeCanvas(152, 152);
            $imageResize->save($dest.'/'.$imageName, 80);
            $imageResize->destroy();
            
            File::delete([$temp.'/'.$imageName]);
            
            //insert ke database
            $logo = Logo::findOrFail('1');
            $logo->type = 'icon';
            $logo->name = 'icon';
            $logo->img  = (isset($imageName))?$imageName:null;
            $logo->save();
        }

        if($request->hasFile('image_logo_guest')) {
            
            //proses hapus dulu
            if(isset($getimg[1])){
                if($getimg[1]->img !='' || $getimg[1]->img !=null){
                    if (file_exists(public_path('/img/logo/'.$getimg[1]->img.''))) {
                        unlink(public_path('/img/logo/'.$getimg[1]->img.''));
                    } 
                }
            }
            
            $image     = Input::file('image_logo_guest');
            $uuid      = Uuid::generate();
            $imageName = ''.$uuid->string.'.'.$image->getClientOriginalExtension();
            $temp      = public_path('/img/logo/temp');
            $dest      = public_path('/img/logo');
            
            if (!file_exists($dest)) {
                mkdir($dest, 755, true);
            }
            
            if (!file_exists($temp)) {
                mkdir($temp, 755, true);
            }
            
            $image->move($temp, $imageName);
            
            
            $imageResize = Image::make($temp.'/'.$imageName);
            $imageResize->resize(200, 50, function ($constraint) {
                                $constraint->aspectRatio();
                            });
            $imageResize->resizeCanvas(200, 50);
            $imageResize->save($dest.'/'.$imageName, 80);
            $imageResize->destroy();
            
            File::delete([$temp.'/'.$imageName]);
            
            //insert ke database
            $logo = Logo::findOrFail('2');
            $logo->type = 'logo-guest';
            $logo->name = 'logo guest';
            $logo->img  = (isset($imageName))?$imageName:null;
            $logo->save();
        }

        if($request->hasFile('image_logo_member_admin')) {
            
            //proses hapus dulu
            if(isset($getimg[2])){
                if($getimg[2]->img !='' || $getimg[2]->img !=null){
                    if (file_exists(public_path('/img/logo/'.$getimg[2]->img.''))) {
                        unlink(public_path('/img/logo/'.$getimg[2]->img.''));
                    } 
                }
            }
            
            $image     = Input::file('image_logo_member_admin');
            $uuid      = Uuid::generate();
            $imageName = ''.$uuid->string.'.'.$image->getClientOriginalExtension();
            $temp      = public_path('/img/logo/temp');
            $dest      = public_path('/img/logo');
            
            if (!file_exists($dest)) {
                mkdir($dest, 755, true);
            }
            
            if (!file_exists($temp)) {
                mkdir($temp, 755, true);
            }
            
            $image->move($temp, $imageName);
            
            
            $imageResize = Image::make($temp.'/'.$imageName);
            $imageResize->resize(200, 50, function ($constraint) {
                                $constraint->aspectRatio();
                            });
            $imageResize->resizeCanvas(200, 50);
            $imageResize->save($dest.'/'.$imageName, 80);
            $imageResize->destroy();
            
            File::delete([$temp.'/'.$imageName]);
            
            //insert ke database
            $logo = Logo::findOrFail('3');
            $logo->type = 'logo-member-admin';
            $logo->name = 'logo member admin';
            $logo->img  = (isset($imageName))?$imageName:null;
            $logo->save();
        }
        
        return redirect()->back()->with('alert-success', 'Upload success!');
        // return redirect()->back()->with('alert-error', 'Upload Fail!');
    }
}