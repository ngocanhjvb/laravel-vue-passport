<template>
    <div>
        <h4>List Companies invitations</h4>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(company,index) in companies" :key="company.id">
                <td>{{ parseInt(index) + 1}}</td>
                <td>{{company.name}}</td>
                <td>
                    <a href="#" @click="acceptCompany(company.id)">
                        <i class="fa fa-address-book blue">Accept</i>
                    </a>
                    <a href="#" @click="refuseCompany(company.id)">
                        <i class="fa fa-icons blue">Refuse</i>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import {vueLarApi} from "../helpers";

    export default {
        data() {
            return {
                companies: []
            }
        },
        methods: {
            acceptCompany(company) {
                vueLarApi(`api/accept/${company}`, 'POST')
                    .then((res) => {
                        swal.fire(
                            'Updated!',
                            res.message,
                            'success'
                        )
                    })
                    .catch((error) => {
                    });
            },
            refuseCompany(company) {
                vueLarApi(`api/refuse/${company}`, 'POST')
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
        },
        created() {
            vueLarApi('api/get-info')
                .then((res) => {
                    this.companies = res
                })
                .catch((error) => {
                   console.log(error)
                });
        }
    }
</script>

<style scoped>

</style>
