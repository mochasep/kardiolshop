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
        <div class="container h-100">
            <div class="row h-100 align-items-center justify-content-center">
                @include('forms.login')
            </div>
        </div>
    @endif
@endsection