@extends('layouts.app')

@section('title', 'Unauthorized Access')

@section('content')
    <div class="col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h1 style="color: #c00"><i class="fa fa-ban"></i> Unauthorized Access</h1>
            </div>
            <div class="panel-body">
                <p>Sorry, you are not authorized to access that page</p>
            </div>
        </div>
    </div>
@endsection