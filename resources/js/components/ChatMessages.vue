<template>
    <div class="card card-default">
        <div class="card-header">Mach3builders chat</div>
        <div class="card-body">
            <div class="chat">
                <div class="chat-body">
                    <div v-for="(message, i) in messages" :key="i" class="chat-bubble">
                        <strong class="chat-username">{{ message.user.name }}</strong>
                        <div class="chat-message">{{ message.message }}</div>
                    </div>
                </div>

                <div class="input-group mb-3 chat-input-group">
                    <input type="text" class="form-control" placeholder="type a message" v-model="message" @keyup.enter="sendMessage">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" id="button-addon2" @click="sendMessage">Send message</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            user: Object,
        },

        data () {
            return {
                message: '',
                messages: [],
            }
        },

        mounted() {
            this.fetchMessages();

            Echo.private('chat')
                .listen('MessageSent', (e) => {
                    this.messages.push({
                        message: e.message.message,
                        user: e.user
                    });
                });
        },

        methods: {
            fetchMessages() {
                axios.get('/messages')
                    .then((response) => {
                        this.messages = response.data
                    })
            },
            sendMessage() {
                this.messages.push({
                    user: this.user,
                    message: this.message
                })

                axios.post('/messages', {
                    message: this.message,
                })

                this.message = ''
            }
        }
    }
</script>

<style>
.chat {
    font-size: 0.75rem;
}

.chat-bubble {
    padding: 0.5rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.chat-input-group {
    margin-top: 2rem;
}
</style>
