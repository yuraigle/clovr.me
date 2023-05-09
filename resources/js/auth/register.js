import '@/js/common';
import {createApp} from 'vue';
import AuthRegisterBox from './AuthRegisterBox.vue';

const app = createApp({});

app.component('auth-register-box', AuthRegisterBox);

app.mount('#app');
