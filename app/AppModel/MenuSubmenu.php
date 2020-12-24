<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
use URL;

class MenuSubmenu extends Model
{
    public static function getMenuMember()
	{
		$query = DB::table('sidebar_menu_member')
			->select(
				DB::raw('
					sidebar_menu_member.id,
					sidebar_menu_member.caption,
					sidebar_menu_member.icon,
					sidebar_menu_member.status,
					sidebar_menu_member.permission_menu,
					roles.display_name
					'))
			->leftjoin('roles','sidebar_menu_member.permission_menu','roles.id')
            ->get();
			return $query;
	}    

    public static function getSubMenuOneMember()
	{
		$query = DB::table('sidebar_submenu_member')
			->select(
				DB::raw('
					sidebar_submenu_member.id,
					sidebar_submenu_member.parent_id,
					sidebar_submenu_member.caption as caption_sub,
					sidebar_submenu_member.icon as icon_sub,
					sidebar_submenu_member.url,
					sidebar_submenu_member.status as status_sub,
					sidebar_submenu_member.permission_menu,
					sidebar_menu_member.caption,
					roles.display_name
					'))
			->leftjoin('sidebar_menu_member','sidebar_submenu_member.parent_id','sidebar_menu_member.id')
			->leftjoin('roles','sidebar_submenu_member.permission_menu','roles.id')
            ->get();
			return $query;
	}  

	public static function getSubMenuOneMember2()
	{
		$query = DB::table('sidebar_submenu2_member')
			->select(
				DB::raw('
					sidebar_submenu2_member.id,
					sidebar_submenu2_member.parent_id,
					sidebar_submenu2_member.caption as caption_sub2,
					sidebar_submenu2_member.icon as icon_sub2,
					sidebar_submenu2_member.url,
					sidebar_submenu2_member.status as status_sub2,
					sidebar_submenu2_member.permission_menu,
					sidebar_submenu_member.caption,
					roles.display_name
					'))
			->leftjoin('sidebar_submenu_member','sidebar_submenu2_member.parent_id','sidebar_submenu_member.id')
			->leftjoin('roles','sidebar_submenu2_member.permission_menu','roles.id')
            ->get();
			return $query;
	}  

    public static function getMenuMemberWhere($data)
	{
		$query = DB::table('sidebar_menu_member')
			->select(
				DB::raw('
					sidebar_menu_member.id,
					sidebar_menu_member.caption,
					sidebar_menu_member.icon,
					sidebar_menu_member.status,
					sidebar_menu_member.permission_menu,
					roles.display_name
					'))
			->leftjoin('roles','sidebar_menu_member.permission_menu','roles.id')
			->where('sidebar_menu_member.id',$data)
            ->get();
			return $query;
	}       

	public static function getSubMenuMemberWhere($data)
	{
		$query = DB::table('sidebar_submenu_member')
			->select(
				DB::raw('
					sidebar_submenu_member.id,
					sidebar_submenu_member.parent_id,
					sidebar_submenu_member.caption as caption_sub,
					sidebar_submenu_member.icon as icon_sub,
					sidebar_submenu_member.url,
					sidebar_submenu_member.status as status_sub,
					sidebar_submenu_member.jenis,
					sidebar_submenu_member.permission_menu,
					roles.display_name,
					sidebar_menu_member.id as idparent,
					sidebar_menu_member.caption as captionparent
					'))
			->leftjoin('roles','sidebar_submenu_member.permission_menu','roles.id')
			->leftjoin('sidebar_menu_member','sidebar_submenu_member.parent_id','sidebar_menu_member.id')
			->where('sidebar_submenu_member.id',$data)
            ->get();
			return $query;
	}  

	public static function getSubMenuMemberWhere2($data)
	{
		$query = DB::table('sidebar_submenu2_member')
			->select(
				DB::raw('
					sidebar_submenu2_member.id,
					sidebar_submenu2_member.parent_id,
					sidebar_submenu2_member.caption as caption_sub2,
					sidebar_submenu2_member.icon as icon_sub2,
					sidebar_submenu2_member.url,
					sidebar_submenu2_member.status as status_sub2,
					sidebar_submenu2_member.permission_menu,
					roles.display_name,
					sidebar_submenu_member.id as idparent,
					sidebar_submenu_member.caption as captionparent
					'))
			->leftjoin('roles','sidebar_submenu2_member.permission_menu','roles.id')
			->leftjoin('sidebar_submenu_member','sidebar_submenu2_member.parent_id','sidebar_submenu_member.id')
			->where('sidebar_submenu2_member.id',$data)
            ->get();
			return $query;
	}  


    public static function getSubMenuMember($data)
	{
		$query = DB::table('sidebar_submenu_member')
			->select(
				DB::raw('
					sidebar_submenu_member.id,
					sidebar_submenu_member.parent_id,
					sidebar_submenu_member.caption as caption_sub,
					sidebar_submenu_member.icon as icon_sub,
					sidebar_submenu_member.url,
					sidebar_submenu_member.status as status_sub,
					sidebar_submenu_member.jenis,
					sidebar_submenu_member.permission_menu,
					roles.display_name
					'))
			->leftjoin('roles','sidebar_submenu_member.permission_menu','roles.id')
			->where('sidebar_submenu_member.parent_id',$data)
            ->get();
			return $query;
	}  

	public static function getSubMenuMember2($data)
	{
		$query = DB::table('sidebar_submenu2_member')
			->select(
				DB::raw('
					sidebar_submenu2_member.id,
					sidebar_submenu2_member.parent_id,
					sidebar_submenu2_member.caption as caption_sub2,
					sidebar_submenu2_member.icon as icon_sub2,
					sidebar_submenu2_member.url,
					sidebar_submenu2_member.status as status_sub2,
					sidebar_submenu2_member.permission_menu,
					roles.display_name
					'))
			->leftjoin('roles','sidebar_submenu2_member.permission_menu','roles.id')
			->where('sidebar_submenu2_member.parent_id',$data)
            ->get();
			return $query;
	}  


///////////////

    public static function getMenuMemberURL()
	{
		$query = DB::table('sidebar_menu_member')
			->select(
				DB::raw('
					sidebar_menu_member.id,
					sidebar_menu_member.caption,
					sidebar_menu_member.icon,
					sidebar_menu_member.status,
					sidebar_menu_member.permission_menu,
					roles.display_name
					'))
			->leftjoin('roles','sidebar_menu_member.permission_menu','roles.id')
            ->get();
			return $query;
	}    

    public static function getSubMenuOneMemberURL($url)
	{
		$query = DB::table('sidebar_submenu_member')
			->select(
				DB::raw('
					sidebar_submenu_member.id,
					sidebar_submenu_member.parent_id,
					sidebar_submenu_member.caption as caption_sub,
					sidebar_submenu_member.icon as icon_sub,
					sidebar_submenu_member.url,
					sidebar_submenu_member.status as status_sub,
					sidebar_submenu_member.permission_menu,
					roles.display_name
					'))
			->leftjoin('roles','sidebar_submenu_member.permission_menu','roles.id')
			->where('sidebar_submenu_member.url',$url)
            ->get();
			return $query;
	}  

	public static function getSubMenuOneMember2URL($url)
	{
		$query = DB::table('sidebar_submenu2_member')
			->select(
				DB::raw('
					sidebar_submenu2_member.id,
					sidebar_submenu2_member.parent_id,
					sidebar_submenu2_member.caption as caption_sub2,
					sidebar_submenu2_member.icon as icon_sub2,
					sidebar_submenu2_member.url,
					sidebar_submenu2_member.status as status_sub2,
					sidebar_submenu2_member.permission_menu,
					roles.display_name
					'))
			->leftjoin('roles','sidebar_submenu2_member.permission_menu','roles.id')
			->where('sidebar_submenu2_member.url',$url)
            ->get();
			return $query;
	} 

	public static function getRoleUser()
	{
		$query = DB::table('roles')
			->select('*')
            ->get();
			return $query;
	} 

	public static function getMenuAndSubMember()
	{
		$id_login = Auth::user()->roles()->first()->id;
	
		$output   = '';
		$dataMenu = self::getMenuMember();
			if(isset($dataMenu) && !empty($dataMenu)){
      		foreach($dataMenu as $item){
		      if($item->status == 1){
			      if(($id_login == 2)?$item->permission_menu == $id_login || $item->permission_menu == 1:
			            (($id_login == 3)?$item->permission_menu == $id_login || $item->permission_menu == 1:$item->permission_menu == $id_login))
			 	  	{
						$dataSubMenu = self::getSubMenuMember($item->id);
			            $output .= '<li class="header">'.$item->caption.'</li>';
			            if(isset($dataSubMenu) && !empty($dataSubMenu)){
				          foreach($dataSubMenu as $ini){
			            	if($ini->status_sub == 1){
			            	    if($id_login == $ini->permission_menu)
			 	  				{
				                  if($ini->jenis == 'treeview'){
					                  	$output .= '<li class="treeview">
					                  				<a href="'.url($ini->url == '#' ? $_SERVER['REQUEST_URI'].'#' : $ini->url).'">
									                     <i class="fa fa-dropbox"></i> <span>Harga Produk</span>
									                     <span class="pull-right-container">
									                        <i class="fa fa-angle-left pull-right"></i>
									                     </span>
									                  </a>
									                  <ul class="treeview-menu">';
														$dataSubMenu2 = self::getSubMenuMember2($ini->id);
									                     foreach($dataSubMenu2 as $data){
			            									if($data->status_sub2 == 1){

			                  									$csActive  = URL::to(url($data->url)) == request()->url()?'active':'';
									                     		$output .='<li class="'.$csActive.'"><a href="'.url('/'.$data->url).'" class="btn-loading">'.$data->caption_sub2.'</a></li>';
									                     	}
									                     }
									    $output .= ' </ul>
				                  				</li>';
				                  }else{
				                  		$classActive  = URL::to(url($ini->url)) == request()->url()?'active':'';
				                 		$output .= '<li class="'.$classActive.'"><a href="'.url('/'.$ini->url).'" class="btn-loading"><span>'.$ini->caption_sub.'</span></a></li>';
				                  }
			 	  				}
				              }
				           }
				        }
			        }
			     }
		       }
		    }

		return $output;
	}


	public static function rendermenu(){
      $txt ='';
      $user = Auth::user();
      $rolesId = $user->roles()->first()->id;
      
      if($rolesId <> 2 )
      {
	      $menus_induk = MenuMember::where('id_induk', 0)->where('permission_menu','<>', 2)->where('status', 1)->get();
	      foreach($menus_induk as $menu_induk){
               $txt .= '<li class="header">'.$menu_induk->nama.'</li>';
               $menus_child = MenuMember::where('id_induk', $menu_induk->id)->where('permission_menu','<>', 2)->where('status', 1)->orderBy('urutan', 'ASC')->get();
               foreach($menus_child as $menu_child){
                   if(($rolesId == 4 && in_array($menu_child->permission_menu,[1,3,4])) || 
                      ($rolesId == 3 && in_array($menu_child->permission_menu,[1,3])) ||
                      ($rolesId == 1 && $menu_child->permission_menu == 1)){
                        if($menu_child->treeview == 0){
                        	$txt .= '<li class="'.((url($menu_child->url) == request()->url())?"active":"").'">';
                            $txt .= '<a href="'.url($menu_child->url == '#' ? $_SERVER['REQUEST_URI'].'#' : $menu_child->url).'" class="btn-loading">';
                              $txt .= '<i class="fa fa-'.$menu_child->icon.'" aria-hidden="true"></i> <span>'.$menu_child->nama.'</span>';
                            $txt .= '</a>';
                          $txt .= '</li>';
                        }else{
                         $pembeliankategori  = Pembeliankategori::where('status', 1)->orderBy('sort_product', 'ASC')->get();
                         $pembayarankategori = Pembayarankategori::where('status', 1)->get();
                          $txt .= '<li class="treeview">';
                            $txt .= '<a href="javascript:void(0);" class="btn-loading">';
                              $txt .= '<i class="fa fa-'.$menu_child->icon.'" aria-hidden="true"></i> <span>'.$menu_child->nama.'</span>';
                                $txt .= '<span class="pull-right-container">';
                                   $txt .= '<i class="fa fa-angle-left pull-right"></i>';
                                $txt .= '</span>';
                                $txt .='<ul class="treeview-menu">';
                                  foreach(json_decode(json_encode($pembeliankategori, false)) as $data){
                                    $txt .='<li class="">';
                                          $txt .='<a href="'.url('/member/harga-produk/pembelian/'.$data->slug).'" class="btn-loading">';
                                            $txt .= $data->product_name.'';
                                          $txt .='</a>';
                                    $txt .='</li>';
                                  }
                                  foreach(json_decode(json_encode($pembayarankategori, false)) as $data){
                                    $txt .='<li class="">';
                                          $txt .='<a href="'.url('/member/harga-produk/pembayaran/'.$data->slug).'" class="btn-loading">';
                                            $txt .= $data->product_name.'';
                                          $txt .='</a>';
                                    $txt .='</li>';
                                  }
                               $txt .= '</ul>';
                            $txt .= '</a>';
                          $txt .= '</li>';
                        }   
                   }
                }
	      }
      }
      elseif($rolesId == 2 )
      {
        $menus_induk = MenuMember::where('id_induk', 0)->where('status', 1)->get();
        foreach($menus_induk as $menu_induk){
                $txt .= '<li class="header">'.$menu_induk->nama.'</li>';
                    $menus_child = MenuMember::where('id_induk', $menu_induk->id)->where('status', 1)->orderBy('urutan', 'ASC')->get();
                    foreach($menus_child as $menu_child){
                      if($menu_child->treeview == 0){

                        $txt .= '<li class="'.((url($menu_child->url) == request()->url())?"active":"").'">';
                          $txt .= '<a href="'.url($menu_child->url == '#' ? $_SERVER['REQUEST_URI'].'#' : $menu_child->url).'" class="btn-loading">';
                            $txt .= '<i class="fa fa-'.$menu_child->icon.'" aria-hidden="true"></i> <span>'.$menu_child->nama.'</span>';
                          $txt .= '</a>';
                        $txt .= '</li>';
                      }else{
                       $pembeliankategori  = Pembeliankategori::where('status', 1)->orderBy('sort_product', 'ASC')->get();
                       $pembayarankategori = Pembayarankategori::where('status', 1)->get();
                        $txt .= '<li class="treeview">';
                          $txt .= '<a href="javascript:void(0);" class="btn-loading">';
                            $txt .= '<i class="fa fa-'.$menu_child->icon.'" aria-hidden="true"></i> <span>'.$menu_child->nama.'</span>';
                              $txt .= '<span class="pull-right-container">';
                                 $txt .= '<i class="fa fa-angle-left pull-right"></i>';
                              $txt .= '</span>';
                              $txt .='<ul class="treeview-menu">';
                                foreach(json_decode(json_encode($pembeliankategori, false)) as $data){
                                  $txt .='<li class="">';
                                        $txt .='<a href="'.url('/member/harga-produk/pembelian/'.$data->slug).'" class="btn-loading">';
                                          $txt .= $data->product_name.'';
                                        $txt .='</a>';
                                  $txt .='</li>';
                                }
                                foreach(json_decode(json_encode($pembayarankategori, false)) as $data){
                                  $txt .='<li class="">';
                                        $txt .='<a href="'.url('/member/harga-produk/pembayaran/'.$data->slug).'" class="btn-loading">';
                                          $txt .= $data->product_name.'';
                                        $txt .='</a>';
                                  $txt .='</li>';
                                }
                             $txt .= '</ul>';
                          $txt .= '</a>';
                        $txt .= '</li>';
                    }
                  }
        	  }
      	 }

          return $txt;
    }

}