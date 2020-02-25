@extends('layouts.app')

@section('content')
    <div class="row text-center">
        <h1>List of Cities and Towns @if($page_now>1) - Page {{$page_now}} @endif</h1>
    </div>
    <div class="row">
        @foreach ($citys as $city)
            <div class="col-lg-2 col-md-2 col-sm-4 col-xs-4 text-center citys">
                <a href="/city/{{str_replace(' ','_',$city->city)}}">{{$city->city}}</a>
            </div>
        @endforeach

    </div>
    @include('parts.pagination')
    <div class="row">
        <p>Canada is a country with snappy advancement of the masses. It is basically accumulated in broad urban
            networks. The most fundamental among them is the capital of the country, Ottawa. It is organized on the
            lovely bank of the Ottawa River. 33% of its masses is relatives of English and French laborers. Before the
            colonization the Ottawa region was an Indian trading center. The name of the city begins from the Indian
            word implying "trade". For a long time Ottawa was a stow away trading center. The suburbs of the city house
            unmistakable mechanical creation lines: electronic undertakings, sustenance taking care of preparing plants,
            paper industrial facilities and others. Ottawa is known as a city of expansions. There are more than 20
            associates in the city. Ottawa is acclaimed for its walks, around which around a million of tulips grow in
            spring.</p>
        <p>Toronto, one of the greatest urban zones, is the home of driving banks and associations. It is the
            significant current focal point of the country. Toronto is a port on Lake Ontario, one of the Great
            Lakes.</p>
        <p>Another titanic port of Canada is Montreal, masterminded on the St Lawrence River. More than 5000 load ships
            go to that port every year. Three schools are masterminded in the city. It is moreover one of the shopping
            and social focal points of the country. Vancouver is a garden city. It is an astoundingly lovely city, which
            lies between snow-topped mountains and an ocean gulf in the west of Canada. It is the greatest port on the
            Pacific float and the point of convergence of Canadian trade.</p>

    </div>

@endsection
