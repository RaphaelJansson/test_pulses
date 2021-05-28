<template>
  <section>
    <b-alert
        :show="dismissCountDown"
        dismissible
        fade
        :variant="variant"
        @dismiss-count-down="countDownChanged"
        >
            {{ message }}
        </b-alert>
    <div class="container">
      <div class="header-page">
        <div>
          <h1>Editar Pergunta</h1>
        </div>
      </div>
    <div class="body-page">
        <label class="mr-sm-2">Texto da pergunta</label>
        <b-input v-model="inputEdit"></b-input>
        <label class="mr-sm-2">Dimensão</label>
        <b-form-select v-model="selected" :options="this.$store.state.options"></b-form-select>
            <div class="w-100" style="margin-top: 10px;">
                <b-button
                class="btn-confirm"
                @click="edit()"
                >
                Editar
                </b-button>
                <b-button @click="$router.go(-1)">Cancelar</b-button>
            </div>
        </div>
    </div>
  </section>
</template>

<script>
import axios from 'axios'

export default {
  data() {
    return {
        inputEdit:'',
        selected: 0
    }
  },

  mounted() {
    this.callQuestions()
  },
  methods: {
    callQuestions(){
        this.inputEdit = this.$store.state.selectedQuestion.text
        this.selected = this.$store.state.selectedQuestion.dimension_id
    },
    edit(){
        axios.put(`http://localhost:8000/api/put_question/${this.$store.state.selectedQuestion.id}`, {text: this.inputEdit, dimension_id:this.selected, show: this.$store.state.selectedQuestion.show})
        .then((res) =>{
            this.$emit('changed', res.data)
            this.showAlert()
        })
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/css/colors.scss';
@import '@/assets/css/styles.scss';

body{
  background: grey;
}

.container {
  margin: 0 auto;
  min-height: 100vh;

  .header-page{
    display: flex;
    padding: 20px;
    width: 100%;

  }

  .body-page{
    padding: 20px;
    background: white;
    -webkit-box-shadow: 10px 10px 5px -4px rgba(0,0,0,0.75);
    -moz-box-shadow: 10px 10px 5px -4px rgba(0,0,0,0.75);
    box-shadow: 10px 10px 5px -4px rgba(0,0,0,0.75);
  }

  .form-control:disabled{
    background: white;
  }
}

</style>
