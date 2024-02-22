import './bootstrap.js';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import mitt from 'mitt';
import { createApp } from 'vue';
import App from './components/layout/AppComponent.vue';
import router from './router.js';
const app = createApp(App);
app.component('Bootstrap5Pagination', Bootstrap5Pagination);
app.use(VueSweetalert2);

const emitter = mitt();
app.config.globalProperties.$emitter = emitter;

app.use(router);
app.mount('#app');
