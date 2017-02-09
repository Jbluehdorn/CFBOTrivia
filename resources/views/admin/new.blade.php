@extends('layouts.admin')

@section('title', 'New Form')

@section('content')
    <div class="col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">New Form</h3>
            </div>
            <div class="panel-body">
                <form action="/admin/newForm" method="post">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="ex. Season 1 Week 1: Category"/>
                    </div>
                    <button class="btn btn-primary pull-right">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection