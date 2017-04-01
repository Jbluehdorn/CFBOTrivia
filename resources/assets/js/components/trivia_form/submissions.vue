<template>
    <div>
        <div v-if="loading" class="align-center">
            <i class="fa fa-cog fa-spin loading-large"></i>
        </div>
        <div v-else-if="!submissions.length">
            <h4>No submissions yet!</h4>
        </div>
        <div v-else>
            <table class="table">
                <thead>
                <th>Question</th>
                <th v-for="index in maxQuestions">{{index}}</th>
                <th>Total</th>
                </thead>
                <tbody>
                <tr v-for="submission in submissions">
                    <td>{{submission.form_title}}</td>
                    <td v-for="index in maxQuestions" :class="submission.submitted_answers[index - 1] != null ? (submission.submitted_answers[index - 1].correct ? 'table-success' : 'table-danger') : 'table-danger'">
                        <span v-if="submission.submitted_answers[index - 1] != null">
                            {{submission.submitted_answers[index - 1].body}}
                        </span>
                        <span v-else>
                            No answer
                        </span>
                    </td>
                    <td>{{calcSubmissionTotal(submission)}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['user'],
        data() {
            return {
                loading: true,
                submissions: {},
                test: ['banana', 'airplane', 'soldier']
            }
        },
        created() {
            this.loadSubmissions();
        },
        methods: {
            loadSubmissions() {
                this.loading = true;

                axios.get('/trivia/getAllUserSubmissions').then(response => {
                    this.submissions = response.data;
                    this.loading = false;
                }).catch(error => {
                   console.log(error);
                   this.loading = false;
                });
            },
            calcSubmissionTotal(submission) {
                let total = 0;

                submission.submitted_answers.forEach(answer => {
                    if(answer && answer.correct)
                        total++;
                });

                return total;
            }
        },
        computed: {
            maxQuestions() {
                var questions = 0;

                this.submissions.forEach(function(submission) {
                    if(submission.submitted_answers.length > questions) {
                        questions = submission.submitted_answers.length;
                    }
                });

                return questions;
            }
        }
    }
</script>