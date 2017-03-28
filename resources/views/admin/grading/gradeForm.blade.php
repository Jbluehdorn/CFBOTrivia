@extends('layouts/admin')

@section('title', $form ? 'Grading - ' . $form->title : 'Not Found')

@section('content')
    <div class="col-xs-10 col-xs-offset-1" id="gradingForm">
        <div class="panel panel-default">
            @if(!$form)
                <div class="panel-heading">
                    <h3>ERR: Not Found</h3>
                </div>
            @else
                <div class="panel-heading">
                    <h3>{{$form->title}}</h3>
                </div>
                <div class="panel-body">
                    @foreach($form->questions as $question)
                    <div class="panel panel-default" class="question">
                        <div class="panel-heading">
                            <h5>{{$question->body}}</h5>

                        </div>
                        <div class="panel-body">
                            <strong>Accepted Answers:</strong>
                            @for($i = 0; $i < count($question->answers); $i++)
                                <span class="answer">{{$question->answers[$i]->body}}{{$i != count($question->answers) - 1 ? ',' : ''}}</span>
                            @endfor

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Answer</th>
                                    <th>Mark Correct</th>
                                    <th>Mark Wrong</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($question->submittedAnswers as $answer)
                                    <tr>
                                        <td>{{$answer->User->name}}</td>
                                        <td>{{$answer->body}}</td>
                                        <td><i class="fa fa-check clickable"></i></td>
                                        <td><i class="fa fa-ban clickable"></i></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
