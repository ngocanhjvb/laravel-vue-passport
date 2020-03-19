<template>
    <div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <introduce :userProfile="userProfile"></introduce>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <detail :user-setting="user" @updateImage="handleEvent"></detail>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
</template>

<script>
    import {vueLarApi} from '../helpers';

    export default {
        data() {
            return {
                user: {},
            }
        },
        methods: {
            handleEvent(photo) {
                this.userProfile.photo = photo;
                this.userProfile.changeImage = true;
            }
        },
        created() {
            vueLarApi('/api/profile', 'GET')
                .then((res) => {
                    this.user = res;
                    if (res.companyName) {
                        this.$store.commit('checkCurrentCompany', res.companyName)
                    }
                })
                .catch((err) => {
                    console.log(err);
                })
        },
        computed: {
            userProfile() {
                return this.user;
            }
        }
    }
</script>
