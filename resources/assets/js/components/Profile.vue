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
                        <detail :user-setting="user"></detail>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
    </div>
</template>

<script>
    import {smartLunchApi} from '../helpers';

    export default {
        data() {
            return {
                user: {},
            }
        },
        created() {
            smartLunchApi('/api/profile', 'GET')
                .then((res) => {
                    this.user = res
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
