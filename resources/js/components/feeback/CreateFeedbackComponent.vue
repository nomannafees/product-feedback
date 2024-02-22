<template>
    <div class="container mt-5">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                          List
                        <router-link class="btn btn-primary btn-sm float-end" to="/list-feedback">List Feedback</router-link>
                    </div>
                    <div class="card-body">
                        <form id="form" @submit.prevent="AddFeedback">
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="title">Name</label>
                                    <input id="title" type="text" class="form-control" :class="errors.title ? 'is-invalid' : ''" name="title" autofocus>
                                    <span v-if="errors.title" class="error">{{ errors.title[0] }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="category_id">Category</label>
                                    <select id="category_id"  class="form-control" :class="errors.category_id ? 'is-invalid' : ''" name="category_id">
                                        <option value="" hidden>Select Category</option>
                                        <option  v-for="(data) in categories " :key="data.id" :value="data.id">{{data.name}}</option>
                                    </select>
                                    <span v-if="errors.category_id" class="error">{{ errors.category_id[0] }}</span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-12">
                                    <label for="description">Description</label>
                                    <textarea rows="5" id="description" type="description" class="form-control" :class="errors.description ? 'is-invalid' : ''" name="description"></textarea>
                                    <span v-if="errors.description" class="error">{{ errors.description[0] }}</span>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" :disabled="loading">
                                        <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        <span> Save</span>
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
                categories: {},
                accessToken: localStorage.getItem('api_token') || null,
            };
        },
        methods: {
            AddFeedback() {
                this.loading = true;
                this.errors = {};
                this.lead = document.getElementById('form');
                let formData = new FormData(this.lead);
                axios.post('/api/feedback-add', formData, {
                    headers: {
                        'Authorization': `Bearer ${this.accessToken}`,
                        'Content-Type': 'application/json',
                    },
                })
                    .then(response => {
                        this.loading = false;
                        this.showToast();
                        this.$router.push('/list-feedback');
                    })
                    .catch(error => {
                        this.loading = false;
                        if (error.response && error.response.status === 422) {
                            this.errors = error.response.data.errors;
                        } else {
                            console.error(error.response.data);
                        }
                    });
            },
            GetCategories() {
                axios.get('/api/get-categories')
                    .then(response => {
                        console.log(response.data);
                        this.categories = response.data;
                    })
                    .catch(error => {
                        console.log(response.data);
                    });
            },
            showToast() {
                this.$swal.fire({
                    icon: 'success',
                    text: 'Feedback added successfully.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000, // Adjust the duration
                    timerProgressBar: true,
                });
            },
        },

        mounted() {
            if(this.accessToken==null){
                this.$router.push('/login');
            }
            console.log('add Feedback Component.');
            this.GetCategories();


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
