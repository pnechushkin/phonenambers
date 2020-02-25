@if(!empty($phones_in_code))
    <div class="row text-center">
        <h3>Telephone numbers with the same dialing code</h3>
        <div class="row">
        @foreach($phones_in_code as $phone)
            <div class="col-md-2 text-center">
                <a href="/number/{{$phone->area_code.$phone->sub_code.$phone->phone}}">+1 ({{$phone->area_code}}
                    ) {{$phone->sub_code}}-{{$phone->phone}}</a>            </div>
        @endforeach
        </div>
    </div>
@endif