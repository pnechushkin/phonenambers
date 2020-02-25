@if(!empty($searched_phones))
    <div class="row text-center">
        <h3>Most searched phone numbers</h3>
        <div class="row text-center">
            @foreach($searched_phones as $phone)
                <div class="col-md-2 text-center">
                    <a href="/number/{{$phone->area_code.$phone->sub_code.$phone->phone}}">+1 ({{$phone->area_code}}
                        ) {{$phone->sub_code}}-{{$phone->phone}}</a>
                </div>
            @endforeach
        </div>
    </div>
@endif