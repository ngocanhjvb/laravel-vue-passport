<template>
    <div class="chat-layout">
        <div class="chat-layout-container">
<!--            <div class="user-count">-->
<!--                <h3>User count: </h3>-->
<!--            </div>-->
            <div class="title">
                <h1>Chat Room</h1>
            </div>
            <div class="list-messages">
                <div class="message" v-for="message in list_messages">
                    <chat-item :message="message"></chat-item>
                </div>
            </div>
            <div class="input-section">
                <input type="text" v-model="message" class="input-el" placeholder="Enter some message..." @keyup.enter="sendMessage">
                <button @click="sendMessage">Send</button>
            </div>
        </div>
    </div>
</template>

<script>
    import ChatItem from './ChatItem.vue'
    export default {
        components: {
            ChatItem
        },

        data() {
            return {
                message: '',
                list_messages: []
            }
        },

        created() {
            this.loadMessage();
            Echo.channel('chatroom')
                .listen('MessagePosted', (data) => {
                    // console.log(data)
                    // if (data.message.user_id == this.$root.currentUserLogin.id) {
                    //     let message = data.message
                    //     message.user = data.user
                    //     this.list_messages.push(message)
                    // }

                    this.list_messages.push({
                        message: data.message.message,
                        created_at: data.message.created_at,
                        user: data.user
                    })


                })
        },

        methods: {
            loadMessage() {
                this.$store.dispatch('getMessages')
                    .then(res => {
                        this.list_messages = res.data
                    })
            },
            sendMessage() {
                axios.post('api/messages', {
                    message: this.message
                })
                    .then(response => {
                        this.list_messages.push({
                            message: this.message,
                            created_at: new Date().toJSON().replace(/T|Z/gi, ''),
                            user: this.$root.currentUserLogin
                        })
                        this.message = ''
                    })
                    .catch(error => {
                    })
            }
        }
    }
</script>

<style lang="scss" scoped>
    .chat-layout {
        border: solid 1px #ddd;
        border-radius: 3px;
        padding: 20px;
        .chat-layout-container {
            .user-count {
                float: right;
            }
            .list-messages {
                .message{
                    padding: 5px 0;
                }
            }
            .input-section {
                .input-el {
                    width: 100%;
                    filter: hue-rotate(45deg);
                    font-weight: bold;
                    background-color: transparent;
                    border: 0;
                    border-bottom: 1px solid #404040;
                    outline: none;
                    overflow: visible;
                    font-size: 100%;
                    line-height: 1.15;
                    &:focus {
                        border-bottom: 1px solid #e400ff;
                    }
                }
            }
        }
    }
</style>
