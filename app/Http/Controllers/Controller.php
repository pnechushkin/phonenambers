<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use View;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	public function __construct( Request $request ) {

		$RandomComments   = [];
		$IdRandomComments = [];
		$fones_coments= DB::table( 'coments' )
		           ->where( 'coments.status', 'LIKE', 'confirmed' )
		           ->orderBy('updated_at', 'desc')
		           ->limit(10)
		->get();

		foreach ( $fones_coments as $fones) {

			$phone_href = '/number/' . $fones->area_code_id . $fones->sub_code_id . $fones->phone;
			$phone_text = '+1 (' . $fones->area_code_id . ') ' . $fones->sub_code_id . '-' . $fones->phone;

			if ( $fones->rate == 0 ) {
				$class = 'alert alert-warning';
			} elseif ( $fones->rate < 0 ) {
				$class = 'alert alert-danger';
			} elseif ( $fones->rate > 0 ) {
				$class = 'alert alert-info';
			}
			$RandomComments[] = [
				'name'       => $fones->name,
				'colltype'   => $fones->colltype,
				'rate'       => $fones->rate,
				'coment'     => $fones->coment,
				'created_at' => date( 'd.m.Y ', strtotime( $fones->created_at ) ),
				'phone_href' => $phone_href,
				'phone_text' => $phone_text,
				'class'      => null,
			];
		}
		View::share( 'RandomComments', $RandomComments );
		$ActivMenu = [
			'codes'    => '',
			'code'     => '',
			'city'     => '',
			'number'   => '',
			'province' => '',
			'privacy'  => '',
		];
		foreach ( $ActivMenu as $activ_menu => $v ) {
			if ( strstr( $request->getUri(), $activ_menu ) ) {
				$ActivMenu[ $activ_menu ] = 'active';
			}
		}
		View::share( 'ActivMenu', $ActivMenu );
		View::share( 'searched_phones', [] );
		View::share( 'phones_in_code', [] );
	}

}
