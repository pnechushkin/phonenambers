@extends('layouts.app')
@section('content')
    <div class="row">
        @if(empty($coments))
            <div class="alert alert-success">
                Все комментарии подтверждены
            </div>
        @else
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Phone</th>
                            <th scope="col">Colltype</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Coment</th>
                            <th scope="col">Name</th>
                            <th scope="col">Created</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($coments as $coment)
                            <tr>
                                <th scope="col">{{$coment->area_code_id.$coment->sub_code_id.$coment->phone}}</th>
                                <th scope="col">{{$coment->colltype}}</th>
                                <th scope="col">{{$coment->rate}}</th>
                                <th scope="col">{{$coment->coment}}</th>
                                <th scope="col">{{$coment->name}}</th>
                                <th scope="col">{{$coment->created_at}}</th>
                                <th scope="col">
                                    @if($coment->status=='new')
                                        <a href="/admin/delated/{{$coment->id}}" class="btn btn-block bg-danger">Delated</a>
                                        <a href="/admin/confirmed/{{$coment->id}}" class="btn btn-block bg-success">Confirmed</a>
                                    @else
                                        <a href="/admin/delated/{{$coment->id}}" class="btn btn-block bg-danger">Delated</a>
                                    @endif
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection