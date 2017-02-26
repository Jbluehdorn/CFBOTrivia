<template>
    <div>
        <span v-if="form.isActive">This is the <strong class="text-success">Active</strong> Form</span>
        <div v-else>
            <span>This is an <strong class="text-danger">Inactive</strong> Form</span> <br>
            <span class="clickable" @click="setActive">Click <strong>Here</strong> to make this form Active</span>
        </div>

        <span v-show="saving"><i class="fa fa-spin fa-cog"></i> Saving...</span>
        <span v-show="saveSuccessful" class="text-success"><i class="fa fa-check"></i> All Changes Saved!</span>
        <span v-show="saveFailed" class="text-danger"><i class="fa fa-exclamation"></i> Save Failed</span>

        <hr>

        <h4>Rules Blurb:</h4>
        <editable-field type="textarea" v-model="internalForm.rules_blurb" @input="setValue(internalForm.rules_blurb, arguments[0])"></editable-field>

        <hr>

        <h4>Questions:</h4>
        <ul class="list-unstyled form-editor">
            <li v-for="question in internalForm.questions" class="question" v-if="question.type != 'destroy'">
                <editable-field type="field" v-model="question.body" @input="setValue(question, arguments[0])" @remove="remove(question)"></editable-field>
                <ul v-if="question.answers" class="answer" >
                    <li v-for="answer in question.answers" v-if="answer.type != 'destroy'">
                        <editable-field type="field" v-model="answer.body" @input="setValue(answer, arguments[0])" @remove="remove(answer)"></editable-field>
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
            console.log('form-editor component initialized');
        },
        created() {
            this.internalForm = this.form;
            this.resetForm();
            this.created = true;
        },
        props: ['form'],
        data() {
            return {
                internalForm: {},
                saving: false,
                saveSuccessful: false,
                saveFailed: false,
                created: false
            }
        },
        methods: {
            addAnswer(question) {
                question.answers.push({type: 'new', body: ''});
            },
            addQuestion() {
                this.internalForm.questions.push({answers:[], type: 'new', body: ''});
            },
            remove(entry) {
                entry.type = 'destroy';
                this.saveForm();
                this.$forceUpdate();
            },
            setValue(entry, value) {
                if(typeof entry !== 'object') {
                    entry = value;
                } else {
                    entry.body = value;
                }
                this.saveForm();
            },
            setActive() {
                axios.post('/admin/setActiveForm', {
                    formId: this.internalForm.id
                }).then(response => {
                    this.internalForm.isActive = true;
                    this.$forceUpdate();
                }).catch(error => {
                    console.log(error);
                });

            },
            saveForm() {
                let self = this;
                this.saving = true;
                this.saveSuccessful = false;
                this.saveFailed = false;
                axios.post('/admin/saveFormChanges', {
                    form: this.internalForm
                }).then(response => {
                    this.saving = false;
                    this.saveSuccessful = true;

                    setTimeout(function() {
                        self.saveSuccessful = false;
                    }, 3000);
                    this.resetForm();
                    console.log(response);
                }).catch(error => {
                    this.saving = false;
                    this.saveFailed = true;
                    setTimeout(function() {
                        self.saveFailed = false;
                    }, 3000);
                    console.log(error);
                });
            },
            //Return the form to update state
            resetForm() {
                this.internalForm.questions.forEach(function(question) {
                    if(question.type !== 'destroy' && question.body !== '')
                        question.type = 'update';
                    question.answers.forEach(function(answer) {
                        if(answer.type !== 'destroy' && answer.body !== '')
                            answer.type = 'update';
                    });
                });
            }
        }
    }
</script>