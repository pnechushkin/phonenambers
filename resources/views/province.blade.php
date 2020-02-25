@extends('layouts.app')

@section('content')
    <div class="blog-post">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1>{{$province}} area codes and prefixes</h1>
            </div>

            <div>
                <ul class="breadcrumb">
                    <li><a href="/">Main</a></li>
                    <li class="active">{{$province}}</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h2> List of {{$province}} area codes</h2>
            </div>
        </div>
        <div class="row">
            @foreach($data_province as $province)
                <div class="col-md-2 col-lg-2 col-sm-3 col-xs-3 text-center"
                     style="font-weight: bold; font-size: 20px;"><a
                            href="/codes/{{$province->area_code}}">{{$province->area_code}}</a></div>
            @endforeach
        </div>
        <div>
            @foreach($text_province as $text)
                <p>{{$text}}</p>
            @endforeach
        </div>
    </div>
@endsection
