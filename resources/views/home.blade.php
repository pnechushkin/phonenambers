@extends('layouts.app')

@section('content')

    <div class="blog-post home">
        <h1 class="blog-post-title">Reverse Phone Number Lookup Database</h1>
        <p>We have arranged the database of all Canada telephone numbers for you. The principle motivation behind this
            database is to give you solid data about Canadian telephone numbers. The database is dependably up and
            coming and is prepared to give you real information. Here you can discover any data concerning region codes:
            take a gander at the zone codes guide or utilize Canada zone codes list. </p>
        <p>For your benefit, we offer you zone codes: </p>
        <p>recorded by area;</p>
        <p>recorded in numeric request. </p>
        <p>Likewise, you can utilize seek by number or hunt by city.</p>
        <h2>Canada Area Codes</h2>
        <div class="row maps">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 maps">
                <iframe src="https://maps.google.com/maps?q=Canada&z=2&output=embed" height="300" frameborder="0" style="border:0"></iframe>
            </div>
        </div>
        <div class="row text-center"><h2>Toll-free Area Codes</h2></div>
        <div class="row text-center">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h3><a href="/codes/800" title="Area code 800">800 Area Code</a></h3>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <h4><a href="/codes/833" title="Area code 833">833 Area Code</a></h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <h4><a href="/codes/844" title="Area code 844">844 Area Code</a></h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <h4><a href="/codes/855" title="Area code 855">855 Area Code</a></h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <h4><a href="/codes/866" title="Area code 866">866 Area Code</a></h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <h4><a href="/codes/877" title="Area code 877">877 Area Code</a></h4>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <h4><a href="/codes/888" title="Area code 888">888 Area Code</a></h4>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <table class="table ">
                    <thead>
                    <tr>
                        <th colspan="2"><h3>Canadian Area Codes Listed by Province </h3></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($Provinces as $Province=>$Codes)
                        <tr>
                            <td><a href="/province/{{str_replace(' ','_',$Province)}}">{{$Province}}</a></td>
                            <td>
                                @foreach($Codes as $code)
                                    <p><a href="/codes/{{$code}}">{{$code}}</a></p>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <table class="table ">
                    <thead>
                    <tr>
                        <th colspan="2"><h3> Canadian Area Codes Listed by Number </h3></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($Numbers  as $Number)
                        <tr>
                            <td><a href="/codes/{{$Number->area_code}}">Area code {{$Number->area_code}}</a></td>
                            <td><a href="/province/{{str_replace(' ','_',$Number->province)}}">{{$Number->province}}</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <P>These days telephone cheats are boundless around the globe. Whenever you can get a call from obscure number.
            Be that as it may, in what manner would fraudsters be able to become more acquainted with your telephone
            number? They can do it by means of: </P>
        <P>informal organizations (individuals compose everything about themselves on the Internet);</P>
        <P>online overviews;</P>
        <P>different destinations where you share your number;</P>
        <P>phishing destinations that resemble on-line stores. </P>
        <P>Telephone fraudsters utilize distinctive foundations for call. They can state that you win lottery prize or
            that they're gathering information. Some of the time fraudsters can present themselves as radio staff,
            delegates of understood organizations, even your portable administrators or bank agents. They can send you a
            message guaranteeing themselves as your relatives who have changed their telephone numbers. </P>
        <P>At any rate, they will attempt to cheat cash out of your pocket. Some telephone fraudsters can frighten you
            that your relatives or companions are in a bad position and they require your money related help. Moreover,
            you can get messages from your "administrator" who'll request that you affirm your telephone number by
            sending SMS. Some telephone fraudsters will shakedown and debilitate you. </P>
        <P>Keeping in mind the end goal to dodge such negative understanding, you can utilize our database of phone
            numbers in Canada with territory code discoverer and telephone number discoverer. Our task can assist you
            with struggling against fraudsters. In any case, we don't ensure that our number database can help in all
            cases. In any case, it can enable you to discover whose telephone number is shown on your screen.</P>
        <P>Utilizing our administration you can stay away from phone misrepresentation because of invert phone query. We
            offer you to make a phone number query for nothing. We give you a chance to make a pursuit by city or
            number. To make a hunt by city or by number, enter a 10-digit telephone number or the city in the crates
            above.</P>
        <P>Canadian telephone number invert query is extremely advantageous administration that will assist you with
            checking a particular telephone number and get a line on it. In addition, because of invert call query it is
            conceivable to get data concerning location of telephone proprietor. Consequently, you will have the
            capacity to discover area by telephone number and discover address by telephone number.</P>
        <P>You can likewise encourage your relatives, your companions and other individuals to discover the fraudsters
            in the event that you give a criticism on a particular number and leave a remark. It will help an
            extraordinary measure of individuals not to fall into the trap of telephone fraudsters. Fare thee well and
            utilize the Canadian region codes list.</P>
    </div>
@endsection
