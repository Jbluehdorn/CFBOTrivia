<template>
    <div class="col-xs-8 col-xs-offset-2 trivia-form">
        <div class="panel panel-default" v-if="loading">
            <div class="panel-heading align-center">
                <i class="fa fa-cog fa-spin loading-large"></i>
            </div>
        </div>

        <div class="panel panel-default" v-else>
            <div class="panel-heading">
                <h3>{{internalForm.title}}</h3>
            </div>
            <div class="panel-body">
                <div v-if="!started" class="align-center">
                    <button class="btn btn-success" v-on:click="start()">Start!</button>
                </div>
                <div v-else>
                    <div class="align-center" v-if="loadingQuestion">
                        <i class="fa fa-cog fa-spin loading-medium"></i>
                    </div>
                    <div v-else>
                        <h4>{{question.body}}</h4>
                        <input type="text" class="form-control" placeholder="Answer...">
                        <div class="form-buttons align-right">
                            <button class="btn btn-primary" v-on:click="getNextQuestion()" v-if="!lastQuestion">Next >></button>
                            <button class="btn btn-success" v-else>Finish</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                internalForm: {},
                nextPageUrl: '',
                loading: true,
                loadingQuestion: false,
                question: {},
                started: false,
                lastQuestion: false,
                answer: ''
            }
        },
        props: ['form'],
        created() {
            this.internalForm = this.form;

            this.nextPageUrl = '/api/getFormQuestions/' + this.internalForm.id;

            this.loading = false;
        },
        methods: {
            getNextQuestion() {
                this.loadingQuestion = true;

                axios.get(this.nextPageUrl).then(response => {
                    this.nextPageUrl = response.data.next_page_url;
                    if(this.nextPageUrl == null) {
                        this.lastQuestion = true;
                    }

                    this.question = response.data.data[0];

                    this.loadingQuestion = false;
                }).catch(error => {
                    console.log(error);
                    this.loadingQuestion = false;
                });
            },
            start() {
                this.getNextQuestion();
                this.started = true;
            }
        }
    }
</script>