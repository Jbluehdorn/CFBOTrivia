<template>
    <div>
        <strong>Accepted Answers:</strong>
        <span class="answer" v-for="(answer, key) in internalQuestion.answers">{{answer.body}}{{key != internalQuestion.answers.length - 1 ? ',' : ''}} </span>
        <table class="table">
            <thead>
            <tr>
                <th colspan="3"><input type="text" placeholder="Search by Username..." class="form-control" v-model="searchTerm"></th>
                <th><input type="checkbox" v-model="correctHidden"> Hide Correct Answers</th>
                <th>
                    <span v-show="saving">Saving... <i class="fa fa-spin fa-cog"></i></span>
                </th>
            </tr>
            <tr>
                <th>Username</th>
                <th>Answer</th>
                <th class="align-center">Mark Correct</th>
                <th class="align-center">Mark Wrong</th>
                <th class="align-center">Mark Notable</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="answer in filteredAnswers"
                :class="answer.correct? 'table-success' : (answer.notable ? 'table-warning' : 'table-danger')"
                v-show="!answer.correct || !correctHidden">
                <td>{{answer.user.name}}</td>
                <td>{{answer.body}}</td>
                <td class="align-center"><i class="fa fa-check clickable correct" v-on:click="markCorrect(answer)"></i></td>
                <td class="align-center"><i class="fa fa-ban clickable wrong" v-on:click="markWrong(answer)"></i></td>
                <td class="align-center"><i class="fa fa-star clickable notable" v-on:click="markNotable(answer)"></i></td>
            </tr>
            </tbody>
            <tfoot>
            <tr>
                <th class="align-right" colspan="3">Total</th>
                <th class="align-right">Correct</th>
                <th class="align-right">Percentage</th>
            </tr>
            <tr>
                <th class="align-right" colspan="3">{{totalSubmissions}}</th>
                <th class="align-right">{{correctSubmissions}}</th>
                <th class="align-right">{{correctPercentage | percentage}}</th>
            </tr>
            </tfoot>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                internalQuestion: {},
                searchTerm: '',
                orderTerm: 'body',
                orderAsc: true,
                hidden: false,
                saving: false,
                correctHidden: false
            };
        },
        created() {
            this.internalQuestion = this.question;

            this.internalQuestion.submitted_answers.forEach(function(answer) {
               answer.username = answer.user.name;
            });
        },
        props: ['question'],
        methods: {
            markCorrect(answer) {
                this.saving = true;

                axios.post('/admin/markCorrect', {
                    questionID: this.internalQuestion.id,
                    answerBody: answer.body
                }).then(response => {
                    this.internalQuestion = response.data;
                    this.saving = false;
                }).catch(error => {
                    this.saving = false;
                    console.log('Error');
                    console.log(error);
                });
            },
            markWrong(answer) {
                this.saving = true;

                axios.post('/admin/markWrong', {
                    questionID: this.internalQuestion.id,
                    answerBody: answer.body
                }).then(response => {
                    this.internalQuestion = response.data;
                    this.saving = false;
                }).catch(error => {
                    this.saving = false;
                    console.log('Error');
                    console.log(error);
                });
            },
            markNotable(answer) {
                this.saving = true;

                axios.post('/admin/markNotable', {
                    questionID: this.internalQuestion.id,
                    answerBody: answer.body
                }).then(response => {
                    this.internalQuestion = response.data;
                    this.saving = false;
                }).catch(error => {
                    this.saving = false;
                    console.log('Error');
                    console.log(error);
                });
            }
        },
        computed: {
            filteredAnswers() {
                var self = this;
                let result = this.internalQuestion.submitted_answers;
                return result.filter(answer => answer.user.name.toLowerCase().includes(this.searchTerm.toLowerCase()));
            },
            totalSubmissions() {
                var total = 0;

                this.internalQuestion.submitted_answers.forEach(function(question) {
                    total++;
                });

                return total;
            },
            correctSubmissions() {
                var total = 0;

                this.internalQuestion.submitted_answers.forEach(function(question) {
                    if(question.correct) {
                        total++;
                    }
                });

                return total;
            },
            correctPercentage() {
                return this.correctSubmissions / this.totalSubmissions;
            }
        }
    }
</script>