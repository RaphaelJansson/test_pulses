import Vuex from 'vuex'

export const state = () => ({
    selectedQuestion: [],
    options: []
  })

  export const mutations = {
    setQuestion(state, payload) {
      state.selectedQuestion = payload
    },
    setOptions(state, payload) {
      state.options = payload
    }
  }
