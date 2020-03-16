<template>
    <div class="container">
        <div class="row">
            <div class="col-12" v-if="$gate.isAdminOrAuthor()">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Responsive Hover Table</h3>

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal" v-if="$gate.isAdminOrAuthor()">Add New <i
                                class="fas fa-user-plus fa-fw"></i></button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"
                             aria-labelledby="UserModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" v-show="!editMode" id="addNewLabel">Add New</h5>
                                        <h5 class="modal-title" v-show="editMode" id="updateLabel">Update User's
                                            Info</h5>
                                    </div>
                                    <form @submit.prevent="editMode ? updateUser() : createUser()">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input v-model="form.name" type="text" name="name"
                                                       placeholder="Name"
                                                       class="form-control">
                                                <span style="color: red" v-if="nameErr"
                                                      class="error">{{ nameErr[0] }}</span>
                                            </div>

                                            <div class="form-group">
                                                <input v-model="form.email" type="email" name="email"
                                                       placeholder="Email Address"
                                                       class="form-control">
                                                <span style="color: red" v-if="emailErr"
                                                      class="error">{{ emailErr[0] }}</span>
                                            </div>

                                            <div class="form-group">
                                             <textarea v-model="form.bio" name="bio" id="bio"
                                                       placeholder="Short bio for user (Optional)"
                                                       class="form-control"></textarea>
                                                <span style="color: red" v-if="bioErr"
                                                      class="error">{{ bioErr[0] }}</span>
                                            </div>

                                            <div class="form-group">
                                                <select name="type" v-model="form.type" id="type" class="form-control">
                                                    <option value="">Select User Role</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="user">Standard User</option>
                                                    <option value="author">Author</option>
                                                </select>
                                                <span style="color: red" v-if="typeErr"
                                                      class="error">{{ typeErr[0] }}</span>
                                            </div>

                                            <div class="form-group">
                                                <input v-model="form.password" type="password" name="password"
                                                       id="password"
                                                       class="form-control">
                                                <span style="color: red" v-if="passwordErr" class="error">{{ passwordErr[0] }}</span>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close
                                            </button>
                                            <button v-show="editMode" type="submit" class="btn btn-success">Update
                                            </button>
                                            <button v-show="!editMode" type="submit" class="btn btn-primary">Create
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Bio</th>
                                <th>Job</th>
                                <th>Registered At</th>
                                <th v-show="$gate.isAdminOrAuthor()">Modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user,index) in users" :key="user.id">
                                <td>{{ parseInt(index) + 1}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                                <td>{{user.type}}</td>
                                <td>{{user.bio}}</td>
                                <td>{{user.job.name}}</td>
                                <td>{{user.created_at}}</td>
                                <td v-show="$gate.isAdminOrAuthor()">
                                    <a href="#" @click="editModal(user)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteUser(user.id ,index)">
                                        <i class="fa fa-trash red"></i>
                                    </a>

                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <paginate
                            :page-count="pageCount"
                            :click-handler="getResults"
                            :container-class="'pagination'"
                            :page-class="'page-item'">
                        </paginate>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
            <div class="col-12" v-else>
                <not-found></not-found>
            </div>
            <!-- /.card -->
        </div>
    </div>

</template>

<script>
    import {vueLarApi} from '../helpers';
    import Paginate from 'vuejs-paginate'

    export default {
        components: {
            Paginate
        },
        data() {
            return {
                usersApi: [],
                form: {
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                },
                editMode: false,
                errors: [],
                pageCount: 1,
            }
        },
        methods: {
            getResults(page) {
                vueLarApi(`api/user?page=` + page)
                    .then(response => {
                        this.usersApi = response.data;
                        this.pageCount = response.total / 5
                    })
                    .catch((error) => {
                        swal.fire(
                            'error',
                            error.message,
                            'error'
                        );
                    });
            },
            newModal() {
                this.errors = [];
                this.editMode = false;
                this.form = {
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                };
                $('#addNew').modal('show');
            },
            editModal(user) {
                this.errors = [];
                this.editMode = true;
                this.form = {
                    id: user.id,
                    name: user.name,
                    email: user.email,
                    password: user.password,
                    type: user.type,
                    bio: user.bio,
                    photo: user.photo,
                };
                $('#addNew').modal('show');
            },
            deleteUser(id, index) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        vueLarApi(`api/user/${id}`, 'DELETE', {id: id})
                            .then((response) => {
                                this.usersApi.splice(index, 1);
                                swal.fire(
                                    'Deleted!',
                                    response.message,
                                    'success'
                                );
                            })
                            .catch((error) => {
                                swal.fire(
                                    'error',
                                    error.message,
                                    'error'
                                );
                            })

                    } else {
                        swal.fire(
                            'you are not deleted',
                            'Your file has not been deleted.',
                            'warning'
                        )
                    }
                })
            },
            createUser() {
                vueLarApi(`api/user`, 'POST', this.form)
                    .then((res) => {
                        $('#addNew').modal('hide');
                        swal.fire(
                            'Created!',
                            res.message,
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch((error) => {
                        if (error.status === 422) {
                            this.errors = error.data.errors;
                        }
                    });
            },
            updateUser() {
                vueLarApi(`api/user/${this.form.id}`, 'PUT', this.form)
                    .then((res) => {
                        $('#addNew').modal('hide');
                        swal.fire(
                            'Updated!',
                            res.message,
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch((error) => {
                        if (error.status === 422) {
                            this.errors = error.data.errors;
                        }
                    });
            },
        },
        created() {
            // setInterval(() => this.loadUsers(), 3000);
            Fire.$on('searching', () => {
                let query = this.$parent.search;
                vueLarApi('api/findUser?q=' + query)
                    .then((response) => {
                        this.usersApi = response.data;
                    })
                    .catch(() => {

                    })
            })


            this.getResults();
            Fire.$on('AfterCreate', () => {
                this.getResults(1);
            });

        },
        computed: {
            users() {
                return this.usersApi;
            },
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
            typeErr() {
                return this.errors.type
            }
        }
    }
</script>
<style lang="css">
    .pagination {
    }

    .page-item {
    }
</style>
