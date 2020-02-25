<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Phone extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {

			for ( $a = 0; $a <= 9; $a ++ ) {
				for ( $b = 0; $b <= 9; $b ++ ) {
					for ( $c = 0; $c <= 9; $c ++ ) {
						for ( $d = 0; $d <= 9; $d ++ ) {
							DB::table( 'phone' )->insert(
								[ 'phone' =>  $a . $b . $c . $d]
							);
						}
					}
				}

		}


	}
}
