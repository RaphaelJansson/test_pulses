<template>
  <section>
    <modal-create
    :show="modalCreate"
    create="question"
    :optionsModal="options"
    typeDelete="question"
    @changed="callQuestions"/>
    <modal-confirm
    :show="modalConfirm"
    typeDelete="question"
    :selected="selectedQuestion"
    @changed="callQuestions"
    />
    <div class="container">
      <div class="header-page">
        <div>
          <h1>Teste</h1>
        </div>
        <div>
          <NuxtLink to="/dimensions">
            <b-button style="background-color:white; color:black">Dimensões</b-button>
          </NuxtLink>
          <b-button class="btn-edit" @click="modalCreate = !modalCreate">Criar Pergunta</b-button>
        </div>
      </div>
      <div class="body-page">
        <b-form>
          <b-input-group>
            <label class="mr-sm-2">Filtros</label>
            <b-form-select v-model="selected" :options="options" @change="filterItens"></b-form-select>
          </b-input-group>
          <div v-for="question in questions"
          :key="question.id"
          class="questions">
            <b-form-checkbox
              v-model="question.show"
              @change="changeStatus(question)"
            />
            <b-input-group :prepend="question.dimension" class="mt-3">
              <b-form-input disabled :value="question.text"/>
              <b-input-group-append>
                <NuxtLink to="/edit">
                  <b-button class="btn-edit" @click="editQuestion(question)">Editar</b-button>
                </NuxtLink>
                <b-button class="btn-delete" @click="deleteQuestion(question.id)">Deletar</b-button>
              </b-input-group-append>
            </b-input-group>
          </div>
        </b-form>
      </div>
    </div>
  </section>
</template>

<script>
import axios from 'axios'

export default {
  components:{
    ModalCreate: () => import('@/components/ModalCreate.vue'),
    ModalConfirm: () => import('@/components/ModalConfirma.vue')
  },
  data() {
    return {
      modalCreate: false,
      modalConfirm: false,
      selected: 0,
      selectedQuestion: '',
      options: [],
      questions: []
    }
  },

  mounted() {
    this.callQuestions()
  },
  methods: {
    filterItens(){
      axios.get(`http://localhost:8000/api/dimensions/${this.selected}`)
      .then((res) =>{
        console.log(res)
        let listQuestions = []
        res.data.questions.forEach(question => {
            if(!question.deleted_at){
            question.dimension = res.data.name
            listQuestions.push(question)
          }
        });
        this.questions = listQuestions
      })
    },
    changeStatus(value){
      axios.put(`http://localhost:8000/api/put_question/${value.id}`, {text: value.text, dimension_id: value.dimension_id, show: value.show})
        .then((res) =>{
            this.$emit('changed', res.data)
            this.showAlert()
        })
    },
    callQuestions(){
    this.selected = 0
     axios.get("http://localhost:8000/api/dimensions")
      .then((res) =>{
        let newOptions = []
        let listQuestions = []
        res.data.forEach(option => {
          newOptions.push({value: option.id, text: option.name })
          if (option.questions.length){
             option.questions.forEach(question => {
              if(!question.deleted_at){
                question.dimension = option.name
                listQuestions.push(question)
              }
            });
          }
        });
        this.options = newOptions
        this.questions = listQuestions
        this.$store.commit('setOptions', newOptions)
      })
    },
    editQuestion(value){
      this.$store.commit('setQuestion', value)
    },
    deleteQuestion(value) {
      this.selectedQuestion = value
      this.modalCreate = false
      this.modalConfirm = true
    },
    createQuestion(value) {
      this.selected = value
      this.modalCreate = true
      this.modalConfirm = false
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
    justify-content: space-between;
    align-items: center;
  }

  .body-page{
    padding: 20px;
    background: white;
  }

  .form-control:disabled{
    background: white;
  }

  .btn-delete{
    background: $red-base;
  }
}

.questions{
  display: flex;
  align-items: center;
}

</style>
