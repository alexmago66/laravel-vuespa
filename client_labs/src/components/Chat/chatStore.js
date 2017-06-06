import Vue from 'vue'
import {
  userListUrl,
  getHeader,
  getUser,
  getUserConversationUrl,
  saveChatMessageUrl
} from './../../config'

const state = {
  userList: {},
  currentChatUser: null,
  conversation: null
}

const mutations = {
  SET_USER_LIST (state, userList) {
    state.userList = userList
  },
  SET_CURRENT_CHAT_USER (state, user) {
    state.currentChatUser = user
  },
  SET_CONVERSATION (state, conversation) {
    state.conversation = conversation
  },
  ADD_CHAT_TO_CONVERSATION (state, chat) {
    state.conversation.push(chat)
  }
}

const actions = {
  setUserList: ({commit}, userList) => {
    return Vue.http.get(userListUrl, {headers: getHeader()}).then(response => {
      if (response.status === 200) {
        commit('SET_USER_LIST', response.data)
        return response.data
      }
    })
  },
  setCurrentChatUser: ({commit}, user) => {
    let postData = {
      id: user.id,
      authId: getUser()
    }
    return Vue.http.post(getUserConversationUrl, postData, {headers: getHeader()}).then(response => {
      commit('SET_CURRENT_CHAT_USER', user)
      commit('SET_CONVERSATION', response.body.data)
    })
  },
  addNewChatToConversation: ({commit}, postData) => {
    return Vue.http.post(saveChatMessageUrl, postData, {headers: getHeader()}).then(response => {
      commit('ADD_CHAT_TO_CONVERSATION', response.body.data)
    })
  },
  newIncomingChat: ({commit}, message) => {
    commit('ADD_CHAT_TO_CONVERSATION', message)
  }
}

export default {
  state, mutations, actions
}
