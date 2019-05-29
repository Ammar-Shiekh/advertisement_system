@extends('layouts.app')

@section('title')
    Home
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @switch (Auth::user()->role->name )
                        @case ('publisher')
                            <a href="{{ route('advertisements.index') }}" class="card-link">Advertisements settings</a>
                        @break
                        @case ('administrator')
                            <a href="{{ route('dashboard.advertisements.index') }}" class="card-link">Advertisements settings</a>
                            <a href="{{ route('dashboard.publishers.index') }}" class="card-link">Publishers settings</a>
                        @break
                    @endswitch
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
