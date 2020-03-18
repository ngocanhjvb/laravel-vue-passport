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

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Followers</b> <a class="float-right">1,322</a>
                    </li>
                    <li class="list-group-item">
                        <b>Following</b> <a class="float-right">543</a>
                    </li>
                    <li class="list-group-item">
                        <b>Friends</b> <a class="float-right">13,287</a>
                    </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <!-- About Me Box -->
        <div class="card card-primary">
            <div class="card-header">
                <button class="btn btn-danger" @click="layOff">LayOff <i
                    class="fas fa-user-plus fa-fw"></i></button>
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
                photo: false
            }
        },
        computed: {
            profile() {
                return this.userProfile
            },
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
                    })
                    .catch((error) => {
                    });
            }
        }

    }
</script>

<style scoped>

</style>
