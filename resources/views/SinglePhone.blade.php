@extends('layouts.app')

@section('content')
    <div class="row bread_crumbs">
        <div class="col-sm-12 col-md-9 col-xs-12 col-lg-12">
            <ul class="breadcrumb">
                <li><a href="/">Main</a></li>
                <li><a href="/codes/{{$data->area_code}}/">{{$data->area_code}}</a></li>
                <li><a href="/code/{{$data->area_code}}/{{$data->sub_code}}">{{$data->sub_code}}</a></li>
                <li>+1{{$data->area_code.$data->sub_code.$data->phone}}</li>
            </ul>
        </div>
    </div>
    <div class="row description_number">
        <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12">
            <h1>Phone Number +1-{{$data->area_code}}-{{$data->sub_code}}-{{$data->phone}}</h1>
            <p>We are happy to assist you with getting any telephone number information. For instance, check number {{
                $data->area_code . $data->sub_code . $data->phone }}. The database is dependably up and coming and is
                prepared to display you real data. Additionally you can discover clients remarks here.

                Keeping in mind the end goal to stay away from any negative involvement with telephone number
                misrepresentation, you can utilize our database of telephone numbers in Canada. Our undertaking can
                enable you to discover whose telephone number is shown on your screen. Utilizing our administration you
                can check telephone number by turn around query telephone number +1{{$data->area_code .
                $data->sub_code . $data->phone }}.</p>
        </div>
    </div>
    <div class="row information_number">
        <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12">
            <p><strong>Area Code: </strong> {{$data->area_code}}</p>
            <p><strong>Province: </strong> {{$data->province}}</p>
            <p><strong>City: </strong> {{$data->city}}</p>
            <p><strong>Time Zone: </strong>{{$data->timezone}} UTC</p>
            <p>International Phone</p>
            <ul>
                <li>+1{{$data->area_code.$data->sub_code.$data->phone}}</li>
                <li>+1({{$data->area_code}}) {{$data->sub_code}}-{{$data->phone[0].$data->phone[1]}}
                    -{{$data->phone[2].$data->phone[3]}}</li>
                <li>{{$data->area_code}}-{{$data->sub_code}}-{{$data->phone}}</li>
                <li>+1({{$data->area_code}}){{$data->sub_code.$data->phone}}</li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 maps">
            <iframe src="https://maps.google.com/maps?q={{$data->lat}},{{$data->long}}&z=15&output=embed" width="80%"
                    height="250" frameborder="0" style="border:0"></iframe>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
            @include('parts.MapsAdvertisingBlock')
        </div>
    </div>
    @if(!empty($coments))
        <div class="row">
            <div class="col-sm-12 col-md-12 col-xs-12 col-lg-12">
                <h2>Recent comments</h2>
                @foreach($coments as $coment)
                    @php
                        if ($coment->rate == 0){
                        $class = 'alert alert-warning';
                         $class = null;
                        } elseif ($coment->rate < 0){
                       $class = 'alert alert-danger';
                        } elseif ($coment->rate > 0){
                        $class = 'alert alert-info';
                        }else {
                        $class = null;
                        }
                    @endphp
                    <div class="{{$class}}">
                        <p><strong>{{$coment->name}}</strong>, {{$coment->created_at}}</p>
                        <p>
                            <strong>Number: </strong>{{'+1 (' .$coment->area_code_id . ') ' . $coment->sub_code_id . '-' . $coment->phone}}
                        </p>
                        {{--<p><strong>Call type: </strong> {{$coment->colltype}}</p>--}}
                        {{--<p><strong>Rating: </strong>{{$coment->rate}}</p>--}}
                        <p>{{$coment->coment}}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <h3>Add comment</h3>
    <form class="form-horizontal" role="form" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input hidden name="phone" value="{{$data->phone}}">
        <input hidden name="area_code_id" value="{{$data->area_code}}">
        <input hidden name="sub_code_id" value="{{$data->sub_code}}">
        <div class="form-group required ">
            <label for="name" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Your name: </label>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @if($errors->first('name'))
                    <input type="text" class="form-control alert alert-danger focus" name="name" id="name"
                           value="{{old('name')}}" required autofocus>
                    {{$errors->first('name')}}
                @else
                    <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}" required>
                @endif
            </div>
        </div>
        {{--<div class="form-group required ">--}}
        {{--<label for="rate" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Rate:</label>--}}
        {{--<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">--}}
        <input type="hidden" class="form-control" id="rate" name="rate" value="0"
               required>
        {{--<div class="btn-toolbar">--}}
        {{--<button type="button" class="btn btn-danger rate_btn" value="-5">-5</button>--}}
        {{--<button type="button" class="btn btn-danger rate_btn" value="-4">-4</button>--}}
        {{--<button type="button" class="btn btn-danger rate_btn" value="-3">-3</button>--}}
        {{--<button type="button" class="btn btn-danger rate_btn" value="-2">-2</button>--}}
        {{--<button type="button" class="btn btn-danger rate_btn" value="-1">-1</button>--}}
        {{--<button type="button" class="btn btn-warning rate_btnrate_btn active" value="0">0</button>--}}
        {{--<button type="button" class="btn btn-primary rate_btn" value="1">1</button>--}}
        {{--<button type="button" class="btn btn-primary rate_btn" value="2">2</button>--}}
        {{--<button type="button" class="btn btn-primary rate_btn" value="3">3</button>--}}
        {{--<button type="button" class="btn btn-primary rate_btn" value="4">4</button>--}}
        {{--<button type="button" class="btn btn-primary rate_btn" value="5">5</button>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
        {{--<label for="call_type" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Call type: </label>--}}
        <input type="hidden" class="form-control" id="call_type" name="call_type"
               value="Unknown" required>
        {{--<div class="btn-toolbar col-lg-12 col-md-12  col-sm-12 col-xs-12">--}}
        {{--<button type="button" class="btn btn-warning call_type_brn active" value="Unknown">Unknown</button>--}}
        {{--<button type="button" class="btn btn-danger call_type_brn" value="Scam">Scam</button>--}}
        {{--<button type="button" class="btn btn-danger call_type_brn" value="Telemarket">Telemarket--}}
        {{--</button>--}}
        {{--<button type="button" class="btn btn-danger call_type_brn" value="Harassment">Harassment--}}
        {{--</button>--}}
        {{--<button type="button" class="btn btn-danger call_type_brn" value="Debt collector">Debt collector--}}
        {{--</button>--}}
        {{--<button type="button" class="btn btn-danger call_type_brn" value="Spam">Spam</button>--}}
        {{--<button type="button" class="btn btn-danger call_type_brn" value="Survey">Survey</button>--}}
        {{--<button type="button" class="btn btn-primary call_type_brn" value="Positive">Positive</button>--}}
        {{--</div>--}}
        {{--</div>--}}
        <div class="form-group ">
            <label for="comment" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">Your comment:</label>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @if($errors->first('comment'))
                    <textarea class="form-control alert alert-danger focus" rows="3" id="comment" name="comment"
                              required autofocus>{{old('comment')}}</textarea>
                    {{$errors->first('comment')}}
                @else
                    <textarea class="form-control" rows="3" id="comment" name="comment"
                              required>{{old('comment')}}</textarea>
                @endif
            </div>
        </div>
        <div class="form-group ">
            <label class="col-lg-12 col-md-12 col-sm-12 col-xs-12" for="capcha">How much {{$first_number}}
                + {{$second_number}}</label>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                @if($errors->first('capcha'))
                    <input type="number" step="1" class="form-control alert alert-danger focus" id="capcha"
                           name="capcha"
                           required autofocus>
                    {{$errors->first('capcha')}}
                @else
                    <input type="number" step="1" min="1" class="form-control" id="capcha" name="capcha"
                           required>
                @endif
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-md-10 col-sm-11 col-xs-11 col-lg-offset-2 col-md-offset-2 col-sm-offset-1 col-xs-offset-1">
                <input class="btn btn-primary" type="submit" value="Add">
            </div>
        </div>
    </form>
    <div class="row">

    </div>
    <div class="row"></div>

@endsection