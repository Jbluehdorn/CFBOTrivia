/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('vue-paginate', require('vue-paginate'));
Vue.component('form-editor', require('./components/form-editor.vue'));

/*
    Grading components
 */
Vue.component('grading-form', require('./components/grading/grading-form.vue'));
Vue.component('grading-table', require('./components/grading/grading-table.vue'));

/*
    Trivia components
 */
Vue.component('trivia-form', require('./components/trivia_form/form.vue'));

/*
    General Components
 */
Vue.component('modal', require('./components/modal.vue'));
Vue.component('editable-field', require('./components/editable-field.vue'));


Vue.filter('percentage', function(value, decimals) {
    if(!value) {
        value = 0;
    }

    if(!decimals) {
        decimals = 2;
    }

    value = value * 100;
    value = Math.round(value * Math.pow(10, decimals)) / Math.pow(10, decimals);
    value = value + '%';
    return value;
});

Vue.filter('time', function(value) {
   var mins = Math.floor(value / 60);
   var secs = Math.floor(value % 60);

   if(Math.floor(secs / 10) == 0) {
       secs = "0" + secs;
   }

   return mins + ":" + secs;
});

const app = new Vue({
    el: '#app'
});
