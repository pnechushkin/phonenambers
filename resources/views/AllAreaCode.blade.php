@extends('layouts.app')

@section('content')
    <div class="row bread_crumbs">
        <div class="col-sm-12 col-md-9 col-xs-12 col-lg-12">
            <ul class="breadcrumb">
                <li><a href="/">Main</a></li>
                <li>Area Codes</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>Area Codes Scams</h1>
        </div>
    </div>
    <div class="row">
        @foreach($area_code as $area)
            <div class="col-md-2 col-lg-2 col-sm-3 col-xs-3 text-center" style="font-weight: bold; font-size: 20px;"><a
                        href="/codes/{{$area->area_code}}">{{$area->area_code}}</a></div>
        @endforeach
    </div>
    <div class="row">
        <p>Canada at present uses 40 zone codes which are alloted to particular geographic zones in addition to zone
            codes 600 and 622 which are not doled out to a geographic region. The region utilizing the most zone codes
            is Ontario which is utilizing fourteen region codes taken after by Quebec which is utilizing nine territory
            codes. A few different areas share region codes, for example, Nova Scotia and Prince Edward Island which
            utilize territory codes 902 and 782, and additionally, Yukon, Northwest Territories and Nunavut which
            utilize zone code 867. The territory of New Brunswick utilizes just a single zone code which is region code
            506.</p>
        <p>In 2012 two new region codes were set into benefit in Canada. Quebec actualized zone code 873 as an overlay
            of zone code 819 on September 15, 2012 and Manitoba executed region code 431 as an overlay of region code
            204 on November 3, 2012.</p>
        <p>In 2013 four new region codes were set into benefit in Canada. Ontario actualized two new zone codes 437 and
            365 on March 25, 2013. Zone code 437 is an overlay of region codes 416 and 647 and region code 365 is an
            overlay of region codes 905 and 289. Saskatchewan executed territory code 639 as an overlay of region code
            306 on May 25, 2013 and British Columbia actualized zone code 236 as an overlay of region codes 250, 604 and
            778 on June 1, 2013.</p>
    </div>
@endsection
