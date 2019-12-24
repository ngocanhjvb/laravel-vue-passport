<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Responsive Hover Table</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#userModal">
                                CreateUser
                            </button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="userModal" tabindex="-1" role="dialog"
                             aria-labelledby="UserModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="UserModalLabel">Create A User</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
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
    import axios from 'axios';
    import {smartLunchApi} from '../helpers';

    export default {
        data() {
            return {
                usersApi: []
            }
        },
        methods: {
            editModal(user) {
                console.log(user)
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
            }
        },
        created() {
            smartLunchApi('/api/user', 'GET')
                .then((res) => {
                    this.usersApi = res.data;
                })
                .catch((err) => {
                    console.log(err);
                })
        },
        computed: {
            users() {
                return this.usersApi;
            }
        }
    }
</script>
