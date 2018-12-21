@extends('adminlte::page')

@section('title', $title)
@section('keywords', $keywords)
@section('description', $description)

@section('content_header')
    <h1>{{ $title }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="col-md-4">
                        <p>
                            @if($pic1)
                                <img src="{{ '/'.env('IMAGE_PATH').$pic1 }}" alt="{{ $topic }}"
                                     class="img-responsive img-thumbnail">
                            @endif
                        </p>
                    </div>
                    <div class="col-md-8">
                        <p>{!! $detail !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')

@stop

@section('js')

@stop