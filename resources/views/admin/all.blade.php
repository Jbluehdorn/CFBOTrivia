@extends('layouts.admin')

@section('title', 'All')

@section('content')
    <div class="col-xs-10 col-xs-offset-1">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">All Forms</h3>
            </div>
            <div class="panel-body table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Active</th>
                        <th>Questions</th>
                        <th>Edit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($forms as $form)
                        <tr>
                            <td>{{$form->title}}</td>
                            @if($form->isActive)
                            <td class="success"><strong>Active</strong></td>
                            @else
                            <td class="danger">Inactive</td>
                            @endif
                            <td>{{count($form->questions)}}</td>
                            <td><a href="/admin/edit/{{$form->id}}"><i class="fa fa-edit clickable"></i></a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection