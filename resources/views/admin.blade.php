@extends('templates.base')

@if(!Session::has('login'))
@section('custom-style')
    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            align-items: center;
        }
    </style>
@endsection
@endif

@section('content')
    @if(Session::has('login'))
        @include('layouts.control-panel')
    @else
        {{--<script>--}}
            {{--window.fbAsyncInit = function () {--}}
                {{--FB.init({--}}
                    {{--appId: '389340228150466',--}}
                    {{--autoLogAppEvents: true,--}}
                    {{--xfbml: false,--}}
                    {{--version: 'v2.10'--}}
                {{--});--}}
                {{--FB.login();--}}
            {{--};--}}

            {{--(function (d, s, id) {--}}
                {{--var js, fjs = d.getElementsByTagName(s)[0];--}}
                {{--if (d.getElementById(id)) {--}}
                    {{--return;--}}
                {{--}--}}
                {{--js = d.createElement(s);--}}
                {{--js.id = id;--}}
                {{--js.src = "//connect.facebook.net/en_US/sdk.js";--}}
                {{--fjs.parentNode.insertBefore(js, fjs);--}}
            {{--}(document, 'script', 'facebook-jssdk'));--}}
        {{--</script>--}}
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                @include('forms.login')
            </div>
        </div>
    @endif
@endsection