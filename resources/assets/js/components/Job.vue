<template>
    <div class="container">
        <div class="row">
            <div class="col-12" v-if="$gate.isAdminOrAuthor()">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Responsive Hover Table</h3>

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal" v-if="$gate.isAdminOrAuthor()">Add New <i
                                class="fas fa-job-plus fa-fw"></i></button>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="addNew" tabindex="-1" role="dialog"
                             aria-labelledby="JobModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" v-show="!editMode" id="addNewLabel">Add New</h5>
                                        <h5 class="modal-title" v-show="editMode" id="updateLabel">Update Job's
                                            Info</h5>
                                    </div>
                                    <form @submit.prevent="editMode ? updateJob() : createJob()">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <input v-model="form.name" type="text" name="name"
                                                       placeholder="Name"
                                                       class="form-control">
                                                <span style="color: red" v-if="nameErr"
                                                      class="error">{{ nameErr[0] }}</span>
                                            </div>

                                            <div class="form-group">
                                                <input v-model="form.area" type="text" name="text"
                                                       placeholder="AREA"
                                                       class="form-control">
                                                <span style="color: red" v-if="areaErr"
                                                      class="error">{{ areaErr[0] }}</span>
                                            </div>

                                            <div class="form-group">
                                                <input v-model="form.code" type="text" name="text"
                                                       placeholder="CODE"
                                                       class="form-control">
                                                <span style="color: red" v-if="codeErr"
                                                      class="error">{{ codeErr[0] }}</span>
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
                                <th>Area</th>
                                <th>Code</th>
                                <th>Registered At</th>
                                <th v-show="$gate.isAdminOrAuthor()">Modify</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(job,index) in jobs" :key="job.id">
                                <td>{{ parseInt(index) + 1}}</td>
                                <td>{{job.name}}</td>
                                <td>{{job.area}}</td>
                                <td>{{job.code}}</td>
                                <td>{{job.created_at}}</td>
                                <td v-show="$gate.isAdminOrAuthor()">
                                    <a href="#" @click="editModal(job)">
                                        <i class="fa fa-edit blue"></i>
                                    </a>
                                    /
                                    <a href="#" @click="deleteJob(job.id ,index)">
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
                jobsApi: [],
                form: {
                    id: '',
                    name: '',
                    area: '',
                    code: '',
                },
                editMode: false,
                errors: [],
                pageCount: 1,
            }
        },
        methods: {
            getResults(page) {
                vueLarApi(`api/jobs?page=` + page)
                    .then(response => {
                        this.jobsApi = response.data;
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
                    area: '',
                    code: ''
                };
                $('#addNew').modal('show');
            },
            editModal(job) {
                this.errors = [];
                this.editMode = true;
                this.form = {
                    id: job.id,
                    name: job.name,
                    area: job.area,
                    code: job.code,
                };
                $('#addNew').modal('show');
            },
            deleteJob(id, index) {
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        vueLarApi(`api/jobs/${id}`, 'DELETE', {id: id})
                            .then((response) => {
                                this.jobsApi.splice(index, 1);
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
            createJob() {
                vueLarApi(`api/jobs`, 'POST', this.form)
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
            updateJob() {
                vueLarApi(`api/jobs/${this.form.id}`, 'PUT', this.form)
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
            jobs() {
                return this.jobsApi;
            },
            nameErr() {
                return this.errors.name
            },
            areaErr() {
                return this.errors.area
            },
            codeErr() {
                return this.errors.code
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
