<template>
    <div class="container mt-5">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <span class="pl-4">Comment</span>
                        <router-link class="btn btn-primary btn-sm float-end" to="/list-feedback">List Feedback
                        </router-link>
                    </div>
                    <div class="card-body">
                        <ol class="list-group">
                            <li v-if="typeof records.data !== 'undefined' && records.data.length === 0"
                                class="list-group-item d-flex justify-content-between align-items-start cursor">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"> No Record found!</div>
                                </div>
                            </li>
                            <li v-else v-for="(data , key) in records.data"
                                class="list-group-item d-flex justify-content-between align-items-start cursor">
                                <div class="ms-2 me-auto">
                                    <figure class="">
                                        <blockquote class="blockquote">
                                            <p>{{data.content ? data.content:'--'}}</p>
                                        </blockquote>
                                        <figcaption class="blockquote-footer">
                                            {{data.user.name ? data.user.name :'--'}} <cite title="Source Title">{{data.created_at
                                            ? data.created_at:'--'}}</cite>
                                        </figcaption>
                                    </figure>
                                </div>
                                <span
                                    class="badge bg-primary rounded-pill">{{data.user.name ? data.user.name:'--'}}</span>
                            </li>
                        </ol>
                        <Bootstrap5Pagination :data="records" class="pagination pagination-sm pt-3 pb-0 float-end" @pagination-change-page="GetComment(this.feedbackId,$event)" />
                        <form id="form" @submit.prevent="AddFeedback">

                            <div class="row mb-3 mt-4">
                                <div class="col-md-12">
                                    <label for="review">Add Comment</label>
                                    <textarea rows="3" id="review" type="review" class="form-control"
                                              :class="errors.review ? 'is-invalid' : ''" v-model="this.review"
                                              name="review"></textarea>
                                    <span v-if="errors.review" class="error">{{ errors.review[0] }}</span>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary" :disabled="loading">
                                        <span v-if="loading" class="spinner-border spinner-border-sm" role="status"
                                              aria-hidden="true"></span>
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
                loading: false,
                feedbackId: "",
                errors: {},
                records: {},
                page: 0,
                perPage: 0,
                currentPage: 0,
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
                formData.append('feedback_id', this.feedbackId);
                // this.feedbackId
                axios.post('/api/comment-add', formData, {
                    headers: {
                        'Authorization': `Bearer ${this.accessToken}`,
                        'Content-Type': 'application/json',
                    },
                })
                    .then(response => {
                        this.loading = false;
                        this.review = "";
                        this.GetComment(this.feedbackId);
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
            GetComment(id,page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/api/get-comments/' + id + '?page=' + page)
                    .then(response => {
                        console.log(response.data);
                        this.records = response.data;
                        this.perPage = response.data.per_page;
                        this.currentPage = response.data.current_page;

                    })
                    .catch(error => {

                    });
            },
        },
        mounted() {
            if (this.accessToken == null) {
                this.$router.push('/login');
            }

            const urlParams = new URLSearchParams(window.location.search);
            this.feedbackId = urlParams.get('id');
            this.GetComment(this.feedbackId);
            console.log('add Feedback Component.');


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
