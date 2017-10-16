@extends('templates.base')

@if(Session::has('login'))
    @include('navbar.admin', ['home' => true])
@endif
@section('content')
    <div class="container-fluid">
        @include('templates.header', ['subtitle' => 'Affordable clothing with high quality'])

        @if(count($items) > 0)
            <div class="row">
                @foreach($items as $item)
                    @include('templates.itemcard')
                @endforeach
            </div>
        @endif
    </div>
@endsection