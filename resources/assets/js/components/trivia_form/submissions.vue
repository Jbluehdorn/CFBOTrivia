<template>
  <div>
    <div v-if="loading" class="align-center">
      <i class="fa fa-cog fa-spin loading-large"></i>
    </div>
    <div v-else-if="!submissions.length">
      <h4>No submissions yet!</h4>
    </div>
    <div class="table-responsive" v-else>
      <div class="form-group">
        <label>Season</label>
        <select v-model="searchTerm" class="form-control">
          <option value="">All</option>
          <option v-for="season in seasons" :value="season.title">{{season.title}}</option>
        </select>
      </div>
      <table class="table">
        <thead>
          <tr>
            <th>Season</th>
            <th>Question</th>
            <th v-for="index in maxQuestions">{{index}}</th>
            <th>Total</th>
            <th>Percentage</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="submission in filteredSubmissions(submissions)">
            <td>{{submission.season}}</td>
            <td>{{submission.form_title}}</td>
            <td v-for="index in maxQuestions" :class="submission.submitted_answers[index - 1] != null ? (submission.submitted_answers[index - 1].correct ? 'table-success' : 'table-danger') : 'table-danger'">
              <span v-if="submission.submitted_answers[index - 1] != null">
                {{submission.submitted_answers[index - 1].body}}
              </span>
            </td>
            <td>{{calcSubmissionTotal(submission)}}</td>
            <td class="text-right">{{calcSubmissionPercentage(submission) | percentage}}</td>
          </tr>
        </tbody>
      </table>
      <div v-if="seasonLoading" class="align-center">
        <i class="fa fa-cog fa-spin loading-medium"></i>
      </div>
      <div v-show="searchTerm != ''" v-else>
        <h4>Season {{searchTerm}}</h4>
        <table class="table">
          <thead>
            <tr>
              <th>Top {{topScoreAmount}} Scores</th>
              <th>Average Score</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>{{totalScore}}</td>
              <td>{{calcAverageScore()}}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['user', 'seasons'],
  data() {
    return {
      loading: true,
      submissions: {},
      test: ['banana', 'airplane', 'soldier'],
      searchTerm: '',
      seasonLoading: false,
      totalScore: 0,
      topScoreAmount: null
    }
  },
  created() {
    this.loadSubmissions();
    this.getTopScoreAmount();
  },
  watch: {
    searchTerm: function() {
      this.getUserTotalScore();
    }
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

      submission.scoreTotal = total;

      return total;
    },
    calcSubmissionPercentage(submission) {
      let total = this.calcSubmissionTotal(submission);

      let percentage = total / submission.submitted_answers.length;

      submission.scorePercentage = percentage;

      return percentage;
    },
    calcAverageScore() {
      return this.totalScore / (this.submissions.length < this.topScoreAmount ? this.submissions.length : this.topScoreAmount);
    },
    getUserTotalScore() {
      console.log(this.season);
      this.seasonLoading = true;
      let season = this.getSeason();
      console.log(season);

      axios.get('/trivia/getUserTotalScore/' + season.id).then(response => {
        this.totalScore = response.data;
        this.seasonLoading = false;
      }).catch(error => {
        console.log(error);
        this.seasonLoading = false;
      });
    },
    getTopScoreAmount() {
      axios.get('/api/getTopScoreAmount').then(response => {
        this.topScoreAmount = response.data;
      }).catch(error => {
        console.log(error);
      })
    },
    filteredSubmissions() {
      let self = this;

      return this.submissions.filter(function(submission) {
        if(self.searchTerm === '') {
          return true;
        }

        return self.searchTerm === submission.season;
      });
    },
    getSeason() {
      let self = this;
      let foundSeason = {};

      this.seasons.forEach(function(season) {
        if(season.title == self.searchTerm) {
          return foundSeason = season;
        }
      });

      return foundSeason;
    }
  },
  computed: {
    maxQuestions() {
      let questions = 0;

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
