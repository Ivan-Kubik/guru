@extends('layouts.app')
@section('content')
    <div class="block_payment">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>{{ $page->title }}</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">{!! $page->content !!}</div>
            </div>
        </div>
    </div>
@endsection
