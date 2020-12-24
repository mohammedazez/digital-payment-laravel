<?php

namespace App\Http\Controllers\MenuSubmenu;

use Auth, Response, Freesms4Us, Validator;
use App\User;
use App\AppModel\MenuSubmenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MenuSubmenuController extends Controller
{
    public function menuSubmenuMember()
    {
        $data = MenuSubmenu::getMenuMember();
        // return json_encode($data);
    	return view('layouts.member', compact('data'));
    }

    public function menuSubmenuAdmin()
    {
        $data = MenuSubmenu::getSubMenuOneMember();
        // return json_encode($data);
        return view('layouts.admin', compact('data'));
    }

}