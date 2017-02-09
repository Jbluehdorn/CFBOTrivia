@extends('layouts.admin')

@section('content')
    <div class="col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">New Form</h3>
            </div>
            <div class="panel-body">
                <form action="/newForm" method="POST">

                </form>
            </div>
        </div>
    </div>
@endsection