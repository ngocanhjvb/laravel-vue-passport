<template>
    <div class="container">
        <div class="row">
            <div class="col-12" v-if="$gate.isAdminOrAuthor()">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">List Companies</h3>

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal" v-if="$gate.isAdminOrAuthor()">Add New <i
                                class="fas fa-comment-plus fa-fw"></i></button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"
                             aria-labelledby="CompanyModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" v-show="!editMode" id="addNewLabel">Add New</h5>
                                        <h5 class="modal-title" v-show="editMode" id="updateLabel">Update Company's
                                            Info</h5>
                                    </div>
                                    <form @submit.prevent="editMode ? updateCompany() : createCompany()">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input v-model="form.name" type="text" name="name"
                                                       placeholder="Name"
                                                       class="form-control">
                                                <span style="color: red" v-if="nameErr"
                                                      class="error">{{ nameErr[0] }}</span>
                                            </div>

                                            <div class="form-group">
                                                <input v-model="form.address" type="text" name="address"
                                                       placeholder="address"
                                                       class="form-control">
                                                <span style="color: red" v-if="addressErr"
                                                      class="error">{{ addressErr[0] }}</span>
                                            </div>

                                            <div class="form-group">
                                                <input v-model="form.founders" type="text" name="text"
                                                       placeholder="founders"
                                                       class="form-control">
                                                <span style="color: red" v-if="foundersErr"
                                                      class="error">{{ foundersErr[0] }}</span>
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
                                <th>Address</th>
                                <th>Founders</th>
                                <th>Registered At</th>
                                <th v-show="$gate.isAdminOrAuthor()">Modify</th>
                                <th>Detail Company</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(company,index) in companies" :key="company.id">
                                <td>{{ parseInt(index) + 1}}</td>
                                <td>{{company.name}}</td>
                                <td>{{company.address}}</td>
                                <td>{{company.founders}}</td>
                                <td>{{company.created_at}}</td>
                                <td v-show="$gate.isAdminOrAuthor()">
                                    <a href="#" @click="editModal(company)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteCompany(company.id ,index)">
                                        <i class="fa fa-trash red"></i>
                                    </a>
                                </td>
                                <td v-show="$gate.isAdminOrAuthor()">
                                    <router-link :to="`/company/` + company.id" class="nav-link">
                                        <p>
                                           List Employees of {{company.name}}
                                        </p>
                                    </router-link>
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
                companiesApi: [],
                form: {
                    id: '',
                    name: '',
                    address: '',
                    founders: '',
                },
                editMode: false,
                errors: [],
                pageCount: 1,
            }
        },
        methods: {
            getResults(page) {
                vueLarApi(`api/companies?page=` + page)
                    .then(response => {
                        this.companiesApi = response.data;
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
                    address: '',
                    founders: ''
                };
                $('#addNew').modal('show');
            },
            editModal(company) {
                this.errors = [];
                this.editMode = true;
                this.form = {
                    id: company.id,
                    name: company.name,
                    address: company.address,
                    founders: company.founders,
                };
                $('#addNew').modal('show');
            },
            deleteCompany(id, index) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        vueLarApi(`api/companies/${id}`, 'DELETE', {id: id})
                            .then((response) => {
                                this.companiesApi.splice(index, 1);
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
            createCompany() {
                vueLarApi(`api/companies`, 'POST', this.form)
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
            updateCompany() {
                vueLarApi(`api/companies/${this.form.id}`, 'PUT', this.form)
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
            this.getResults(1);
            Fire.$on('AfterCreate', () => {
                this.getResults(1);
            });

        },
        computed: {
            companies() {
                return this.companiesApi;
            },
            nameErr() {
                return this.errors.name
            },
            addressErr() {
                return this.errors.address
            },
            foundersErr() {
                return this.errors.founders
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
