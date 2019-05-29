@extends('layouts.app')

@section('title')
    Advertisements
@endsection

@section('content')
    <div style="align-items: center;" class="d-flex">
        <h1>Advertisements</h1>
        <a href="{{ route('advertisements.create') }}" class="ml-auto">Create new</a>
    </div>
    @if(Session::has('danger'))
        @php ($message = session('danger'))
        <p class="bg-danger">{{$message}}</p>
    @endif
    @if(Session::has('info'))
        @php ($info = session('info'))
        <p class="bg-info">An advertisement has been {{$info['action']}}</p>
    @endif
    @include('includes.table', ['properties'=>App\Advertisement::getProperties(), 'items'=>$advertisements])
@endsection()