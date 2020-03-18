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
                    <a href="#" @click="acceptCompany(company)">
                        <i class="fa fa-address-book blue">Accept</i>
                    </a>
                    <a href="#" @click="refuseCompany(company)">
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
                console.log(company)
            },
            refuseCompany(company) {
                console.log(company)
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
