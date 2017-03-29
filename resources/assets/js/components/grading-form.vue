<template>
    <div>
        <div class="panel panel-default" v-for="question in internalForm.questions">
            <div class="panel-heading">
                <h5>{{question.body}} <span v-on:click="toggleQuestion(question)" class="clickable pull-right"><i class="fa" :class="question.hidden ? 'fa-plus' : 'fa-minus'"></i></span></h5>
            </div>

            <div class="panel-body" v-show="!question.hidden">
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
                        <td class="align-center"><i class="fa fa-check clickable correct" v-on:click="markCorrect(question, answer)"></i></td>
                        <td class="align-center"><i class="fa fa-ban clickable wrong" v-on:click="markWrong(question, answer)"></i></td>
                        <td class="align-center"><i class="fa fa-star clickable notable" v-on:click="markNotable(question, answer)"></i></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="align-right" colspan="3">Total</th>
                        <th class="align-right">Correct</th>
                        <th class="align-right">Percentage</th>
                    </tr>
                    <tr>
                        <th class="align-right" colspan="3">{{calcTotalSubmissions(question)}}</th>
                        <th class="align-right">{{calcCorrectSubmissions(question)}}</th>
                        <th class="align-right">{{calcCorrectPercentage(question) | percentage}}</th>
                    </tr>
                    </tfoot>
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
                created: false,
                clicks: 0
            }
        },
        created() {
            this.internalForm = this.form;
            this.created = true;

            this.internalForm.questions.forEach(function(question) {
               question.hidden = false;
            });
        },
        methods: {
            toggleQuestion(question) {
                question.hidden = !question.hidden;
                this.$forceUpdate();
            },
            markCorrect(question, answer) {
                var self = this;
                this.saving = true;

                axios.post('/admin/markCorrect', {
                    questionID: question.id,
                    answerBody: answer.body
                }).then(response => {
                    this.saving = false;
                    this.saveSuccessful = true;
                    this.saveFailed = false;

                    this.internalForm.questions.forEach(function(question, index, questions) {
                        if(question.id == response.data.id) {
                            questions[index] = response.data;
                            self.$forceUpdate();
                        }
                    });
                }).catch(error => {
                    this.saving = false;
                    this.saveFailed = true;
                    this.saveSuccessful = false;

                    console.log('Error');
                    console.log(error);
                });
            },
            markWrong(question, answer) {
                var self = this;
                this.saving = true;

                axios.post('/admin/markWrong', {
                    questionID: question.id,
                    answerBody: answer.body
                }).then(response => {
                    this.saving = false;
                    this.saveSuccessful = true;
                    this.saveFailed = false;

                    this.internalForm.questions.forEach(function(question, index, questions) {
                        if(question.id == response.data.id) {
                            questions[index] = response.data;
                            self.$forceUpdate();
                        }
                    })
                }).catch(error => {
                    this.saving = false;
                    this.saveFailed = true;
                    this.saveSuccessful = false;

                    console.log('Error');
                    console.log(error);
                });
            },
            markNotable(question, answer) {
                var self = this;
                this.saving = true;

                axios.post('/admin/markNotable', {
                    questionID: question.id,
                    answerBody: answer.body
                }).then(response => {
                    this.saving = false;
                    this.saveSuccessful = true;
                    this.saveFailed = false;

                    this.internalForm.questions.forEach(function(question, index, questions) {
                        if(question.id == response.data.id) {
                            questions[index] = response.data;
                            self.$forceUpdate();
                        }
                    })
                }).catch(error => {
                    this.saving = false;
                    this.saveFailed = true;
                    this.saveSuccessful = false;

                    console.log('Error');
                    console.log(error);
                });
            },
            calcTotalSubmissions(question) {
                var total = 0;

                question.submitted_answers.forEach(function(question) {
                   total++;
                });

                return total;
            },
            calcCorrectSubmissions(question) {
                var total = 0;

                question.submitted_answers.forEach(function(question) {
                   if(question.correct) {
                       total++;
                   }
                });

                return total;
            },
            calcCorrectPercentage(question) {
                return this.calcCorrectSubmissions(question) / this.calcTotalSubmissions(question);
            }
        }
    }
</script>