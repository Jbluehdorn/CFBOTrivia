@extends('layouts.admin')

@section('title', 'All')

@section('content')
    <div class="col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">All Forms</h3>
            </div>
            <div class="panel-body">
                @foreach($forms as $form)
                    {{$form->title}}
                @endforeach
            </div>
        </div>
    </div>
@endsection