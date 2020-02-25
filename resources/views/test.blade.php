@extends('layouts.app')

@section('content')
<pre>
    {{var_dump($data)}}
</pre>

    {{--@foreach($data as $datum)--}}
        {{--{{$datum}}<br>--}}
    {{--@endforeach--}}

@endsection
