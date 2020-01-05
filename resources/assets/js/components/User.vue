<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Responsive Hover Table</h3>

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">Add New <i
                                class="fas fa-user-plus fa-fw"></i></button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"
                             aria-labelledby="UserModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" v-show="!editMode" id="addNewLabel">Add New</h5>
                                        <h5 class="modal-title" v-show="editMode" id="addNewLabel">Update User's
                                            Info</h5>
                                    </div>
                                    <form @submit.prevent="editMode ? updateUser() : createUser()">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input v-model="form.name" type="text" name="name"
                                                       placeholder="Name"
                                                       class="form-control">
                                            </div>

                                            <div class="form-group">
                                                <input v-model="form.email" type="email" name="email"
                                                       placeholder="Email Address"
                                                       class="form-control">
                                            </div>

                                            <div class="form-group">
                                             <textarea v-model="form.bio" name="bio" id="bio"
                                                       placeholder="Short bio for user (Optional)"
                                                       class="form-control"></textarea>
                                            </div>

                                            <div class="form-group">
                                                <select name="type" v-model="form.type" id="type" class="form-control">
                                                    <option value="">Select User Role</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="user">Standard User</option>
                                                    <option value="author">Author</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <input v-model="form.password" type="password" name="password"
                                                       id="password"
                                                       class="form-control">
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
                                <th>Registered At</th>
                                <th>Modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(user,index) in users" :key="user.id">
                                <td>{{index +1}}</td>
                                <td>{{user.name}}</td>
                                <td>{{user.email}}</td>
                                <td>{{user.type}}</td>
                                <td>{{user.created_at}}</td>
                                <td>
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
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
</template>

<script>
    import {smartLunchApi} from '../helpers';

    export default {
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
                editMode: false
            }
        },
        methods: {
            loadUsers() {
                smartLunchApi('/api/user', 'GET')
                    .then((res) => {
                        this.usersApi = res.data;
                    })
                    .catch((err) => {
                        console.log(err);
                    })
            },
            newModal() {
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
                        smartLunchApi(`api/user/${id}`, 'DELETE', {id: id})
                            .then((response) => {
                                this.usersApi.splice(index, 1);
                                swal.fire(
                                    'Deleted!',
                                    response,
                                    'success'
                                );
                            })
                            .catch((error) => {
                                swal.fire(
                                    'error',
                                    error,
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
                smartLunchApi(`api/user`, 'POST', this.form)
                    .then((res) => {
                        console.log(res);
                        $('#addNew').modal('hide');
                        swal.fire(
                            'Created!',
                            res.message,
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                    });
            },
            updateUser() {
                smartLunchApi(`api/user/${this.form.id}`, 'PUT', this.form)
                    .then((res) => {
                        console.log(res);
                        $('#addNew').modal('hide');
                        swal.fire(
                            'Updated!',
                            res.message,
                            'success'
                        )
                        Fire.$emit('AfterCreate');
                    })
                    .catch(() => {
                    });
            },
        },
        created() {
            // setInterval(() => this.loadUsers(), 3000);
            this.loadUsers();
            Fire.$on('AfterCreate',() => {
                this.loadUsers();
            });

        },
        computed: {
            users() {
                return this.usersApi;
            }
        }
    }
</script>
