@extends('layouts.admin')

@section('title', $form ? $form->title : 'Not Found')

@section('content')

    {{--{{dd(get_defined_vars())}}--}}
    <div class="col-xs-10 col-xs-offset-1">
        @if($form)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">{{$form->title}}</h3>
                </div>
                <div class="panel-body">

                </div>
            </div>
            @foreach($form->questions as $question)
                {{$question->body}}
            @endforeach
        @else
            <h1>Error: Form not found</h1>
        @endif
    </div>
@endsection