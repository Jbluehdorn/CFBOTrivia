@extends('layouts.app')

@section('title', Auth::User()->name . ' submissions')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>{{Auth::User()->name}}</h3>
                    </div>
                    <div class="panel-body">
                        <submissions-table :user="{{Auth::User()}}" :seasons="{{$seasons}}"></submissions-table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection