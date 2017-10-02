<template>
  <div class="col-xs-12">
      <div class="align-center col-xs-12" v-if="loading">
        <i class="fa fa-spin fa-spinner loading-medium"></i>
      </div>
      <div class="panel panel-default" v-else>
          <div class="panel-heading">
              <h3 class="panel-title">Reports</h3>
          </div>
          <div class="panel-body">
              <div class="control-group">
                  <label for="">Season:</label>
                  <select class="form-control" v-model="selectedSeason">
                      <option :value="season" v-for="season in seasons" :key="season.id">{{season.title}}</option>
                  </select>
              </div>
          </div>

          <hr>

          <table class="table table-responsive">
              <thead>
                  <tr>
                      <th>Username</th>
                      <th>Score</th>
                  </tr>
              </thead>
              <tbody>
                  <tr v-for="report in orderedReports" :key="report.id">
                      <td>{{report.name}}</td>
                      <td>{{report.score}}</td>
                  </tr>
              </tbody>
          </table>
      </div>
  </div>
</template>

<script>
import swal from 'sweetalert';
import _ from 'lodash';

export default {
    data() {
        return {
            loading: false,
            reportsLoading: false,
            reports: null,
            seasons: [],
            selectedSeason: {}
        }
    },

    mounted() {
        this.load();
    },

    methods: {
        load() {
            this.loading = true;

            axios.get('/api/seasons').then(response => {
                this.seasons = response.data;
                this.selectedSeason = this.seasons[0];
            }).catch(error => {
                console.log(error.data);
                swal('Error!', 'Seasons failed to load', 'error')
            });

            this.loading = false;
        },
        loadReports() {
            this.reportsLoading = true;

            axios.get('/api/reports/' + this.selectedSeason.id).then(response => {
                    this.reports = response.data;
                }).catch(error => {
                    console.log(error.data);
                    swal('Error!', 'Reports failed to load', 'error');
                });

            this.reportsLoading = false;
        }
    },

    watch: {
        selectedSeason: function() {
            this.loadReports();
        }
    },

    computed: {
        orderedReports() {
            return _.orderBy(this.reports, 'score');
        }
    }
}
</script>