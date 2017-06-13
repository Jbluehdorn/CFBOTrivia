<template>
    <div>
        <div class="form-group">
            <label>Filter Season:</label>
            <select v-model="searchTerm" class="form-control">
                <option value="All">All</option>
                <option v-for="season in seasons" :value="season.title">{{season.title}}</option>
            </select>
        </div>
        <table class="table">
            <thead>
            <tr>
                <th>Season</th>
                <th>Name</th>
                <th>Active</th>
                <th>Questions</th>
                <th>Edit</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="form in filteredForms(internalForms)">
                <td>{{form.season.title}}</td>
                <td>{{form.title}}</td>
                <td :class="[form.isActive ? 'success' : 'danger']">{{form.isActive ? 'Active' : 'Inactive'}}</td>
                <td>{{form.questions.length}}</td>
                <td><a :href="'/admin/edit/' + form.id"><i class="fa fa-edit clickable"></i></a></td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('all-forms table loaded...');
        },
        created() {
            this.internalForms = this.forms;
        },
        props: ['forms', 'seasons'],
        data() {
            return {
                internalForms: {},
                searchTerm: 'All'
            }
        },
        methods: {
            filteredForms() {
                var self = this;

                return this.internalForms.filter(function(form) {
                    if(self.searchTerm === 'All')
                        return true;

                    return form.season.title === self.searchTerm;
                });
            }
        }
    }
</script>