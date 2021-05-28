<template>
    <div>
        <b-alert
        :show="dismissCountDown"
        dismissible
        fade
        :variant="variant"
        @dismiss-count-down="countDownChanged"
        >
            {{ message }}
        </b-alert>
        <b-modal
        v-model="show"
        :title="typeCreate == 'dimension' ? 'Criar Dimensão' : 'Criar Pergunta'">
            <div v-if="typeCreate == 'dimension'">
                <label class="mr-sm-2">Nome da Dimensão</label>
                <b-input v-model="inputCreate"></b-input>
            </div>
            <div v-else>
                <label class="mr-sm-2">Texto da pergunta</label>
                <b-input v-model="inputCreate"></b-input>
                <label class="mr-sm-2">Dimensão</label>
                <b-form-select v-model="selectedModal" :options="optionsModal"></b-form-select>
            </div>
        <template #modal-footer>
            <div class="w-100">
            <b-button
            class="btn-confirm"
            @click="create()"
            >
                Criar
            </b-button>
            <b-button
                @click="show=false"
            >
                Cancelar
            </b-button>
            </div>
        </template>
        </b-modal>
    </div>
</template>

<script>
import axios from 'axios'

export default {
  props:{
    show: {type: Boolean, default: false},
    typeCreate: {type: String},
    optionsModal: {type: Object}
  },
   data() {
    return {
        inputCreate: '',
        dismissSecs: 2,
        dismissCountDown: 0,
        selectedModal: null,
        variant: '',
        message: ''
    }
  },

  methods: {
    create() {
        if(this.typeCreate == 'dimension'){
            axios.post("http://localhost:8000/api/create_dimension", {name: this.inputCreate})
            .then((res) =>{
                this.$emit('changed', res.data)
                this.show = false
                this.showAlert()
            })
        }else{
            axios.post("http://localhost:8000/api/create_question", {text: this.inputCreate, dimension_id: this.selectedModal})
            .then((res) =>{
                this.$emit('changed', res.data)
                this.show = false
                this.showAlert()
            })
        }
    },
    edit(){
        console.log(this.selectedCreate)
    },
    countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown
    },
    showAlert() {
        this.variant = 'success'
        this.message = 'Criado com sucesso!'
        this.dismissCountDown = this.dismissSecs
    }
  }
}
</script>


<style lang="scss">
@import '@/assets/css/styles.scss';

</style>