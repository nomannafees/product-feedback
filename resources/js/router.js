import { createRouter, createWebHistory } from 'vue-router';
import CreateFeedback from './components/feeback/CreateFeedbackComponent.vue';
import ListFeedback from './components/feeback/ListFeedbackComponent.vue';
import CommentFeedback from './components/feeback/CommentFeedbackComponent.vue';
import App from './components/layout/AppComponent.vue';
import Register from './components/auth/RegisterComponent.vue';
import Login from './components/auth/LoginComponent.vue';

const routes = [
    { path: '/app', component: App, name: 'app' },
    { path: '/add-feedback', component: CreateFeedback, name: 'add-feedback' },
    { path: '/list-feedback', component: ListFeedback, name: 'list-feedback' },
    { path: '/comment-feedback', component: CommentFeedback, name: 'comment-feedback' },
    { path: '/register', component: Register, name: 'register' },
    { path: '/login', component: Login, name: 'login' },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
