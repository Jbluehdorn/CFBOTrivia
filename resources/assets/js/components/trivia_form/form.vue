<template>
    <div class="col-xs-12 col-sm-8 col-sm-offset-2 trivia-form">
        <div class="panel panel-default" v-if="loading">
            <div class="panel-heading align-center">
                <i class="fa fa-cog fa-spin loading-large"></i>
            </div>
        </div>

        <div class="panel panel-default" v-else>
            <div class="panel-heading" style="padding-bottom: 15px;">
                <h3>
                    {{internalForm.title}}
                    <span v-if="!timeUp"><i class="fa fa-clock-o"></i> {{timeRemaining | time}}</span>
                    <span v-else class="text-danger"><i class="fa fa-times"></i> Times up! {{timeRemaining | time}}</span>
                </h3>
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
                        <h4 v-html="question.body"></h4>
                        <input
                                type="text"
                                class="form-control"
                                placeholder="Enter answer..."
                                v-model="answer"
                                :disabled="timeUp"
                                v-on:keyup.enter="finishQuestion()"
                                autofocus>
                        <div class="form-buttons align-right">
                            <button class="btn btn-primary" v-on:click="finishQuestion()" v-if="!lastQuestion">Next >></button>
                            <button class="btn btn-success" v-on:click="finishQuestion()" v-else>Finish</button>
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
                answer: '',
                timeRemaining: 0,
                timeUp: false,
                timer: null,
                //prevents multiple submissions
                answerSubmitted: false
            }
        },
        props: ['form', 'time'],
        created() {
            this.internalForm = this.form;
            this.timeRemaining = this.time;

            this.nextPageUrl = '/api/getFormQuestions/' + this.internalForm.id;

            this.loading = false;
        },
        methods: {
            finishQuestion() {
                this.loadingQuestion = true;
                if(!this.timeUp) {
                    this.submitAnswer();
                }

                if(this.lastQuestion) {
                    window.location.href = '/formSubmitted';
                } else {
                    this.getNextQuestion();
                }
            },
            submitAnswer() {
                if(this.answer.length && !this.answerSubmitted) {
                    this.answerSubmitted = true;
                    axios.post('/trivia/submitAnswer', {
                        answerBody: this.answer,
                        questionID: this.question.id
                    }).then(response => {
                        console.log(response);
                        this.answerSubmitted = false;
                    }).catch(error => {
                        console.log(error);
                        this.answerSubmitted = false;
                    });
                }
            },
            getNextQuestion() {
                var self = this;
                this.loadingQuestion = true;
                this.stopTimer();

                axios.get(this.nextPageUrl).then(response => {
                    this.nextPageUrl = response.data.next_page_url;
                    if(this.nextPageUrl == null) {
                        this.lastQuestion = true;
                    }

                    this.question = response.data.data[0];

                    this.question.body = this.parseUrl(this.question.body);

                    this.loadingQuestion = false;
                    this.timeRemaining = this.time;
                    this.timeUp = false;
                    this.answer = '';
                    this.startTimer();
                }).catch(error => {
                    console.log(error);
                    this.loadingQuestion = false;
                    this.timeUp = false;
                });
            },
            parseUrl($string) {
                console.log('Parsing...');
                let __urlRegex = /(\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|])/ig;
                let __imgRegex = /\.(?:jpe?g|gif|png)$/i;

                return $string.replace(__urlRegex,function(match){
                        __imgRegex.lastIndex=0;
                        if(__imgRegex.test(match)){
                            let thing = '<img src="'+match+'" class="questionPic" />';
                            console.log(thing);
                            return thing;
                        }
                        else{
                            let thing = '<a href="'+match+'" target="_blank">'+match+'</a>';
                            console.log(thing);
                            return thing;
                        }
                    }
                );
            },
            start() {
                this.getNextQuestion();
                this.started = true;
            },
            updateTimer() {
                this.timeRemaining--;

                if(this.timeRemaining <= 0) {
                    this.stopTimer();
                    this.timeUp = true;
                }
            },
            stopTimer() {
                clearInterval(this.timer);
            },
            startTimer() {
                var self = this;
                if(!this.timeUp) {
                    this.timer = setInterval(function() {
                        self.updateTimer();
                    }, 1000);
                }
            }
        }
    }
</script>