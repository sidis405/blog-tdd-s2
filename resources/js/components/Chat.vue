<template>
    <div class="card"  style="height: 90vh">
        <div class="card-header">
            Chat
        </div>
        <div class="card-body">
            <p v-for="message in messages">
                <i>{{ message.user.name }}</i>
                <span>{{ message.body }}</span>
            </p>
        </div>
        <div class="card-footer">
            <div class="form-group">
                <input type="text" class="form-control" v-model="userMessage" placeholder="Write something" @keyup.enter="sendMessage">
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        data(){
            return {
                messages: null,
                userMessage: null
            }
        },

        mounted(){
            this.getAllMessages()

            Echo.private('chat')
            .listen('.NewChatMessage', (e) => {
                this.messages.push(e.message)
            })
            .whisper('typing', {
                name: 'FOO'
            })
            .listenForWhisper('typing', (e) => {
                    console.log(e.name + 'is typing');
            });
        },

        methods: {
            sendMessage(){
                axios.post('/messages', {body: this.userMessage}).then((response) => {
                    this.getAllMessages()
                    this.userMessage = null
                })

            },

            getAllMessages(){
                axios.get('/messages').then((response) => {
                    this.messages = response.data.messages
                })
            }
        }
    }
</script>
