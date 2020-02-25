<?php

namespace App\Http\Controllers;

use App\User;
use Doctrine\DBAL\Schema\View;
use Illuminate\Http\Request;
use Mockery\Exception;
use Validator;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller {
	public function index() {
		return View( 'settings' );
	}

	public function ResetPassword (){
		Auth::logout();
		return redirect( '/password/reset' );
	}

	public function Save( Request $request ) {
		$email       = $request->input( 'email' );
		$OldPassword = $request->input( 'OldPassword' );
		$NewPassword = $request->input( 'NewPassword' );
		$validator   = Validator::make( $request->all(),
			[
				'email'           => 'required|email|max:255',
				'OldPassword'     => 'required|min:5',
				'NewPassword'     => 'min:5',
				'ConfirmPassword' => 'min:5|same:NewPassword',
			]
		);
		if ( $validator->fails() ) {
			return redirect( 'admin/settings' )->withErrors( $validator )->withInput();
		}
		$users = DB::table( 'users' )->where( [
			[ 'name', 'not like', Auth::user()->name ],
			[ 'email', 'like', $email ],
		] )->get();
		if ( count( $users ) != 0 ) {
			return redirect( 'admin/settings' )->withErrors( [ 'email' => 'E-mail ' . $email . ' уже занят!' ] )->withInput();
		}
		$user = DB::table( 'users' )->where( 'name', Auth::user()->name )->first();
		if ( Hash::check( $OldPassword, $user->password ) ) {
			try {
				$user = User::find( $user->id );
				if ( ! empty( $NewPassword ) ) {
					$user->password = Hash::make( $NewPassword );
				}
				$user->email = $email;
				$user->save();

			} catch ( Exception $exception ) {
				return redirect( 'admin/settings' )->withErrors( [ 'sql' => $exception->getMessage() ] );
			}
		} else {
			return redirect( 'admin/settings' )->withErrors( [ 'OldPassword' => 'Старый пароль не совпадает' ] )->withInput();
		}
		Auth::logout();

		return redirect( '/' );
	}
}
