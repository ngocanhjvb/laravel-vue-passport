<template>
    <div>
        <div class="card">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="#settings"
                                            data-toggle="tab">Settings</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm"
                                     src="" alt="user image">
                                <span class="username">
                          <a href="#">Jonathan Burke Jr.</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                                <span class="description">Shared publicly - 7:30 PM today</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>

                            <p>
                                <a href="#" class="link-black text-sm mr-2"><i
                                    class="fas fa-share mr-1"></i> Share</a>
                                <a href="#" class="link-black text-sm"><i
                                    class="far fa-thumbs-up mr-1"></i> Like</a>
                                <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                            </p>

                            <input class="form-control form-control-sm" type="text"
                                   placeholder="Type a comment">
                        </div>
                        <!-- /.post -->

                        <!-- Post -->
                        <div class="post clearfix">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm"
                                     src="" alt="User Image">
                                <span class="username">
                          <a href="#">Sarah Ross</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                                <span class="description">Sent you a message - 3 days ago</span>
                            </div>
                            <!-- /.user-block -->
                            <p>
                                Lorem ipsum represents a long-held tradition for designers,
                                typographers and the like. Some people hate it and argue for
                                its demise, but others ignore the hate as they create awesome
                                tools to help create filler text for everyone from bacon lovers
                                to Charlie Sheen fans.
                            </p>

                            <form class="form-horizontal">
                                <div class="input-group input-group-sm mb-0">
                                    <input class="form-control form-control-sm" placeholder="Response">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-danger">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- /.post -->

                        <!-- Post -->
                        <div class="post">
                            <div class="user-block">
                                <img class="img-circle img-bordered-sm"
                                     src="" alt="User Image">
                                <span class="username">
                          <a href="#">Adam Jones</a>
                          <a href="#" class="float-right btn-tool"><i class="fas fa-times"></i></a>
                        </span>
                                <span class="description">Posted 5 photos - 5 days ago</span>
                            </div>
                            <!-- /.user-block -->
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <img class="img-fluid" src="" alt="Photo">
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <img class="img-fluid mb-3" src=""
                                                 alt="Photo">
                                            <img class="img-fluid" src=""
                                                 alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                        <div class="col-sm-6">
                                            <img class="img-fluid mb-3" src=""
                                                 alt="Photo">
                                            <img class="img-fluid" src=""
                                                 alt="Photo">
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                    <!-- /.row -->
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <p>
                                <a href="#" class="link-black text-sm mr-2"><i
                                    class="fas fa-share mr-1"></i> Share</a>
                                <a href="#" class="link-black text-sm"><i
                                    class="far fa-thumbs-up mr-1"></i> Like</a>
                                <span class="float-right">
                          <a href="#" class="link-black text-sm">
                            <i class="far fa-comments mr-1"></i> Comments (5)
                          </a>
                        </span>
                            </p>

                            <input class="form-control form-control-sm" type="text"
                                   placeholder="Type a comment">
                        </div>
                        <!-- /.post -->
                    </div>
                    <div class="tab-pane" id="settings">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-2 control-label">Name</label>

                                <div class="col-sm-12">
                                    <input type="text" v-model="userSetting.name" class="form-control" id="inputName"
                                           placeholder="Name" :class="{ 'is-invalid': nameErr }">
                                    <span style="color: red" v-if="nameErr" class="error">{{ nameErr[0] }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                                <div class="col-sm-12">
                                    <input type="email" v-model="userSetting.email" class="form-control" id="inputEmail"
                                           placeholder="Email" :class="{ 'is-invalid': emailErr }">
                                    <span style="color: red" v-if="emailErr" class="error">{{ emailErr[0] }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputExperience" class="col-sm-2 control-label">Experience</label>

                                <div class="col-sm-12">
                                    <textarea v-model="userSetting.bio" class="form-control" id="inputExperience"
                                              placeholder="Experience"
                                              :class="{ 'is-invalid': bioErr }"></textarea>
                                    <span style="color: red" v-if="bioErr" class="error">{{ bioErr[0] }}</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="photo" class="col-sm-2 control-label">Profile Photo</label>
                                <div class="col-sm-12">
                                    <input type="file" @change="updatePicture" name="photo" class="form-input">
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="password" class="col-sm-12 control-label">Passport (leave empty if not
                                    changing)</label>

                                <div class="col-sm-12">
                                    <input type="password"
                                           v-model="userSetting.password"
                                           class="form-control"
                                           id="password"
                                           placeholder="Passport"
                                           :class="{ 'is-invalid': passwordErr }"
                                    >
                                    <span style="color: red" v-if="passwordErr"
                                          class="error">{{ passwordErr[0] }}</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-12">
                                    <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
</template>

<script>
    import {smartLunchApi} from '../helpers';

    export default {
        props: ['userSetting'],
        data() {
            return {
                form: this.userSetting,
                errors: {},
                photo: []
            }
        },
        computed: {
            nameErr() {
                return this.errors.name
            },
            emailErr() {
                return this.errors.email
            },
            passwordErr() {
                return this.errors.password
            },
            bioErr() {
                return this.errors.bio
            },
            userSettingCp() {
                return this.userSetting
            }
        },
        methods: {
            updateInfo() {
                this.userSetting.photo = this.photo;
                smartLunchApi(`api/profile`, 'PUT', this.userSetting)
                    .then((res) => {
                        this.errors = {}
                    })
                    .catch((error) => {
                        if (error.status === 422) {
                            this.errors = error.data.errors;
                        }
                    });
            },
            updatePicture(e) {
                let file = e.target.files[0];
                let reader = new FileReader();

                let limit = 1024 * 1024 * 2;
                if (file['size'] > limit) {
                    swal.fire({
                        title: 'Oops...',
                        text: 'You are uploading a large file',
                    });
                    return false;
                }

                reader.onloadend = (file) => {
                    this.photo = reader.result;
                    this.$emit('updateImage', reader.result);
                }
                reader.readAsDataURL(file);
            }
        }

    }
</script>

<style scoped>

</style>
