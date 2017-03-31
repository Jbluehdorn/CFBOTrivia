@extends('layouts.app')

@section('title', $form ? $form->title : 'Err not found')

@section('content')
    <div class="container">
        <div class="row">
            @if($form)
            <trivia-form :form="{{$form}}"></trivia-form>
            @else
                <h1>ERROR: Something went wrong. Please try again later.</h1>
            @endif
        </div>
    </div>
@endsection