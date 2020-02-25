<?php

namespace App;

use Complex\Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Coments extends Model
{

	protected $table = 'coments';
	protected $fillable = [
		'id_phone', 'colltype', 'rate','coment','name','status'
	];
	public static function GetComent ($area_code_id,$sub_code_id,$phone){
		return DB::table('coments')
		             ->where([
		             	['area_code_id','=',$area_code_id],
		             	['sub_code_id','=',$sub_code_id],
		             	['phone','=',$phone],
		             	['status', '=', 'confirmed'],
		             ])->orderBy( 'created_at' )
		             ->first();

	}
}
