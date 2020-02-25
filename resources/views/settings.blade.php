@extends('layouts.app')
@section('content')
    <div class="row">
    @if (count($errors) > 0)
        <!-- Список ошибок формы -->
            <div class="alert alert-danger">
                <strong>Упс! Что-то пошло не так!</strong>
                <br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(!empty($massage))
            <div>
                {{$massage}}
            </div>
        @endif
        <div>
            <form class="form-horizontal" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <input type="email" name="email"
                           value="@if(!empty(old('email'))){{ old('email') }}@else{{Auth::user()->email}}@endif">
                    <label>E-mail</label>
                </div>
                <div class="form-group">
                    <a href="/admin/settings/ResetPassword" onclick="return window.confirm('Вы уверены?')">Я хочу сбросить свой пароль</a>
                </div>
                <div class="form-group">
                    <input type="password" name="OldPassword" value="">
                    <label>Старый пароль</label>
                </div>
                <div class="form-group">
                    <input type="password" name="NewPassword" value="">
                    <label>Новый пароль</label>
                </div>
                <div class="form-group">
                    <input type="password" name="ConfirmPassword" value="">
                    <label>Подтвердите новый пароль</label>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
@endsection