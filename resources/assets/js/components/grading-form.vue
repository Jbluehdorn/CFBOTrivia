<template>
    <div>
        <div class="panel panel-default" v-for="question in internalForm.questions">
            <div class="panel-heading">
                <h5>{{question.body}}</h5>
            </div>

            <div class="panel-body">
                <strong>Accepted Answers:</strong>
                <span class="answer" v-for="(answer, key) in question.answers">{{answer.body}}{{key != question.answers.length - 1 ? ',' : ''}} </span>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Answer</th>
                        <th class="align-center">Mark Correct</th>
                        <th class="align-center">Mark Wrong</th>
                        <th class="align-center">Mark Notable</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="answer in question.submitted_answers"
                        :class="answer.correct? 'table-success' : (answer.notable ? 'table-warning' : 'table-danger')">
                        <td>{{answer.user.name}}</td>
                        <td>{{answer.body}}</td>
                        <td class="align-center"><i class="fa fa-check clickable correct"></i></td>
                        <td class="align-center"><i class="fa fa-ban clickable wrong"></i></td>
                        <td class="align-center"><i class="fa fa-star clickable notable"></i></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('grading-form mounted');
        },
        props: ['form'],
        data() {
            return {
                internalForm: {},
                saving: false,
                saveFailed: false,
                saveSuccessful: false,
                created: false
            }
        },
        created() {
            this.internalForm = this.form;
            this.created = true;
        }
    }
</script>