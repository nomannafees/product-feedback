<template>
    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">Login</div>

                    <div class="card-body">
                        <form id="form" @submit.prevent="Login">

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="email">Email Address</label>
                                    <input id="email" type="email" class="form-control" :class="errors.email ? 'is-invalid' : ''" name="email" v-model="email" autocomplete="email">
                                    <span v-if="errors.email" class="error">{{ errors.email[0] }}</span>
                                    <span v-if="errors" class="error">{{ errors[0] }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="password">Password</label>
                                    <input id="password" type="password" class="form-control" :class="errors.password ? 'is-invalid' : ''" name="password" v-model="password" autocomplete="new-password">
                                    <span v-if="errors.password" class="error">{{ errors.password[0] }}</span>
                                </div>
                            </div>



                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" :disabled="loading">
                                        <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <span> Login</span>
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
            Login() {
                this.loading = true;
                this.errors = {};
                this.lead = document.getElementById('form');
                let formData = new FormData(this.lead);
                axios
                    .post('/api/login', formData)
                    .then(response => {
                        this.loading = false;
                        this.showToast();
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
                            // this.loading = false;
                        } else if (error.response && error.response.status === 401) {
                            this.errors = error.response.data.error;
                            // this.loading = false;
                        } else {
                            console.error(error.response.data);
                        }

                    });
            },
            showToast() {
                this.$swal.fire({
                    icon: 'success',
                    text: 'You have login successfully.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000, // Adjust the duration
                    timerProgressBar: true,
                });
            },
        },
        mounted() {
            console.log('Register Component.')
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
