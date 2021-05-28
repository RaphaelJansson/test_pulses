<template>
  <section>
    <modal-confirm
    :show="modalConfirm"
    :selected="selected"
    typeDelete="dimension"
    @changed="callDimensions"
    />
    <modal-create
    :show="modalCreate"
    typeCreate="dimension"
    @changed="callDimensions"/>
    <div class="container" :key="options">
      <div class="header-page">
        <div>
          <h1>Dimensões</h1>
        </div>
        <b-button class="btn-edit" @click="createDimension">Criar Dimensão</b-button>
      </div>
      <div class="body-page">
        <b-form>
          <div v-for="option in options"
          :key="option.id">
            <b-input-group class="mt-3">
              <b-form-input disabled :value="option.name"/>
              <b-input-group-append>
                <b-button class="btn-delete" @click="deleteDimension(option.id)">Deletar</b-button>
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
    ModalConfirm: () => import('@/components/ModalConfirma.vue'),
    ModalCreate: () => import('@/components/ModalCreate.vue')
    },
  data() {
    return {
      modalConfirm: false,
      modalCreate: false,
      selected: null,
      create: 'dimension',
      options: [],
      questions: [],
    }
  },

  mounted() {
    this.callDimensions()
  },
  methods: {
    callDimensions(){
      axios.get("http://localhost:8000/api/dimensions")
      .then((res) =>{
        this.options = res.data
      })
    },
    deleteDimension(value) {
      this.selected = value
      this.modalCreate = false
      this.modalConfirm = true
    },
    createDimension(value) {
      this.selected = value
      this.modalConfirm = false
      this.modalCreate = true
    }
  }
}
</script>

<style lang="scss">
@import '@/assets/css/colors.scss';

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
  }

  .form-control:disabled{
    background: white;
  }

  .btn-edit{
    background: $blue-base;
  }

  .btn-delete{
    background: $red-base;
  }
}

</style>
