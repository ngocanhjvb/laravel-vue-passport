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
                        <i class="fa fa-address-book blue"></i>
                    </a>
                    <br>
                    <a href="#" @click="refuseCompany(company)">
                        <i class="fa fa-remove blue"></i>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        data() {
            return {

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

        }
    }
</script>

<style scoped>

</style>
