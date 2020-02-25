@extends('layouts.app')

@section('content')
    <div class="row">
        <div>
            <h1>Area Code {{$area_code->area_code}} @if($page_now>1) - Page {{$page_now}} @endif</h1>
        </div>
        <div>
            <ul class="breadcrumb">
                <li><a href="/">Main</a></li>
                <li class="active">{{$area_code->area_code}}</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div>
            <h2>Province: <a
                        href="/province/{{str_replace(' ','_',$area_code->province)}}"> {{$area_code->province}}</a>
            </h2>
            <p><strong>Number Format: </strong> ({{$area_code->area_code}}) xxx-xxxx</p>
            <p><strong>International Number Format: </strong> +1 ({{$area_code->area_code}}) xxx-xxxx</p>
            <p><strong>Time Zone: </strong>{{$area_code->timezone}} UTC</p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 maps">
            <iframe src="https://maps.google.com/maps?q={{$area_code->province}}&z=4&output=embed"
                    height="250" frameborder="0" style="border:0"></iframe>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            @include('parts.MapsAdvertisingBlock')
        </div>
    </div>
    <div class="row">
        <p>Our service will help you if:</p>
        <ul>
            <li>you want to know which phone service provider operates code {{$area_code->area_code}};
            </li>
            <li>you want to know which area is covered by phone code {{$area_code->area_code}};
            </li>
            <li>you want to find all available information about a number in area code {{$area_code->area_code}};
            </li>
            <li>you want to find information about area code area code {{$area_code->area_code}}
                scams.
            </li>
        </ul>
    </div>

    @if($sub_codes)
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Prefix</th>
                        <th scope="col">Primary city</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($sub_codes as $sub_code)
                        <tr>
                            <th><a
                                        href="/code/{{$sub_code->area_code}}/{{$sub_code->sub_code}}">
                                    +1 {{$sub_code->area_code}} {{$sub_code->sub_code}} xxxx</a>
                            </th>
                            <td><a href="/city/{{str_replace(' ','_',$sub_code->city)}}">{{$sub_code->city}}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @include('parts.pagination')
@endsection
