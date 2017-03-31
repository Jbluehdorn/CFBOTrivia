<template>
    <div>
        <div class="panel panel-default" v-for="question in internalForm.questions">
            <div class="panel-heading">
                <h5>
                    {{question.body}}
                    <span v-on:click="toggleQuestion(question)" class="clickable pull-right"><i class="fa" :class="question.hidden ? 'fa-plus' : 'fa-minus'"></i></span>
                </h5>

            </div>

            <div class="panel-body" v-show="!question.hidden">
                <grading-table :question="question"></grading-table>
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
                created: false
            }
        },
        created() {
            this.internalForm = this.form;

            this.internalForm.questions.forEach(function(question) {
               question.hidden = false;
            });

            this.created = true;
        },
        methods: {
            toggleQuestion(question) {
                question.hidden = !question.hidden;
                this.$forceUpdate();
            }

        },
        computed: {

        }
    }
</script>