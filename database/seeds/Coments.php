<?php

use Illuminate\Database\Seeder;

class Coments extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		for ( $i = 0; $i < 10; $i ++ ) {
			$phone = DB::table( 'phone' )
			        ->inRandomOrder()
			        ->first();
			$phone_code = DB::table( 'phone_code' )
			           ->inRandomOrder()
			           ->first();
			DB::table( 'coments' )->insert(
				[
					'phone'   => $phone->phone,
					'area_code_id'   => $phone_code->area_code,
					'sub_code_id'   => $phone_code->sub_code,
					'colltype'   => 'colltype ' . $i,
					'name'   => 'name ' . $i,
					'rate' => rand ( -5 , 5),
					'coment'     => 'colltype ' . $i,
				]
			);
		}
	}
}
