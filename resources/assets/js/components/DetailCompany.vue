<template>
    <div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Job</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(user,index) in users" :key="user.id">
                <td>{{ parseInt(index) + 1}}</td>
                <td>{{user.name}}</td>
                <td>{{user.email}}</td>
                <td>{{ user.job === null ? '' : user.job.name }}</td>
                <td v-show="$gate.isAdminOrAuthor()">
                    <a href="#" @click="accept(user.id,index)">
                        <i class="fa fa-edit blue">Accept User</i>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import {vueLarApi} from "../helpers";

    export default {
        data() {
            return {
                enterUser: []
            }
        },
        methods: {
            accept(userId, index) {
                vueLarApi(`api/accept/${this.$route.params.id}`, 'PUT', {user_id: userId})
                    .then((res) => {
                        this.enterUser.splice(index, 1);
                        swal.fire(
                            'Updated!',
                            res.message,
                            'success'
                        )
                    })
                    .catch((error) => {
                    });
            }
        },
        created() {
            vueLarApi(`api/get-user-assign/${this.$route.params.id}`)
                .then((res) => {
                    this.enterUser = res;
                })
                .catch((error) => {
                });
        },
        computed: {
            users() {
                return this.enterUser;
            }
        }
    }
</script>

<style scoped>

</style>
