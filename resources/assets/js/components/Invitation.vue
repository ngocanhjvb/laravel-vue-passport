<template>
    <div>
        <div v-if="(!invitation && !currentCompany)">
            <h4>List Companies To Join</h4>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(company,index) in listCompanies" :key="company.id">
                    <td>{{ parseInt(index) + 1}}</td>
                    <td>{{company.name}}</td>
                    <td>
                        <a href="#" @click="enterCompany(company.id,index)">
                            <i class="fa fa-address-book blue">Enter</i>
                        </a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div v-else>
            <div v-if="invitation">
                <p style="color: red">Your company'invitation</p>
                <p>{{ invitation }}</p>
                <button class="btn btn-danger" @click="retract">Retract<i
                    class="fas fa-remove fa-fw"></i></button>
            </div>
            <div v-if="currentCompany">
                <p style="color: blue">Your company you in</p>
                <p>{{ currentCompany }}</p>
            </div>
        </div>
    </div>
</template>

<script>
    import {vueLarApi} from "../helpers";

    export default {
        data() {
            return {
                listCompanies: [],
            }
        },
        methods: {
            enterCompany(company, index) {
                vueLarApi(`api/enterCompany/${company}`, 'POST')
                    .then((res) => {
                        swal.fire(
                            'Enter!',
                            res.message,
                            'success'
                        );
                        this.$store.commit('enterCompany', this.listCompanies[index].name);
                    })
                    .catch((error) => {
                    });
            },
            retract() {
                vueLarApi(`api/retract`, 'PUT')
                    .then((res) => {
                        swal.fire(
                            'Retract!',
                            res.message,
                            'success'
                        );
                        this.$store.commit('retract')
                    })
                    .catch((error) => {
                    });
            },
        },
        created() {
            vueLarApi(`api/get-list-companies`)
                .then((res) => {
                    this.listCompanies = res;
                })
                .catch((error) => {
                });
        },
        computed: {
            invitation() {
                return this.$store.state.invitations;
            },
            currentCompany() {
                return this.$store.state.currentCompany;
            }

        }
    }
</script>

<style scoped>

</style>
