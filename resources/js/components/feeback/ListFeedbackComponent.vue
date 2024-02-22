<template>
    <div class="container mt-5">
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        Review List
                        <router-link class="btn btn-primary btn-sm float-end" to="/add-feedback">Add Feedback</router-link>
                    </div>
                    <div class="card-body pt-4 pb-4">

                        <ol class="list-group">
                            <li v-if="typeof records.data !== 'undefined' && records.data.length === 0" class="list-group-item d-flex justify-content-between align-items-start cursor">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"> No Record found!</div>
                                </div>
                            </li>
                            <li v-else v-for="(data , key) in records.data" @click="ViewFeedback(data.id)" class="list-group-item d-flex justify-content-between align-items-start cursor">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold"> {{data.title ? data.title:'--'}}</div>
                                    {{data.user.name ? data.category.name:'---'}}
                                </div>
                                <span class="badge bg-primary rounded-pill">{{data.user.name ? data.user.name:'---'}}</span>
                            </li>
                        </ol>


                    </div>
                    <div class="card-footer">
                        <Bootstrap5Pagination :data="records" class="pagination pagination-sm pt-3 pb-0 float-end" @pagination-change-page="GetFeedback" />
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
                errors: {},
                records: {},
                categories: {},
                perPage: 0,
                currentPage: 0,
                accessToken: localStorage.getItem('api_token') || null,
            };
        },
        methods: {

            GetFeedback(page) {
                if (typeof page === 'undefined') {
                    page = 1;
                }
                axios.get('/api/get-feedback?page=' + page)
                    .then(response => {
                        console.log(response.data);
                        this.records = response.data;
                        this.perPage = response.data.per_page;
                        this.currentPage = response.data.current_page;
                    })
                    .catch(error => {
                        console.log(response.data);
                    });
            },
            GetCategories() {
                axios.get('/api/get-feedback')
                    .then(response => {
                        console.log(response.data);
                        this.categories = response.data;
                    })
                    .catch(error => {
                        console.log(response.data);
                    });
            },



            ViewFeedback(id){
                this.$router.push('/comment-feedback?id='+id);
            }
        },
        mounted() {
            if(this.accessToken==null){
                this.$router.push('/login');
            }
            this.$emit('logout', this.accessToken);
            console.log('add Feedback Component.');
            this.GetFeedback();
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
    .cursor{
        cursor: pointer;
    }
    .cursor:hover{
        background-color: #f8f9fa;
    }
</style>
