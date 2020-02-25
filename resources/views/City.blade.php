@extends('layouts.app')

@section('content')
    <div class="row">
        <div>
            <h1>{{$city_data->city}} Area Codes and Prefixes @if($page_now>1) - Page {{$page_now}} @endif</h1>
        </div>
    </div>
    <div class="row ">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 maps">
            <iframe src="https://maps.google.com/maps?q={{$city_data->lat}},{{$city_data->long}}&z=10&output=embed"
                    width="80%"
                    height="250" frameborder="0" style="border:0"></iframe>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            @include('parts.MapsAdvertisingBlock')
        </div>
    </div>
    <div class="row">
        <p><strong>Time Zone: </strong>{{$city_data->timezone}} UTC</p>
        <p>
            {{$city_data->city}} area codes can be difficult to perceive while getting a get from away. Truth be told,
            you presumably
            think that its truly useless to retain such ostensible things when there's greater fish to sear in your
            everyday life. Give our query a chance to telephone number in
            {{$city_data->city}} database deal with this pointless cerebral pain for you and in the meantime give you
            genuine
            feelings of serenity knowing who is calling you.
        </p>
    </div>
    <div class="row">
        <h2>List of {{$city_data->city}} Phone Codes</h2>
        <p>
            Once you've distinguished the
            {{$city_data->city}} territory code important to you, enable us to burrow significantly more profound for
            you by
            recognizing whether the six-number
            {{$city_data->city}} telephone code is related with a business, government element, or person.
            {{$city_data->city}} telephone numbers don't need to be such a riddle when you have the correct asset next
            to
            you. By utilizing our administration, you will never be laden with neurosis and uneasiness,
            pondering who will be on the opposite end of the line.
        </p>
    </div>

    @if($phones)
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Phone</th>
                        <th>Primary city</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($phones as $phone)
                        <tr>
                            <th><a
                                        href="/number/{{$city_data->area_code.$city_data->sub_code.$phone->phone}}">
                                    +1 {{$city_data->area_code}} {{$city_data->sub_code}} {{$phone->phone}}</a></th>
                            <td><a href="/city/{{str_replace(' ','_',$city_data->city)}}">{{$city_data->city}}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    <div>
        <nav class="text-center">
            <ul class="pager">
                @if($page_now>1)
                    <li><a href="{{$url}}"><<</a></li>
                    <li><a href="{{$url}}/{{$preview_page}}"><</a></li>
                @endif
                @php($nambers_beefore = [])
                @php($nambers_after = [])
                @for($b=$page_now-1; $b>0;$b--)
                    @if($b>$page_now-10 &&$b%10!==0)
                        @php($nambers_beefore[]=$b)
                    @endif
                @endfor
                @for($a=$page_now+1; $a<=$last_page;$a++)
                    @if($a<$page_now+10 &&$a%10!==0  )
                        @php($nambers_after[]=$a)
                    @endif
                @endfor
                @for($i=1;$i<=$last_page;$i++)
                    @if(in_array($i,$nambers_beefore))
                        <li><a href="{{ $url }}/{{$i}}">{{ $i}}</a></li>
                        @continue
                    @endif
                    @if($i==$page_now)
                        <li class="active"><a href="{{$url}}/{{$i}}">{{ $i }}</a></li>
                        @continue
                    @endif
                    @if($i%10===0)
                        <li><a href="{{ $url }}/{{$i}}">{{ $i}}</a></li>
                        @continue
                    @endif
                    @if(in_array($i,$nambers_after))
                        <li><a href="{{ $url }}/{{$i}}">{{ $i}}</a></li>
                        @continue
                    @endif
                @endfor
                @if($next_page < $last_page )
                    <li><a href="{{$url}}/{{$next_page}}">></a></li>
                    <li><a href="{{$url}}/{{$last_page}}">>></a></li>
                @endif
            </ul>
        </nav>
    </div>
    <div>
        <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- canada -->
        <ins class="adsbygoogle"
             style="display:block"
             data-ad-client="ca-pub-6745501291018582"
             data-ad-slot="7173274369"
             data-ad-format="auto"
             data-full-width-responsive="true"></ins>
        <script>
            (adsbygoogle = window.adsbygoogle || []).push({});
        </script>

    </div>
@endsection
