<?php

use Illuminate\Database\Seeder;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class PhoneCode extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		$inputFileName = 'AreaCodes.xlsx';
		$spreadsheet   = IOFactory::load( $inputFileName );
		$xls_data      = $spreadsheet->getActiveSheet()->toArray( null, true, true, true );
		for ( $i = 2; $i < count( $xls_data ); $i ++ ) {
				extract($xls_data[$i]);
			DB::table( 'phone_code' )->insert([
				'area_code' => $A,
				'sub_code' => $B,
				'city' => $C,
				'province' => $D,
				'country' => $E,
				'lat' => $F,
				'long' => $G,
				'timezone' => $H,
			]);
		}
		$additional_area_code =[800,833,844,855,866,877,888];
		foreach ($additional_area_code as $code){
			for ($x=200; $x<1000;$x++){
				DB::table( 'phone_code' )->insert([
					'area_code' => $code,
					'sub_code' => $x,
					'city' => 'Ottawa',
					'province' => 'Ontario',
					'country' => 'CA',
					'lat' => 45.4111700,
					'long' => -75.6981200,
					'timezone' => '-05:00',
				]);
			}

		}
	}
}
