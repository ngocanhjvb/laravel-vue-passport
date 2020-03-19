<template>
    <div>
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         :src="getProfilePhoto()" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{ userProfile.name }}</h3>
                <p class="text-muted text-center">Software Engineer</p>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-primary">
            <div class="card-header">
                <div v-if="currentCompany">
                    <p>Your Company is {{ currentCompany }}</p>
                    <button class="btn btn-danger" @click="layOff">LayOff <i
                        class="fas fa-user-plus fa-fw"></i></button>
                </div>
                <div v-else>
                    You not in a company
                </div>
                <div v-if="invitations">
                    <h4>Invitation</h4>
                    <p>{{ invitations }}</p>
                </div>
                <div v-if="currentCompany">
                    <h4>CurrentCompany</h4>
                    <p>{{ currentCompany }}</p>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">

            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
</template>

<script>
    import {vueLarApi} from "../helpers";

    export default {
        props: ['userProfile'],
        data() {
            return {
                photo: false,
            }
        },
        computed: {
            profile() {
                return this.userProfile
            },
            invitations() {
                return this.$store.state.invitations
            },
            currentCompany() {
                return this.$store.state.currentCompany
            }
        },
        methods: {
            getProfilePhoto() {
                if (this.userProfile.changeImage) {
                    return this.userProfile.photo;
                } else {
                    return baseUrl + 'img/profile/' + this.userProfile.photo;
                }
            },
            layOff() {
                vueLarApi(`api/layOff`, 'PUT')
                    .then((res) => {
                        swal.fire(
                            'Updated!',
                            res.message,
                            'success'
                        )
                        this.$store.commit('layOff')
                    })
                    .catch((error) => {
                    });
            }
        },
        created() {
            this.$store.dispatch('checkInvitation');
        }

    }
</script>

<style scoped>

</style>
