@extends('layouts.app')

@section('title', $form ? $form->title : 'No active trivia')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                @if(!$form)
                    <div class="panel-heading">
                        <h3>No Active Trivia</h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            There is no active trivia right now. Check back later.
                        </p>
                    </div>
                @else
                <div class="panel-heading">{{$form->title}}</div>

                <div class="panel-body">
                    <h3>Welcome to CFBOTrivia</h3>
                    <strong>Rules:</strong>
                    <br>
                    <ol>
                        <li>You will have <strong>{{$questionTime}}</strong> seconds to answer each question. If the time runs out, your answer will not be submitted.</li>
                        <li>After you answer a question, you will <strong class="text-danger">not</strong> be able to change it, so be sure before you move on to the next question.</li>
                        <li>Gag answers will not be accepted. If the correct answer is "Harvard" we will not accept "Havahd".</li>
                        <li>Do not include extraneous information, your answer in a sentence form, your opinion about the question or your answer, etc.</li>
                    </ol>
                    <strong>This Week:</strong>
                    <p>
                        {{$form->rules_blurb}}
                    </p>

                    <div class="align-center">
                        <a href="/trivia/current" class="btn btn-primary">I understand the rules</a>
                        <a href="/ResetSubmissions" class="btn btn-danger">Reset Submissions</a>
                    </div>
                </div>

                @endif
            </div>
        </div>
    </div>
</div>
@endsection
