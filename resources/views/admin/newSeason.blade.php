@extends('layouts.admin')

@section('title', 'New Season')

@section('content')
    <div class="col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">New Season</h3>
            </div>
            <div class="panel-body">
                <form action="/admin/newSeason" method="post">
                    {{csrf_field()}}

                    <div class="form-group col-xs-12">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Ex. 3">
                    </div>

                    <button class="btn btn-primary pull-right" type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection