@extends('layouts.admin')

@section('title', $form ? $form->title : 'Not Found')

@section('content')
    {{--
    This all needs to be change to Vue rather than a blade engine.
    --}}
    <div class="col-xs-10 col-xs-offset-1">
        @if($form)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="panel-title">{{$form->title}}</h2>
                </div>
                <div class="panel-body">
                    <form-editor :form="{{$form}}"></form-editor>
                </div>
            </div>
        @else
            <h1>Error: Form not found</h1>
        @endif
    </div>
@endsection