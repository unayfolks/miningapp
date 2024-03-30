<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between">
                        <h3>User</h3>
                        <button class="btn btn-info"><router-link :to="{name:'register'}">Add New User</router-link></button>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">User</p>
                    </div>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Email</th>
                                <th scope="col">Tipe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users" :key="user.id">
                                <th scope="row">{{ index + 1 }}</th>
                                <td>{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>{{ user.tipe }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "user",
    data() {
        return {
            user: this.$store.state.auth.user,
            users: []
        }
    },
    methods: {
        getuser() {
            axios.get('/api/user/getuser')
                .then((res) => {
                    this.users = res.data
                })
        }
    },
    mounted() {
        this.getuser();
    },
}
</script>
