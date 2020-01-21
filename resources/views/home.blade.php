@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{asset('css/dashforge.dashboard.css')}}">
@endsection

@section('header')
x
@endsection

@section('body')
<div class="content content-fixed">
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

                        You are in!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection