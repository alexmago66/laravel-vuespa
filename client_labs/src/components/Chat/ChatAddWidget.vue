<template>
  <div id="chat-add-widget">
    <form v-on:submit.prevent="handleAddChat()">
      <div class="form-group">
        <input type="text" class="form-control" v-model="message" placeholder="Digita il tuo messsaggio qui">
      </div>
    </form>
  </div>
</template>

<script>
import {mapState} from 'vuex'
import Pusher from 'pusher-js'
export default {
  created () {
    this.pusher = new Pusher('893d71d850f63757905b', {
      encrypted: true,
      cluster: 'eu'
    })
    let that = this
    this.channel = this.pusher.subscribe('chat_channel')
    this.channel.bind('chat_saved', function (data) {
      that.$emit('incoming_chat', data)
    })
    this.$on('incoming_chat', function (chatMessage) {
      this.incomingChat(chatMessage)
    })
  },
  computed: {
    ...mapState({
      chatStore: state => state.chatStore,
      userStore: state => state.userStore
    })
  },
  data () {
    return {
      message: null,
      pusher: null,
      channel: null
    }
  },
  methods: {
    handleAddChat () {
      if (this.message !== null) {
        const tokenData = JSON.parse(window.localStorage.getItem('authUser'))
        let postData = {
          'sender_id': tokenData.id,
          'receiver_id': this.chatStore.currentChatUser.id,
          'chat': this.message
        }
        this.$store.dispatch('addNewChatToConversation', postData).then(response => {
          this.message = null
          let element = document.getElementById('chat-widget-wrapper')
          element.scrollIntoView(false)
        })
      }
    },
    incomingChat (chatMessage) {
      if (this.chatStore.currentChatUser.id === chatMessage.mesage.sender_id) {
        if (chatMessage.message.receiver.email === this.userStore.email) {
          this.$store.dispatch('newIncomingChat', chatMessage.message).then(response => {
            let element = document.getElementById('chat-widget-wrapper')
            element.scrollIntoView(false)
          })
        }
      }
    }
  }
}
</script>

<style lang="scss">
@import './../../assets/css/variables.scss';

</style>
