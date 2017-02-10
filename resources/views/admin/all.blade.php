@extends('layouts.admin')

@section('title', 'All')

@section('content')
    <div class="col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">All Forms</h3>
            </div>
            <div class="panel-body">
                <ul class="list-unstyled">
                    @foreach($forms as $form)
                        <li><a href="/admin/edit/{{$form->id}}">{{$form->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection