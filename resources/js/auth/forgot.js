import '@/js/common';
import {createApp} from 'vue';
import AuthForgotBox from './AuthForgotBox.vue';

const app = createApp({});

app.component('auth-forgot-box', AuthForgotBox);

app.mount('#app');
