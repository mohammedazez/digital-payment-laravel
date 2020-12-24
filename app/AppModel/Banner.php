<?php

namespace App\AppModel;

use Illuminate\Database\Eloquent\Model;
use DB;

class Banner extends Model
{
    public static function getImg()
	{
		$query = DB::table('banner')
			->select(
				DB::raw('
					banner.id,
					banner.name_img,
					banner.img_path,
					banner.type_img
					'))
            ->get();
			return $query;
	}    

	public static function getImgSliderMember()
	{
		$query = DB::table('banner')
			->select(
				DB::raw('
					banner.id,
					banner.name_img,
					banner.img_path,
					banner.type_img
					'))
			->where('banner.type_img','slider member')
            ->get();
			return $query;
	}    

	public static function getImgSliderHome()
	{
		$query = DB::table('banner')
			->select(
				DB::raw('
					banner.id,
					banner.name_img,
					banner.img_path,
					banner.type_img
					'))
			->where('banner.type_img','slider home')
            ->get();
			return $query;
	}   

	public static function getImgBackgroundHome()
	{
		$query = DB::table('banner')
			->select(
				DB::raw('
					banner.id,
					banner.name_img,
					banner.img_path,
					banner.type_img
					'))
			->where('banner.type_img','background home')
            ->get();
			return $query;
	}   

	public static function getImgBanner()
	{
		$query = DB::table('banner')
			->select(
				DB::raw('
					banner.id,
					banner.name_img,
					banner.img_path,
					banner.type_img
					'))
			->where('banner.type_img','banner')
            ->get();
			return $query;
	}   


	public static function getImgWhere($id)
	{
		$query = DB::table('banner')
			->select(
				DB::raw('
					banner.id,
					banner.name_img,
					banner.img_path,
					banner.type_img
					'))
			->where('banner.id',$id)
            ->get();
			return $query;
	}    

	public static function insertData($data)
	{
		$query = DB::table('banner')->insert($data);
	}    

	public static function updatetData($data, $id)
	{
		$query = DB::table('banner')
				->where('id',$id)
				->update($data);
	} 

}