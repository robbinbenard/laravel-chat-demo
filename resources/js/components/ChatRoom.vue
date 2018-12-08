<template>
    <div class="row">
        <div class="col-4">
            <div class="card card-default">
                <div class="card-header">Users Online</div>
                <div class="list-group list-group-flush" v-if="users.length">
                    <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                        v-for="(user, index) in users" :key="index">
                        <span>{{ user.name }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <div class="card chat">
                <div class="card-header">{{ room.name }}</div>
                <div class="card-body chat-messages pb-0" ref="messages">
                    <div v-for="message in messages" :key="message.id" class="chat-message">
                        <div class="user-name">Robbin</div>
                        <div>{{ message.message }}</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="input-group chat-input-group mt-0">
                        <input type="text" class="form-control" placeholder="Type a message" v-model="newMessage" @keyup.enter="sendMessage">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" @click="sendMessage">Send</button>
                        </div>
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
        room: Object,
    },

    data () {
        return {
            users: [],
            newMessage: '',
            messages: [],
        }
    },

    mounted () {
        this.fetchMessages()

        Echo.join(`rooms.${this.room.id}`)
            .here((users) => {
                this.users = users;
            })
            .joining((newUser) => {
                this.users.push(newUser)
            })
            .leaving((leavingUser) => {
                const user = this.users.find(u => u.id == leavingUser.id)
                this.$delete(this.users, this.users.indexOf(user))
            })
            .listen('MessageSent', (e) => {
                this.messages.push(e.message)
            });
    },

    methods: {
        fetchMessages () {
            axios.get(`/messages/${this.room.id}`).then((response) => {
                this.messages = response.data
            })
        },

        sendMessage() {
            axios.post(`/messages/${this.room.id}`, {
                message: this.newMessage
            })
            .then((response) => {
                this.messages.push(response.data);
                this.newMessage = ''
            })
        }
    },

    watch: {
        messages () {
            this.$nextTick(() => {
                console.log(this.$refs.messages.scrollTop)
                this.$refs.messages.scrollTop
                    = this.$refs.messages.scrollHeight
            })
        }
    }
}
</script>

<style>
.chat {
    height: 400px;
}

.chat-messages {
    overflow: auto;
}

.chat-message {
    padding: 0.25rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}
</style>
