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
    title="Excluir">
        <p class="my-4">Corfima a exclusão?</p>
        <template #modal-footer>
            <div class="w-100">
            <b-button
            class="btn-confirm"
            @click="deletar()"
            >
                Confirmar
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
    show: {default: false},
    selected: {type: Number},
    typeDelete: {type: String},
  },
   data() {
    return {
        dismissSecs: 2,
        dismissCountDown: 0,
        message: ''
    }
  },
  methods: {
    deletar() {
        if(this.typeDelete == 'dimension'){
            axios.delete(`http://localhost:8000/api/delete_dimension/${this.selected}`)
            .then((res) =>{
              if(res.status == 200){
                this.showAlert(true)
              }else{
                this.$emit('changed', res.data)
                this.show = false
                this.showAlert(false)
              }
            })
        }else{
          console.log(this.selected)
             axios.delete(`http://localhost:8000/api/delete_question/${this.selected}`)
            .then((res) =>{
                this.$emit('changed', res.data)
                this.show = false
                this.showAlert(false)
            })
        }
    },
    countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown
    },
    showAlert(error) {
      if(error == true){
        this.variant = 'warning'
        this.message = 'Existem perguntas nessa dimensão!'
        this.dismissCountDown = this.dismissSecs
      }else{
         this.variant = 'success'
        this.message = 'Excluido com sucesso!'
        this.dismissCountDown = this.dismissSecs
      }

    }
  }
}
</script>

<style lang="scss">
@import '@/assets/css/styles.scss';

</style>