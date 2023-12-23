import {createApp} from 'vue/dist/vue.esm-bundler.js';
import Dashboard from './Dashboard.vue';
import router from './router/index.js';
import Alert from './components/Alert.vue';

import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';




const app = createApp({});

app.component('dashboard-component', Dashboard);
app.component('VueDatePicker', VueDatePicker);
app.component('alert', Alert);

app.use(router).mount("#app");







import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
