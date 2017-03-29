@extends('layouts/admin')

@section('title', $form ? 'Grading - ' . $form->title : 'Not Found')

@section('content')
    <div class="col-xs-10 col-xs-offset-1" id="gradingForm">
        <div class="panel panel-default">
            @if(!$form)
                <div class="panel-heading">
                    <h3>ERR: Not Found</h3>
                </div>
            @else
                <div class="panel-heading">
                    <h3>{{$form->title}}</h3>
                </div>
                <div class="panel-body">
                    <grading-form :form="{{$form}}"></grading-form>
                </div>
            @endif
        </div>
    </div>
@endsection
