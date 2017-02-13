<template>
    <div>
        <button class="btn btn-primary" @click="setActive">Set Active</button>
        <ul class="list-unstyled form-editor">
            <li v-for="question in internalForm.questions" class="question" v-if="!question.removed">
                <editable-field v-model="question.body" @remove="remove(question)"></editable-field>
                <ul v-if="question.answers" class="answer" >
                    <li v-for="answer in question.answers" v-if="!answer.removed">
                        <editable-field v-model="answer.body" @remove="remove(answer)"></editable-field>
                    </li>
                    <li>
                        <span class="clickable" @click="addAnswer(question)">Add Answer <i class="fa fa-plus-circle"></i></span>
                    </li>
                </ul>
            </li>
            <li>
                <span class="clickable" @click="addQuestion">Add Question <i class="fa fa-plus-circle"></i></span>
            </li>
        </ul>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.internalForm = this.form;
            console.log('form-editor component initialized');
        },
        props: ['form'],
        data() {
            return {
                internalForm: {}
            }
        },
        watch: {
            //Save form anytime anything changes
            'internalForm': {
                handler:  function () {
                    //TODO: Flesh out save function
                },
                deep: true
            }
        },
        methods: {
            addAnswer(question) {
                question.answers.push({});
            },
            addQuestion() {
                this.internalForm.questions.push({answers:[]});
            },
            remove(entry) {
                entry.removed = true;
                this.$forceUpdate();
            },
            setActive() {
                var self = this;
//                this.$http.post('/admin/setActiveForm', {params: {formId: self.internalForm.id}}).then(response => {
//                    console.log(response);
//                }, error => {
//                    console.log(error);
//                }
                axios.post('/admin/setActiveForm', {
                    formId: self.internalForm.id
                }).then(response => {
                    console.log(response);
                }).catch(error => {
                    console.log(error);
                });

            }
        }
    }
</script>