@extends('layouts.app')


@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <ul class="breadcrumb">
                <li><a href="/">Main</a></li>
                <li><a href="/codes/{{$area_code}}">{{$area_code}}</a></li>
                <li>{{$sub_code}}</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div>
            <h1>Check any number from +1{{$area_code}}
                {{$sub_code}} 0000 to +1 {{$area_code}}
                {{$sub_code}} 9999 @if($page_now>1) - Page {{$page_now}} @endif</h1>
            <p>Main city: <a href="/city/{{str_replace(' ','_',$city)}}">{{$city}}</a> </p>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 maps">
            <iframe src="https://maps.google.com/maps?q={{$lat}},{{$long}}&z=10&output=embed" width="80%"
                    height="250" frameborder="0" style="border:0"></iframe>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            @include('parts.MapsAdvertisingBlock')
        </div>
    </div>
    @if($sub_code)
        <table class="table">
            <thead>
            <tr>
                <th style="width: 35%">Number</th>
                <th >Last coment</th>
            </tr>
            </thead>
            <tbody>
            @foreach($phones as $code)
                        <tr>
                            <th scope="row"><a href="/number/{{$area_code.$sub_code.$code->phone}}">
                                    +1 ({{$area_code}}) {{$sub_code}} - {{$code->phone}}
                                </a></th>
                            @if (App\Coments::GetComent ($area_code,$sub_code,$code->phone))
                                <td>{{App\Coments::GetComent ($area_code,$sub_code,$code->phone)->coment}}</td>
                            @else
                                <td>No coment yet</td>
                            @endif
                        </tr>
            @endforeach
            </tbody>
        </table>
    @endif
    @include('parts.pagination')
@endsection
