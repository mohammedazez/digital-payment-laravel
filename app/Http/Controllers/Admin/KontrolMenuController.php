<?php

namespace App\Http\Controllers\Admin;

use App\AppModel\MenuSubmenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class KontrolMenuController extends Controller
{
    
    public function index()
    {
        $datamenu = MenuSubmenu::getMenuMember();
        $datasubmenu = MenuSubmenu::getSubMenuOneMember();
        return view('admin.kontrol-menu.index', compact('datamenu','datasubmenu'));
    }

    public function editMenu($id)
    {
        $section_active ='MENU';
        $getRole        = MenuSubmenu::getRoleUser();
        $datamenu       = MenuSubmenu::getMenuMemberWhere($id)->first();
        return view('admin.kontrol-menu.show', compact('datamenu','getRole','section_active'));
    }

    public function editSubmenu($id)
    {
        $section_active ='SUBMENU';
        $getRole        = MenuSubmenu::getRoleUser();
        $getSubMenu     = MenuSubmenu::getMenuMember();
        $datamenu       = MenuSubmenu::getSubMenuMemberWhere($id)->first();
        return view('admin.kontrol-menu.show', compact('datamenu','getRole','section_active','getSubMenu'));
    }

    public function editSubmenu2($id)
    {
        $section_active ='SUBMENU2';
        $getRole        = MenuSubmenu::getRoleUser();
        $getSubMenu     = MenuSubmenu::getSubMenuOneMember();
        // dd($getSubMenu);
        $datamenu       = MenuSubmenu::getSubMenuMemberWhere2($id)->first();
        return view('admin.kontrol-menu.show', compact('datamenu','getRole','section_active','getSubMenu'));
    }

    public function updateSaveMenu(Request $request)
    {
        $this->validate($request,[
            'caption' => 'required',
        ],[
            'caption.required' => 'Caption tidak boleh kosong',
        ]);

        DB::table('sidebar_menu_member')
            ->where('id', $request->id)
            ->update([
                'caption' => $request->caption,
                'icon' => $request->icon,
                'permission_menu' => $request->permission,
                'status' => $request->status,
                ]);

        return redirect()->back()->with('alert-success', 'Berhasil Merubah Data Produk');
    }
    

    public function updateSaveSubmenu(Request $request)
    { 

      $this->validate($request,[
            'caption_sub' => 'required',
            'url' => 'required',
        ],[
            'caption_sub.required' => 'Caption tidak boleh kosong',
            'url.required' => 'URL tidak boleh kosong',
        ]);

        DB::table('sidebar_submenu_member')
            ->where('id', $request->id)
            ->update([
                'caption'         => $request->caption_sub,
                'parent_id'       => $request->parent_menu,
                'icon'            => $request->icon_sub,
                'url'             => $request->url,
                'status'          => $request->status_sub,
                'permission_menu' => $request->permission,
                ]);
        return redirect()->back()->with('alert-success', 'Berhasil Merubah Data Produk');
    }
    

    public function updateSaveSubmenu2(Request $request)
    {
        $this->validate($request,[
            'caption_sub2' => 'required',
            'url' => 'required',
        ],[
            'caption_sub2.required' => 'Caption tidak boleh kosong',
            'url.required' => 'URL tidak boleh kosong',
        ]);

        DB::table('sidebar_submenu2_member')
            ->where('id', $request->id)
            ->update([
                'caption'         => $request->caption_sub2,
                'parent_id'       => $request->parent_menu,
                'icon'            => $request->icon_sub2,
                'url'             => $request->url,
                'status'          => $request->status_sub2,
                'permission_menu' => $request->permission,
                ]);

        return redirect()->back()->with('alert-success', 'Berhasil Merubah Data Produk');
    }
    

    public function nonaktifkanMenu(Request $request)
    {
        $id = $request->input('id');
        DB::table('sidebar_menu_member')
          ->where('id', $id)
          ->update([
              'status'=> '0'
          ]);

    }

    public function aktifkanMenu(Request $request)
    {
        $id = $request->input('id');
        DB::table('sidebar_menu_member')
          ->where('id', $id)
          ->update([
              'status'=> '1'
          ]);

    }

    public function nonaktifkanSubMenu(Request $request)
    {
        $id = $request->input('id');
        DB::table('sidebar_submenu_member')
          ->where('id', $id)
          ->update([
              'status'=> '0'
          ]);
    }

    public function aktifkanSubMenu(Request $request)
    {
        $id = $request->input('id');
        DB::table('sidebar_submenu_member')
          ->where('id', $id)
          ->update([
              'status'=> '1'
          ]);
    }

    public function nonaktifkanSubMenu2(Request $request)
    {
        $id = $request->input('id');
        DB::table('sidebar_submenu2_member')
          ->where('id', $id)
          ->update([
              'status'=> '0'
          ]);
    }

    public function aktifkanSubMenu2(Request $request)
    {
        $id = $request->input('id');
        DB::table('sidebar_submenu2_member')
          ->where('id', $id)
          ->update([
              'status'=> '1'
          ]);
    }


   //ALL MENU
   public function aktifkanAllMenu1(Request $request)
    {
        $id = $request->input('id');
        DB::table('sidebar_menu_member')
          ->update([
              'status'=> '1'
          ]);
    }

    public function nonaktifkanAllMenu1(Request $request)
    {
        $id = $request->input('id');
        DB::table('sidebar_menu_member')
          ->update([
              'status'=> '0'
          ]);
    }
    
    public function aktifkanAllMenu2(Request $request)
    {
        $id = $request->input('id');
        DB::table('sidebar_submenu_member')
          ->update([
              'status'=> '1'
          ]);
    }

   public function nonaktifkanAllMenu2(Request $request)
    {
        $id = $request->input('id');
        DB::table('sidebar_submenu_member')
          ->update([
              'status'=> '0'
          ]);
    }
       public function aktifkanAllMenu3(Request $request)
    {
        $id = $request->input('id');
        DB::table('sidebar_submenu2_member')
          ->update([
              'status'=> '1'
          ]);
    }

   public function nonaktifkanAllMenu3(Request $request)
    {
        $id = $request->input('id');
        DB::table('sidebar_submenu2_member')
          ->update([
              'status'=> '0'
          ]);
    }






}