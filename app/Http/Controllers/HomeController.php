<?php

namespace App\Http\Controllers;

use Complex\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use View;
use Phone;
use App\Coments;
use Validator;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller {


	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$AreaCode800 = [ 800, 833, 844, 855, 866, 877, 888 ];
		$Arr         = DB::table( 'phone_code' )
		                 ->distinct()
		                 ->select( 'area_code', 'province' )
		                 ->whereNotIn( 'area_code', $AreaCode800 )
		                 ->orderBy( 'province' )
		                 ->get();
		$Provinces   = [];
		foreach ( $Arr as $Province ) {
			$Provinces[ $Province->province ][] = $Province->area_code;
		}

		return view( 'home', [
			'title'       => 'Canada Phone Numbers| Canada Phone Number Lookup - ' . config( 'app.url' ),
			'description' => 'A complete database of Canadian telephone numbers and a list of Canadian area codes. List of each regional code in Canada. The list contains regional and provincial codes, as well as by number.',
			'area_code'   => DB::table( 'phone_code' )
			                   ->distinct()
			                   ->select( 'area_code', 'province' )
			                   ->orderBy( 'province' )
			                   ->get(),
			'Provinces'   => $Provinces,
			'Numbers'     => $Arr,
		] );

	}

	public function AreaCode( Request $request ) {
		$area_code = (int) $request->area_code;

		$page = (int) abs( $request->page );
		if ( empty( $page ) ) {
			$page             = 1;
			$page_title       = null;
			$page_description = null;
		} else {
			$page_title       = $page . ' -';
			$page_description = ' Page ' . $page;
		}
		$quality_phones_on_page = 100;
		$all_area_code          = DB::table( 'phone_code' )->where( 'area_code', '=', $area_code )->get();
		if ( empty( $area_code ) || count( str_split( $area_code ) ) != 3 ) {
			$area_code = DB::table( 'phone_code' )->distinct()->select( 'area_code' )->get();

			return view( 'AllAreaCode' )->with( [
				'title'       => $request->area_code . 'Canada Area Codes - ' . $page_title . config( 'app.url' ),
				'description' => 'All canadian area phone codes at Canada Phone Numbers Database' . $page_description,
				'area_code'   => $area_code,

			] );
		}
		if ( empty( $all_area_code->count() ) ) {
			return redirect( '/codes' );
		}
		$sub_codes    = DB::table( 'phone_code' )
		                  ->where( 'area_code', '=', $area_code )
		                  ->skip( $quality_phones_on_page * ( $page - 1 ) )
		                  ->take( $quality_phones_on_page )
		                  ->get();
		$area_code    = DB::table( 'phone_code' )->where( 'area_code', '=', $area_code )->first();
		$preview_page = $page - 1;
		$next_page    = $page + 1;
		$last_page    = ceil( $all_area_code->count() / $quality_phones_on_page );
		if ( empty( $last_page ) ) {
			$last_page = 1;
		}
		if ( $page > $last_page ) {

			return redirect( '/codes/' . $area_code->area_code );
		}
		$phones_in_code = DB::table( 'phone_code' )
                                ->where( 'area_code', '=', $area_code->area_code )
		                        ->inRandomOrder()
		                        ->distinct()
		                        ->limit( 18 )
		                        ->get()->toArray();
		$phpnes_sql         = DB::table( 'phone' )->select( 'phone' )
		                        ->inRandomOrder()
		                        ->distinct()
		                        ->limit( 18 )
		                        ->get()->toArray();
		for ($i=0;$i<count($phones_in_code);$i++){
			$phones_in_code[$i]->phone=$phpnes_sql[$i]->phone;
		}
		$searched_phones = DB::table( 'phone_code' )
		                     ->inRandomOrder()
		                     ->distinct()
		                     ->limit( 18 )
		                     ->get()->toArray();
		$phones_s = DB::table( 'phone' )->select( 'phone' )
		              ->inRandomOrder()
		              ->distinct()
		              ->limit( 18 )
		              ->get()->toArray();
		for ($i=0;$i<count($searched_phones);$i++){
			$searched_phones[$i]->phone=$phones_s[$i]->phone;
		}


		return view( 'AreaCode' )->with( [
			'area_code'    => $area_code,
			'sub_codes'    => $sub_codes,
			'title'        => $area_code->area_code . ' Canada Phone Numbers| Canada Phone Number Lookup - ' . $page_title . config( 'app.url' ),
			'description'  => 'Area Code ' . $area_code->area_code . '. Lookup the name and address of any phone number owner ' . $area_code->province . $page_description,
			'page_now'     => $page,
			'url'          => '/codes/' . $area_code->area_code,
			'preview_page' => $preview_page,
			'next_page'    => $next_page,
			'last_page'    => $last_page,
			'searched_phones'=>$searched_phones,
			'phones_in_code'=>$phones_in_code,
		] );

		return \Response::view( 'errors.404', array(), 404 );
	}

	public function Code( Request $request ) {
		$area_code              = (int) $request->area_code;
		$sub_code               = (int) $request->sub_code;
		$page                   = (int) abs( $request->page );
		$quality_phones_on_page = 100;
		if ( empty( $page ) ) {
			$page             = 1;
			$page_title       = null;
			$page_description = null;
		} else {
			$page_title       = ' - ' . $page;
			$page_description = ' Page ' . $page;

		}
		if ( empty( $area_code ) || count( str_split( $area_code ) ) != 3 ) {
			return \Response::view( 'errors.404', array(), 404 );
		}
		if ( empty( DB::table( 'phone_code' )->where( 'area_code', '=', $area_code )->count() ) ) {
			return \Response::view( 'errors.404', array(), 404 );
		}
		if ( empty( $sub_code ) || count( str_split( $sub_code ) ) != 3 ) {
			return redirect( '/codes/' . $area_code );
		}
		if ( empty( DB::table( 'phone_code' )->where( 'sub_code', '=', $sub_code )->count() ) ) {
			return redirect( '/codes/' . $area_code );
		}
		$preview_page = $page - 1;
		$next_page    = $page + 1;
		$last_page    = ceil( 1000 / $quality_phones_on_page );

		if ( $page > $last_page ) {
			return redirect( '/code/' . $area_code . '/' . $sub_code );
		}
		$data                = DB::table( 'phone_code' )
		                         ->where( [
			                         [ 'area_code', '=', $area_code ],
			                         [ 'sub_code', '=', $sub_code ],
		                         ] )
		                         ->get()[0];
		$all_sub_code_phones = DB::table( 'phone' )
		                         ->skip( $quality_phones_on_page * ( $page - 1 ) )
		                         ->take( $quality_phones_on_page )
		                         ->get();
		$phones_in_code = DB::table( 'phone_code' )
		                    ->where( 'area_code', '=', $area_code)
		                    ->inRandomOrder()
		                    ->distinct()
		                    ->limit( 18 )
		                    ->get()->toArray();
		$phpnes_sql         = DB::table( 'phone' )->select( 'phone' )
		                        ->inRandomOrder()
		                        ->distinct()
		                        ->limit( 18 )
		                        ->get()->toArray();
		for ($i=0;$i<count($phones_in_code);$i++){
			$phones_in_code[$i]->phone=$phpnes_sql[$i]->phone;
		}
		$searched_phones = DB::table( 'phone_code' )
		                     ->inRandomOrder()
		                     ->distinct()
		                     ->limit( 18 )
		                     ->get()->toArray();
		$phones_s = DB::table( 'phone' )->select( 'phone' )
		              ->inRandomOrder()
		              ->distinct()
		              ->limit( 18 )
		              ->get()->toArray();
		for ($i=0;$i<count($searched_phones);$i++){
			$searched_phones[$i]->phone=$phones_s[$i]->phone;
		}

		return view( 'Code', [
			'title'        => $data->province . ' Lookup Numbers from +1-' . $data->area_code . ' -' . $data->sub_code . '-0000 through +1' . $data->area_code . '-' . $data->sub_code . '-9999 ' . $page_title,
			'description'  => 'Discover the name and address of any telephone owner by checking numbers from 1' . $data->area_code . '' . $data->sub_code . '>0000 through 1' . $data->area_code . '' . $data->sub_code . '>9999' . $page_description,
			'page_now'     => $page,
			'area_code'    => $data->area_code,
			'sub_code'     => $data->sub_code,
			'city'         => $data->city,
			'lat'          => $data->lat,
			'long'         => $data->long,
			'province'     => $data->province,
			'phones'       => $all_sub_code_phones,
			'url'          => '/code/' . $data->area_code . '/' . $data->sub_code,
			'preview_page' => $preview_page,
			'next_page'    => $next_page,
			'last_page'    => $last_page,
			'phones_in_code'    => $phones_in_code,
			'searched_phones'    => $searched_phones,
		] );
	}

	protected function ValidCapca( $request ) {
		if ( Session::get( 'first_number' ) + Session::get( 'second_number' ) == $request->input( 'capcha' ) ) {
			return true;
		} else {
			return false;
		}
	}

	public function SinglePhone( Request $request ) {
		$number = (int) $request->number;
		if ( ! empty( $request->input() ) ) {
			$validation = Validator::make( $request->input(),
				[
					'name'         => 'required|min:3',
					'rate'         => 'between:-5,5|required',
					'call_type'    => 'in:Unknown,Scam,Telemarket,Harassment,Debt collector,Spam,Survey,Positive|required',
					'comment'      => 'min:30|required',
					'phone'        => 'min:4|max:4|required',
					'area_code_id' => 'min:3|max:3|required',
					'sub_code_id'  => 'min:3|max:3|required',
					'capcha'       => 'required|min:1',
				] );
			$validation->after( function ( $validation ) {
				$input = $validation->getData();
				if ( $input['capcha'] != Session::get( 'first_number' ) + Session::get( 'second_number' ) ) {
					$validation->errors()->add( 'capcha', 'Capcha error!' );
				}
			} );
			if ( $validation->fails() ) {
				return redirect( '/number/' . $request->number )->withErrors( $validation )->withInput();
			}
			$coment_save               = new Coments();
			$coment_save->phone        = $request->input( 'phone' );
			$coment_save->area_code_id = $request->input( 'area_code_id' );
			$coment_save->sub_code_id  = $request->input( 'sub_code_id' );
			$coment_save->colltype     = $request->input( 'call_type' );
			$coment_save->rate         = $request->input( 'rate' );
			$coment_save->coment       = $request->input( 'comment' );
			$coment_save->name         = $request->input( 'name' );
			$coment_save->status       = 'confirmed';
			$coment_save->save();

			return redirect( '/number/' . $request->number );
		}
		if ( empty( $number ) ) {
			return \Response::view( 'errors.404', array(), 404 );
		}
		$number = str_split( $request->number );
		if ( count( str_split( $request->number ) ) != 10 ) {
			return \Response::view( 'errors.404', array(), 404 );
		}
		try {
			$area_code = $number[0] . $number[1] . $number[2];
			$sub_code  = $number[3] . $number[4] . $number[5];
			$phone     = $number[6] . $number[7] . $number[8] . $number[9];
			$data      = DB::table( 'phone_code' )
			               ->select( 'sub_code', 'area_code', 'city', 'province', 'country', 'lat', 'long', 'phone', 'timezone' )
			               ->where( [
					               [ 'area_code', '=', $area_code ],
					               [ 'sub_code', '=', $sub_code ],
					               [ 'phone', '=', $phone ]
				               ]
			               )
			               ->crossJoin( 'phone' )
			               ->first();
			if ( empty( $data ) ) {
				return \Response::view( 'errors.404', array(), 404 );
			}


			$title         = '1' . $data->area_code . $data->sub_code . $data->phone . ' | Check phone number +1-' . $data->area_code . '-' . $data->sub_code . '-' . $data->phone . ' - ' . config( 'app.url' );
			$description   = 'Get full information about phone number +1' . $data->area_code . '' . $data->sub_code . '' . $data->phone . '. Find who own number ' . $data->area_code . '-' . $data->sub_code . '-' . $data->phone . ' in ' . $data->city;
			$coments       = DB::table( 'coments' )
			                   ->where( [
				                   [ 'area_code_id', '=', $data->area_code ],
				                   [ 'sub_code_id', '=', $data->sub_code ],
				                   [ 'phone', '=', $data->phone ],
				                   [ 'status', '=', 'confirmed' ]
			                   ] )
			                   ->get();
			$first_number  = rand( 1, 10 );
			$second_number = rand( 1, 10 );
			Session::put( 'first_number', $first_number );
			Session::put( 'second_number', $second_number );
			$phones_in_code = DB::table( 'phone_code' )
			                    ->where( 'area_code', '=', $data->area_code )
			                    ->inRandomOrder()
			                    ->distinct()
			                    ->limit( 18 )
			                    ->get()->toArray();
			$phpnes_sql         = DB::table( 'phone' )->select( 'phone' )
				->where('phone','!=',$data->phone)
			                        ->inRandomOrder()
			                        ->distinct()
			                        ->limit( 18 )
			                        ->get()->toArray();
			for ($i=0;$i<count($phones_in_code);$i++){
				$phones_in_code[$i]->phone=$phpnes_sql[$i]->phone;
			}
			$searched_phones = DB::table( 'phone_code' )
			                     ->inRandomOrder()
			                     ->distinct()
			                     ->limit( 18 )
			                     ->get()->toArray();
			$phones_s = DB::table( 'phone' )->select( 'phone' )
			              ->inRandomOrder()
			              ->distinct()
			              ->limit( 18 )
			              ->get()->toArray();
			for ($i=0;$i<count($searched_phones);$i++){
				$searched_phones[$i]->phone=$phones_s[$i]->phone;
			}
			return view( 'SinglePhone' )->with( [
				'data'          => $data,
				'title'         => $title,
				'description'   => $description,
				'coments'       => $coments,
				'first_number'  => $first_number,
				'second_number' => $second_number,
				'searched_phones' => $searched_phones,
				'phones_in_code' => $phones_in_code,
			] );
		} catch ( Exception $exception ) {
			return \Response::view( 'errors.404', array(), 404 );
		}
	}


	public function test() {
		set_time_limit( 0 );
		$sitemap_arr = [
		];
		$codes       = DB::table( 'phone_code' )
		                 ->distinct()->orderBy( 'area_code' )
		                 ->select( 'area_code' )->get();
		foreach ( $codes as $code ) {
			$sitemap_arr[] = 'codes/' . $code->area_code;
			$sub_code      = DB::table( 'phone_code' )
			                   ->where( 'area_code', '=', $code->area_code )->get();
			foreach ( $sub_code as $value ) {
				$arr[] = $value->area_code . $value->sub_code;
			}
		}
		$i              = 1;
		$n              = 1;
		$head_sitemap   = '<?xml version="1.0" encoding="UTF-8"?><urlset>';
		$footer_sitemap = '</urlset>';
		foreach ( $arr as $value ) {
			for ( $a = 0; $a <= 9; $a ++ ) {
				for ( $b = 0; $b <= 9; $b ++ ) {
					for ( $c = 0; $c <= 9; $c ++ ) {
						for ( $d = 0; $d <= 9; $d ++ ) {
							$phone = '<url><loc>' . config( 'app.url' ) . 'number/' . $value . $a . $b . $c . $d . '</loc></url>';
							$fp    = fopen( "sitemap$n.xml", "a+" );
							if ( $i % 50000 == 0 || $i == 1 ) {
								fwrite( $fp, $head_sitemap . "\r\n" );
							}
							fwrite( $fp, $phone . "\r\n" );
							if ( $i % 49999 == 0 ) {
								fwrite( $fp, $footer_sitemap . "\r\n" );
								$n ++;
							}
							fclose( $fp );
							$i ++;
						}
					}
				}
			}
		}

		dd( $sitemap_arr );


		return view( 'test' )->with( [ 'data' => $fones ] );
	}

	public function Citys( Request $request ) {
		$all_sitys = DB::table( 'phone_code' )
		               ->distinct()->orderBy( 'city' )
		               ->select( 'city' )->get();
		$page      = (int) abs( $request->page );
		if ( empty( $page ) ) {
			$page             = 1;
			$page_title       = null;
			$page_description = null;
		} else {
			$page_title       = $page . ' - ';
			$page_description = ' Page ' . $page;
		}
		$quality_citys_on_page = 100;
		$preview_page          = $page - 1;
		$next_page             = $page + 1;
		$last_page             = ceil( $all_sitys->count() / $quality_citys_on_page );
		$citys                 = DB::table( 'phone_code' )
		                           ->distinct()->orderBy( 'city' )
		                           ->select( 'city' )
		                           ->skip( $quality_citys_on_page * ( $page - 1 ) )
		                           ->take( $quality_citys_on_page )
		                           ->get();

		return View( 'AllCity', [
			'title'        => 'Cities and Towns in Canada - ' . $page_title . config( 'app.url' ),
			'description'  => 'Complete list of all canadian cities and towns at Canada Phone Numbers Database' . $page_description,
			'citys'        => $citys,
			'page_now'     => $page,
			'url'          => '/citys',
			'preview_page' => $preview_page,
			'next_page'    => $next_page,
			'last_page'    => $last_page,
		] );
	}

	public function City( Request $request ) {
		$city = $request->city;
		$page = (int) abs( $request->page );
		if ( empty( $city ) ) {
			return redirect( '/citys' );
		}
		$city = str_replace( '_', ' ', $city );
		if ( empty( DB::table( 'phone_code' )->where( 'city', '=', $city )->count() ) ) {
			return \Response::view( 'errors.404', array(), 404 );
		}
		if ( empty( $page ) ) {
			$page             = 1;
			$page_title       = null;
			$page_description = null;
		} else {
			$page_title = $page . ' - ';;
			$page_description = ' Page ' . $page;
		}
		$quality_phones_on_page = 100;
		$preview_page           = $page - 1;
		$next_page              = $page + 1;
		$last_page              = ceil( DB::table( 'phone' )->count() / $quality_phones_on_page );
		$city_data              = DB::table( 'phone_code' )->where( 'city', '=', $city )->first();
		if ( $page > $last_page ) {
			return redirect( '/city/' . str_replace( ' ', '_', $city_data->city ) );
		}
		$phones      = DB::table( 'phone' )
		                 ->skip( $quality_phones_on_page * ( $page - 1 ) )
		                 ->take( $quality_phones_on_page )
		                 ->get();
		$title       = 'Area Codes | Area codes for ' . $city_data->city . ', Canada - ' . $page_title . config( 'app.name' );
		$description = 'Complete List of ' . $city_data->city . ' area codes. Easy lookup of area codes in ' . $city_data->city . ' or any another City or Town in Canada.' . $page_description;

		return view( 'City', [
			'title'        => $title,
			'description'  => $description,
			'phones'       => $phones,
			'city_data'    => $city_data,
			'page_now'     => $page,
			'url'          => '/city/' . str_replace( ' ', '_', $city_data->city ),
			'preview_page' => $preview_page,
			'next_page'    => $next_page,
			'last_page'    => $last_page,
		] );
	}

	protected function TextProvince( $province ) {
		$text_province = [
			"Alberta"                   => [
				'Alberta is right now utilizing four area codes. Alberta has had two zone code parts and two region code overlay designs, frequently called an overlay complex.',
				'Zone code 403 initially secured Alberta as well as Yukon and parts of the Northwest Territories. In 1997 region code 403 was part, alongside territory code 819, to shape region code 867 which covers Yukon, Northwest Territories and Nunavut. In 1999 territory code 403 was part again to shape zone code 780. In 2008 territory code 587 was put into benefit as a zone code overlay of zone codes 403 and 780. In 2016 zone code 825 was put into benefit as an overlay of region codes 403, 780, and 587.',
				'Today territory code 403 spreads the southern parts of Alberta including Calgary, Airdrie, Banff, Brooks, Canmore, Claresholm, Crowsnest Pass, High River, Medicine Hat, Olds, Lethbridge, Red Deer, Rocky Mountain House and Strathmore. Zone code 780 spreads the northern segments of Alberta including Edmonton, Bonnyville, Camrose, Drayton Valley, Fort McMurray, Fort Saskatchewan, Grande Prairie, Jasper, Lloydminster (Alberta divide), Peace River, Saint Albert, Sherwood Park, and Wetaskiwin. Zone codes 587 and 825 overlay the whole region.',
				'Changes and History of Alberta Area Codes:',
				'01/01/1947',
				'Region code 403 was put into benefit.',
				'10/21/1997',
				'Zone code 403, alongside region code 819, was part to frame region code 867 which serves Nunavut, Northwest Territories and Yukon.',
				'05/18/1999',
				'Zone code 780 was put into benefit. Region code 780 was made from a part of region code 403.',
				'09/19/2008',
				'Territory code 587 was put into benefit. Territory code 587 is an overlay of region codes 403 and 780.',
				'04/09/2016',
				'Territory code 825 was put into benefit. Territory code 825 in as an overlay of region codes 403, 780, and 587.',
			],
			"British_Columbia"          => [
				'British Columbia is as of now served by four area codes. British Columbia has had one zone code split and one territory code overlay plan, regularly called an overlay complex.',
				'Territory code 604 initially secured all of British Columbia. This was adequate for forty-nine years until the point when 1996 when British Columbia experienced adequate development in populace and phone use to require an extra zone code. To take care of the demand territory code 604 was part to shape 250. The development in British Columbia proceeded with particularly in the Greater Vancouver zone, and additionally, Abbotsford and Mission. To take care of this proceeding with demand for new phone numbers zone code 778 was presented as a concentrated overlay of those zones. In 2008 territory code 778 was extended to cover all of zone code 604 and 250.',
				'Changes and History of British Columbia Area Codes:',
				'01/01/1947',
				'Territory code 604 was put into benefit. In 1996 zone code 604 was part to frame region code 250. In 2001 territory code 604 was halfway overlaid with region code 778. In 2008 the overlay was extended to incorporate all of region code 604 and territory code 250.',
				'10/19/1996',
				'Territory code 250 was put into benefit. Territory code 250 was made from a part of zone code 604. In 2008 zone code 250 was overlaid with zone code 778.',
				'11/03/2001',
				'Region code 778 was put into benefit. Territory code 778 is an overlay of region codes 604 and 250. In 2008 the overlay design was extended to cover all of territory codes 604 and 250.',
				'06/01/2013',
				'Zone code 236 was put into benefit. Territory code 236 is an overlay of zone codes 250, 604, and 778. The new overlays are 604/778/236 and 250/778/236.',
			],
			"Manitoba"                  => [
				'Manitoba is as of now utilizing two territory codes. Region code 204 was put into benefit on 01/01/1947 and secured the whole region of Manitoba. Powerful 11/03/12 region code 431 was put into benefit as an overlay of zone code 204. Zone codes 204 and 431 now server the majority of the area of Manitoba. Ten digit dialing ended up required on October 20, 2012.',
				'Ten digit dialing (region code + seven digit number) is vital in the 204/431 overlay since two unique homes in the same geographic territory can have a similar seven digit telephone number however each would have an alternate region code.',
				'Changes and History of Manitoba Area Codes:',
				'01/01/1947',
				'Region code 204 was put into benefit.',
				'11/03/12',
				'Region code 431 was put into benefit as an overlay of region code 204.',
			],
			"New_Brunswick"             => [
				'New Brunswick is at present utilizing one region code. New Brunswick does not use any zone code overlays. Area code 506 covers the majority of the region of New Brunswick.',
				'From 1947 until the point that 1955 New Brunswick used territory code 902. At the point when zone code 902 was set up in 1947 it served the three territories of New Brunswick, Nova Scotia and Prince Edward Island. Newfoundland and Labrador were included 1949 when they joined Canada. In 1955 territory code 902 was part to frame zone code 506 which was relegated to New Brunswick, Newfoundland and Labrador. In 1962 region code 506 was part to frame region code 709 which was doled out to Newfoundland and Labrador. Zone code 506 at that point served New Brunswick only.',
			],
			"Newfoundland_and_Labrador" => [
				'Newfoundland and Labrador is as of now utilizing one zone code. Newfoundland and Labrador does not use any region code overlays, in any case, on November 24, 2018 zone code 879 will be put into benefit as an all administrations overlay of territory code 709. Zone code 709 covers the majority of the territory of Newfoundland and Labrador.',
				'From 1949 until the point that 1955 Newfoundland and Labrador used region code 902. At the point when region code 902 was built up in 1947 it served the three territories of New Brunswick, Nova Scotia and Prince Edward Island. Newfoundland and Labrador were included 1949 when they joined Canada. In 1955 region code 902 was part to frame zone code 506 which was relegated to New Brunswick, Newfoundland and Labrador. In 1962 territory code 506 was part to frame zone code 709 which was doled out to Newfoundland and Labrador.',
				'Changes and History of Newfoundland and Labrador Area Codes:',
				'01/01/1962',
				'Zone code 709 was put into benefit. Region code 709 was made from a part of region code 506.',
				'11/24/2018',
				'Territory code 879 will be put into benefit as a zone code overlay of region code 709.',
			],
			"Northwest_Territories"     => [
				'Northwest Territories is as of now utilizing one zone code. Northwest Territories isn\'t using any region code overlay designs.',
				'Region code 867 was framed in 1997 from a split of zone code 403 and 819. Zone code 403 initially secured Alberta, Yukon and parts of the Northwest Territories. Zone code 819 secured Quebec. In 1997 zone code 403 was part, alongside a segment of territory code 819, to frame region code 867 which covers Yukon, Northwest Territories and Nunavut.',
				'Changes and History of Northwest Territories Area Codes:',
				'10/21/1997',
				'Region code 867 was put into benefit. Region code 867 was made from a part of zone codes 403 and 819.',
			],
			"Nova_Scotia"               => [
				'Nova Scotia is presently utilizing two region codes. Nova Scotia is utilizing a region code overlay plan which comprises of territory code 782 as an overlay of region code 902. Zone codes 902 and 782 cover the whole area of Nova Scotia. Nova Scotia and Prince Edward Island both utilize region codes 902 and 782.',
				'At the point when territory code 902 was set up in 1947 it served the three territories of New Brunswick, Nova Scotia and Prince Edward Island. Newfoundland and Labrador were included 1949 when they joined Canada. In 1955 zone code 902 was part to shape territory code 506 which was relegated to New Brunswick, Newfoundland and Labrador. Zone code 902 at that point served Nova Scotia and Prince Edward Island solely.',
				'Changes and History of Nova Scotia Area Codes:',
				'01/01/1947',
				'Region code 902 was put into benefit.',
				'01/01/1955',
				'Region code 902 was part to frame territory code 506.',
				'11/30/2014',
				'Territory code 782 was put into benefit as an overlay of zone code 902. Successful November 16, 2014 ten digit dialing (territory code + seven digit number) is required in Nova Scotia.',
			],
			"Nunavut"                   => [
				'Nunavut is at present utilizing one region code. Nunavut isn\'t using any region code overlay designs. Zone code 867 spreads the whole region of Nunavut.',
				'Territory code 867 was shaped in 1997 from a split of zone code 403 and 819. Region code 403 initially secured Alberta, Yukon and parts of the Northwest Territories. Region code 819 secured Quebec. In 1997 territory code 403 was part, alongside a segment of zone code 819, to frame region code 867 which covers Yukon, Northwest Territories and Nunavut when it formally isolated from the Northwest Territories in 1999.',
				'Changes and History of Nunavut Area Codes:',
				'10/21/1997',
				'Region code 867 was put into benefit. Region code 867 was made from a part of region codes 403 and 819.',
			],
			"Ontario"                   => [
				'Ontario province is now utilizing fourteen territory codes. Ontario is using five region code overlay designs, regularly called overlay buildings. Ontario as of late executed region code 548 to give numbering help to region codes 226 and 519. Region codes 365 and 437 were executed on 3/25/2013. Territory code 365 is an overlay of zone codes 289 and 905 and zone code 437 is an overlay of zone codes 647 and 416.',
				'Ontario initially had two territory codes when the numbering framework was set up in 1947. By 1953 Ontario experienced adequate development in populace and phone use to require an extra zone codes. To take care of this expansion in demand the two unique zone codes 416 and 613, set up in 1947, were part to shape territory code 519. After four years in 1957 territory codes 613 and 519 were part to frame region code 705. These progressions brought about four region codes being used in Ontario by 1957. In 1962 region code 705 was part to set up zone code 807.',
				'These five region codes were adequate for over 31 years when in 1993 region code 416 was part to frame region code 905. Somewhere in the range of 2001 and 2016 eight more region codes were built up and put into benefit. These progressions brought about the fourteen zone codes being used today.',
				'Changes and History of Ontario Area Codes:',
				'01/01/1947',
				'Zone code 416 was put into benefit. In 1953 territory code 416, alongside zone code 613, was part to shape region code 519. In 1993 region code 416 was part to shape region code 905. In 2001 zone code 416 was overlaid with zone code 647.',
				'01/01/1947',
				'Zone code 613 was put into benefit. In 1953 region code 613, alongside region code 416, was part to frame zone code 519. In 1957 territory code 613, alongside zone code 519, was part to frame region code 705. Zone code 343 is proposed as a zone code overlay of region code 613 viable 05/17/2010.',
				'01/01/1953',
				'Territory code 519 was put into benefit. Territory code 519 was made from a part of region codes 416 and 613. In 1957 zone code 519, alongside zone code 613, was part to frame region code 705. In 2006 territory code 519 was overlaid with region code 226.',
				'01/01/1957',
				'Region code 705 was put into benefit. Zone code 705 was made from a part of zone codes 613 and 519. In 1962 territory code 705 was part to shape region code 807. Region code 249 is proposed as a region code overlay of territory code 705 powerful 03/19/2011.',
				'01/01/1962',
				'Region code 807 was put into benefit. Territory code 807 was made from a part of region code 705.',
				'10/04/1993',
				'Zone code 905 was put into benefit. Zone code 905 was made from a part of region code 416. In 2001 region code 905 was overlaid with region code 289.',
				'03/05/2001',
				'Zone code 647 was put into benefit. Territory code 647 is an overlay of zone code 416.',
				'06/09/2001',
				'Territory code 289 was put into benefit. Zone code 289 is an overlay of territory code 905.',
				'10/21/2006',
				'Territory code 226 was put into benefit. Zone code 226 is an overlay of territory code 519.',
				'05/17/2010',
				'Territory code 343 was put into benefit. Territory code 343 is an overlay of region code 613.',
				'03/19/2011',
				'Territory code 249 was put into benefit as an overlay of zone code 705.',
				'03/25/2013',
				'Region code 365 was put into benefit as an overlay of zone codes 289 and 905.',
				'03/25/2013',
				'Zone code 437 was put into benefit as an overlay of region codes 416 and 647.',
				'06/04/2016',
				'Zone code 548 was put into benefit as an overlay of region codes 226, and 519.',
			],
			"Prince_Edward_Island"      => [
				'Prince Edward Island is as of now utilizing two zone codes. Prince Edward Island uses a region code overlay plan which comprises of region code 782 as an overlay of territory code 902.. Territory codes 902 and 782 cover the whole region of Prince Edward Island. Prince Edward Island and Nova Scotia both utilize zone codes 902 and 782.',
				'At the point when territory code 902 was set up in 1947 it served the three areas of New Brunswick, Nova Scotia and Prince Edward Island. Newfoundland and Labrador were included 1949 when they joined Canada. In 1955 territory code 902 was part to frame region code 506 which was alloted to New Brunswick, Newfoundland and Labrador. Zone code 902 at that point served Prince Edward Island and Nova Scotia solely.',
				'Changes and History of Prince Edward Island Area Codes:',
				'01/01/1947',
				'Zone code 902 was put into benefit.',
				'01/01/1955',
				'Territory code 902 was part to frame zone code 506.',
				'11/30/2014',
				'Territory code 782 was put into benefit as an overlay of region code 902. Compelling November 16, 2014 ten digit dialing (territory code + seven digit number) is required in Prince Edward Island.',
			],
			"Quebec"                    => [
				'Quebec is at present utilizing eight territory codes. Quebec is using four territory code overlay designs, regularly called overlay buildings. Quebec as of late executed region code 873 to give numbering alleviation to territory code 819.',
				'Quebec initially had two territory codes when the numbering framework was built up in 1947. By 1957 Quebec experienced adequate development in populace and phone use to require an extra territory codes. To take care of this expansion in demand region code 514 was part to shape territory code 819. This split brought about three zone codes 418,514 and 819, being used by 1957.',
				'These three territory codes were adequate to meet the numbering needs in Quebec for forty-one years. At that point in 1998 zone code 514 was part again to frame zone code 450. In 2006 and 2008 two territory code overlays were put into benefit. Territory code 438 overlays region code 514 and region code 581 overlays 418.',
				'Today territory code 418 serves the Quebec City which is the capital of Quebec, and also, Chibougamau, Côte-Nord, and Saint-Georges. Region code 514 spreads the Island of Montreal, Île Perrot and Île Bizard. Zone code 819 spreads western Quebec including the National Capital Region, Drumondville, Gatineau, Magog, Rouyn-Noranda, Shawinigan, Sherbrooke, Trois-Rivires, and Victoriaville. Territory code 450 spreads focal southern Quebec including suburbia of Montreal, yet not Montreal itself, and the urban areas of Laval and Longueuil.',
				'Changes and History of Quebec Area Codes:',
				'01/01/1947',
				'Zone code 418 was put into benefit. In 2008 territory code 418 was overlaid with region code 581.',
				'01/01/1947',
				'Territory code 514 was put into benefit. In 1957 zone code 514 was part to frame territory code 819. In 1998 region code 514 was part to frame region code 450. In 2006 territory code 514 was overlaid with zone code 438.',
				'01/01/1957',
				'Territory code 819 was put into benefit. Zone code 819 was made from a part of region code 514. In 1997 territory code 819 was part to frame some portion of region code 867.',
				'06/13/1998',
				'Territory code 450 was put into benefit. Zone code 450 was made from a part of territory code 514.',
				'11/04/2006',
				'Region code 438 was put into benefit. Region code 438 is an overlay of territory code 514.',
				'09/19/2008',
				'Region code 581 was put into benefit. Region code 581 is an overlay of territory code 418.',
				'08/21/2010',
				'Territory code 579 was put into benefit as an overlay of region code 450.',
				'09/15/2012',
				'Territory code 873 was put into benefit as an overlay of region code 819.',
				'11/24/2018',
				'Zone code 367 will be put into benefit as a territory code overlay of zone codes 581 and 418.',
			],
			"Saskatchewan"              => [
				'Saskatchewan is at present utilizing two zone codes. Saskatchewan uses one territory code overlay which comprises of region code 639 as an overlay of zone code 306. Region codes 306 and 639 cover the majority of the area of Saskatchewan.',
				'Changes and History of Saskatchewan Area Codes:',
				'01/01/1947',
				'Territory code 306 was put into benefit.',
				'05/25/13',
				'Region code 639 was put into benefit as an overlay of region code 306.',
				'Ten digit dialing (region code + seven digit number) is essential in the 306/639 overlay since two unique homes in the same geographic region can have a similar seven digit telephone number yet each would have an alternate zone code.',
				'Zone codes 306 and 639 cover the whole territory of Saskatchewan including the bigger urban areas and networks of Estevan, Humboldt, Moose Jaw, North Battleford, Prince Albert, Regina, Saskatoon, Swift Current, Weyburn and Yorkton notwithstanding numerous littler networks all through Saskatchewan.',
			],
			"Yukon_Territory"           => [
				'Yukon is presently utilizing one zone code. Yukon isn\'t using any zone code overlay designs. Region code covers the whole Yukon Territory.',
				'Territory code 867 was framed in 1997 from a split of zone code 403 and 819. Region code 403 initially secured Alberta, Yukon and parts of the Northwest Territories. Territory code 819 secured Quebec. In 1997 zone code 403 was part, alongside a segment of zone code 819, to shape zone code 867 which covers Yukon, Northwest Territories and Nunavut.',
				'Changes and History of Yukon Area Codes:',
				'10/21/1997',
				'Region code 867 was put into benefit. Zone code 867 was made from a part of region codes 403 and 819.',
			],
		];
		if ( key_exists( $province, $text_province ) ) {
			return $text_province[ $province ];
		} else {
			return 'Error Data text';
		}
	}

	public function province( Request $request ) {
		$province = $request->province;
		if ( empty( $province ) ) {
			$data_province = [
				"Alberta"                   => "Edmonton",
				"British_Columbia"          => "Victoria",
				"Manitoba"                  => "Winnipeg",
				"New_Brunswick"             => "Fredericton",
				"Newfoundland_and_Labrador" => "Saint Johns",
				"Northwest_Territories"     => "Yellowknife",
				"Nova_Scotia"               => "Halifax",
				"Nunavut"                   => "Iqaluit",
				"Ontario"                   => "Toronto",
				"Prince_Edward_Island"      => "Charlottetown",
				"Quebec"                    => "Quebec",
				"Saskatchewan"              => "Regina",
				"Yukon_Territory"           => "Whitehorse",
			];

			return view( 'all_province',
				[
					'title'         => 'Canada Provinces and Territories ' . config( 'app.url' ),
					'description'   => 'Full list of all canadian provinces and territories at Canada Phone Numbers Database',
					'data_province' => $data_province,
					'provinces'     => DB::table( 'phone_code' )->select( 'province' )->distinct()->orderBy( 'province' )->get()

				]
			);

			return \Response::view( 'errors.404', array(), 404 );
		}
		$province = str_replace( '_', ' ', $province );
		if ( empty( DB::table( 'phone_code' )->where( 'province', '=', $province )->count() ) ) {
			return \Response::view( 'errors.404', array(), 404 );
		}
		$data_province = DB::table( 'phone_code' )
		                   ->distinct()
		                   ->select( 'area_code' )
		                   ->where( 'province', '=', $province )
		                   ->get();
		$province_val  = DB::table( 'phone_code' )
		                   ->select( 'province' )
		                   ->where( 'province', '=', $province )
		                   ->first();

		return view( 'province',
			[
				'title'         => $province_val->province . ' Area Codes | Area codes for ' . $province_val->province . ', Canada - ' . config( 'app.url' ),
				'description'   => 'Complete List of ' . $province_val->province . ' area codes. Easy lookup of area codes in ' . $province_val->province . ' or any another Province or City.',
				'data_province' => $data_province,
				'province'      => $province_val->province,
				'text_province' => $this->TextProvince( str_replace( ' ', '_', $province_val->province ) ),
			]
		);
	}

	public function privacy() {
		return view( 'privacy',
			[
				'title'       => 'Privacy Policy - Canada Phone Numbers Lookup - ' . config( 'app.url' ),
				'description' => 'Privacy policy of Canada Phone Numbers Database. The purpose of this privacy policy is to tell you what kind of data we collect of our website',
			]
		);
	}
}
