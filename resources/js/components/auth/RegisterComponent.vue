<template>
    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">Register</div>

                    <div class="card-body">
                        <form id="form" @submit.prevent="RegisterUser">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="name">Name</label>
                                    <input id="name" type="text" class="form-control" :class="errors.name ? 'is-invalid' : ''" name="name" v-model="name" autocomplete="name" autofocus>
                                    <span v-if="errors.name" class="error">{{ errors.name[0] }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="email">Email Address</label>
                                    <input id="email" type="email" class="form-control" :class="errors.email ? 'is-invalid' : ''" name="email" v-model="email" autocomplete="email">
                                    <span v-if="errors.email" class="error">{{ errors.email[0] }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" :class="errors.password ? 'is-invalid' : ''" name="password" v-model="password">
                                    <span v-if="errors.password" class="error">{{ errors.password[0] }}</span>
                                </div>
                            </div>



                            <div class="row mb-0">
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" :disabled="loading">
                                        <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <span> Register</span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                loading:false,
                errors: {},
            };
        },
        methods: {
            RegisterUser() {
                this.loading = true;
                this.errors = {};
                this.lead = document.getElementById('form');
                let formData = new FormData(this.lead);
                axios.post('/api/register',formData)
                    .then(response => {
                        this.loading = false;
                        console.log(response.data);
                        this.$swal.fire({
                            icon: 'success',
                            text: 'You have register successfully.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true,
                        });
                        console.log(response.data.authorization.token);
                        localStorage.setItem('api_token',response.data.authorization.token);
                        this.accessToken=localStorage.getItem('api_token') || null;
                        // Emit an event with the accessToken
                        this.$emitter.emit('login-success', this.accessToken);

                        this.$router.push('/list-feedback');
                    })
                    .catch(error => {
                        this.loading = false;
                        if (error.response && error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        } else {
                            console.error(error.response.data);
                            // Handle other registration errors, e.g., show a general error message
                        }
                    });
            },
        },
        mounted() {
            console.log('Register Component.');

        }
    };
</script>

<style>
    .error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
</style>
