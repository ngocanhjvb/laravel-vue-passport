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
                        <invitation></invitation>
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
    import {vueLarApi} from '../helpers';

    export default {
        props: ['userSetting'],
        data() {
            return {
                form: this.userSetting,
                errors: {},
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
                vueLarApi(`api/profile`, 'PUT', this.userSetting)
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
                    this.userSetting.photo = reader.result;
                    this.$emit('updateImage', reader.result);
                }
                reader.readAsDataURL(file);
            }
        }
    }
</script>

<style scoped>

</style>
