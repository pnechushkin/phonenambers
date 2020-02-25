@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h1>Provinces and Territories with capitals</h1>
        </div>
    </div>
    <div class="row text-center">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 province">Flag</div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 province">Province/Territory</div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 province">Capital</div>
    </div>
    @foreach($provinces as $province)
        <div class="row text-center">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 province"><img src="/img/flags/{{str_replace(' ','_',$province->province)}}.gif" alt="{{$province->province}}"></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 province"><a href="/province/{{str_replace(' ','_',$province->province)}}">{{$province->province}}</a></div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 province">
                <a href="/city/{{str_replace(' ','_',$data_province[str_replace(' ','_',$province->province)])}}">
                    {{$data_province[str_replace(' ','_',$province->province)]}}
                </a></div>
        </div>
    @endforeach
    <div class="row">
        <p>The ten regions and three territories of Canada reach out from the Atlantic to the
            Pacific Ocean and north to
            the Arctic. Canada is the world's second biggest nation in complete zone since its
            domains and regions cover
            a region of 3.855 million square miles. The regions have more government duties in
            the elected structure
            than those of the domains.</p>
        <p>The regions and domains of Canada are the sub-national governments inside the
            geological zones of Canada
            under the specialist of the Canadian Constitution. In the 1867 Canadian
            Confederation, three regions of
            British North America—New Brunswick, Nova Scotia and the Province of Canada (which,
            upon Confederation, was
            separated into Ontario and Quebec)— were joined to shape a united settlement,
            turning into a sovereign
            country in the following century. Over its history, Canada's universal fringes have
            changed a few times, and
            the nation has developed from the first four regions to the present ten areas and
            three regions. The ten
            areas are
            <a href="/province/Alberta">Alberta</a>, <a href="/province/British_Columbia">British Columbia</a>, <a
                    href="/province/Manitoba">Manitoba</a>, <a href="/province/New_Brunswick">New
                Brunswick</a>, <a
                    href="/province/Newfoundland_and_Labrador">Newfoundland and Labrador</a>, <a
                    href="/province/Nova_Scotia">Nova Scotia</a>,
            <a href="/province/Ontario">Ontario</a>, <a href="/province/Prince_Edward_Island">Prince
                Edward Island</a>,
            <a href="/province/Quebec">Quebec</a> and <a
                    href="/province/Saskatchewan">Saskatchewan</a>.
            Together, the
            areas and domains make up the world's
            second-biggest nation by territory.</p>
    </div>


@endsection
