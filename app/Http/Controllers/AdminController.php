<?php

namespace App\Http\Controllers;

use App\Coments;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {
	public function index() {
		$coments_new = DB::table( 'coments' )->where( 'status', '=', 'new' )->orderBy( 'created_at' )->get();
		$coments_old = DB::table( 'coments' )->where( 'status', '=', 'confirmed' )->orderBy( 'created_at', 'desc' )->get();
		$coments     = $coments_new->merge( $coments_old );

		return View( 'admin', [ 'coments' => $coments ] );
	}

	public function confirmed( Request $request ) {

		try {
			$coments         = Coments::find( $request->id );

			$coments->status = 'confirmed';
			$coments->save();
			return redirect( '/admin' );
		} catch ( \Exception $e ) {
			return redirect( '/admin' );
		}

	}

	public function delated( Request $request ) {
		try {
			Coments::destroy( $request->id );
			return redirect( '/admin' );
		} catch ( \Exception $e ) {
			return redirect( '/admin' );
		}
	}
}
