@if(!empty($RandomComments))
    <h3>Last reviews</h3>

    @foreach($RandomComments as $RandomComment)
        @php(extract($RandomComment))
        <div class="{{$class}}" style='border-bottom:1px solid black;'>
           <span class="border border-dark">
               <p><strong>{{$name}}</strong>, {{$created_at}}</p>
            <p><strong>Number: </strong><a href="{{$phone_href}}">{{$phone_text}}</a></p>
            {{--<p><strong>Call type: </strong> {{$colltype}}</p>--}}
               {{--<p><strong>Rating: </strong>{{$rate}}</p>--}}
            <p>{{$coment}}</p>
               </span>
        </div>
    @endforeach
@endif