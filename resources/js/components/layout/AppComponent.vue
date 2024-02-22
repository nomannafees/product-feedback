<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="#">Product Feedback</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <router-link class="nav-link" to="/list-feedback">List Feedback</router-link>
                        </li>
                        <li class="nav-item">
                            <router-link class="nav-link" to="/add-feedback">Add Feedback</router-link>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        <li v-if="accessToken == null" class="nav-item">
                            <router-link class="nav-link" to="/register">Register</router-link>
                        </li>

                        <li v-if="accessToken == null" class="nav-item">
                            <router-link class="nav-link" to="/login">Login</router-link>
                        </li>

                        <li v-if="accessToken != null" class="nav-item">
                            <a class="nav-link" href="javaScript:void(0)" @click="Logout">Logout</a>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                accessToken:localStorage.getItem('api_token') || null,
            };
        },
        methods: {

            Logout() {
                axios.post('/api/logout', null, {
                    headers: {
                        'Authorization': `Bearer ${this.accessToken}`,
                        'Content-Type': 'application/json',
                    },
                })
                    .then(response => {
                        this.showToast();
                        localStorage.setItem('api_token', '');
                        this.accessToken = null;
                        this.$router.push('/login');
                    })
                    .catch(error => {
                        this.loading = false;
                    });
            },
            showToast() {
                this.$swal.fire({
                    icon: 'success',
                    text: 'You have logout successfully.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000, // Adjust the duration
                    timerProgressBar: true,
                });
            },

        },

        mounted() {
            this.$emitter.on('login-success', (accessToken) => {
                // Do something with the accessToken in the AppComponent
                console.log('Received accessToken in AppComponent:', accessToken);
                this.accessToken=accessToken;
            });
        },
    };
</script>

<style>
    /* Component styles here */
</style>
