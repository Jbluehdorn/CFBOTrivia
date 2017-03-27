@extends('layouts.app')

@section('title', $form->title)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$form->title}}</div>

                <div class="panel-body">
                    <h3>Welcome to CFBOTrivia</h3>
                    <strong>Rules:</strong>
                    <br>
                    <ol>
                        <li>You will have {{$questionTime}} seconds to answer each question</li>
                        <li>After you answer a question you will <strong class="text-danger">not</strong> be able to go back to it so be sure before you hit submit</li>
                        <li>Gag answers will not be accepted. If the correct answer is "Harvard" we will not accept "Havahd"</li>
                        <li>Do not include extraneous information, your answer in a sentence form, your opinion about the question or your answer, etc.</li>
                    </ol>
                    <strong>This Week:</strong>
                    <p>
                        {{$form->rules_blurb}}
                    </p>

                    <button type="button" class="btn btn-primary">I understand the rules</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
