@extends('layouts.app')

@section('title')
    Devices
@endsection

@section('content')
    <h1>Devices</h1>
    @if(Session::has('danger'))
        @php ($message = session('danger'))
        <p class="bg-danger">{{$message}}</p>
    @endif
    @if(Session::has('info'))
        @php ($message = session('info'))
        <p class="bg-info">{{$message}}</p>
    @endif
    @include('includes.table', ['properties'=>App\User::getProperties(), 'items'=>$publishers])
@endsection()