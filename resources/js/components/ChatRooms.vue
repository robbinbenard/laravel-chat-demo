<template>
    <div class="card">
        <h5 class="card-header">Rooms</h5>
        <div class="list-group list-group-flush" v-if="rooms.length">
            <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                v-for="(room, index) in rooms" :key="index" @click="joinRoom(room)">
                <span>{{ room.name }}</span>
                <button @click.stop="deleteRoom(index)" class="btn btn-sm btn-outline-danger">delete</button>
            </div>
        </div>
        <div class="card-body">
           <div class="input-group chat-input-group mt-0">
                <input type="text" class="form-control" placeholder="Room name" v-model="newRoom" @keyup.enter="createRoom">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="button" @click="createRoom">Create room</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            rooms: [],
            newRoom: '',
            currentRoom: null,
        }
    },

    mounted () {
        this.fetchRooms();

        Echo.private('rooms')
            .listen('RoomCreated', (e) => {
                this.rooms.push(e.room);
            })
            .listen('RoomDeleted', (e) => {
                let room = this.rooms.find(room => room.id == e.room.id);
                this.$delete(this.rooms, this.rooms.indexOf(room))
            });
    },

    methods: {
        fetchRooms () {
            axios.get('/rooms/all')
                .then(response => {
                    this.rooms = response.data
                });
        },

        createRoom () {
            axios.post('/rooms', {
                name: this.newRoom
            }).then(response => {
                this.rooms.push(response.data);
                this.newRoom = ''
            })
        },

        joinRoom (room) {
            location.href = `/rooms/${room.id}`
        },

        deleteRoom (index) {
            axios.delete(`/rooms/${this.rooms[index].id}`).then(response => {
                this.$delete(this.rooms, index)
            });
        }
    }
}
</script>

