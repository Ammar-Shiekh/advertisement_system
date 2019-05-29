@extends('layouts.app')

@section('title')
    Advertisements
@endsection

@section('content')
    <h1>Advertisements</h1>
    @if(Session::has('danger'))
        @php ($message = session('danger'))
        <p class="bg-danger">{{$message}}</p>
    @endif
    @if(Session::has('info'))
        @php ($info = session('info'))
        <p class="bg-info">An advertisement has been {{$info['action']}}</p>
    @endif
    @include('includes.table', ['properties'=>App\Advertisement::getAdminProperties(), 'items'=>$advertisements])
@endsection()