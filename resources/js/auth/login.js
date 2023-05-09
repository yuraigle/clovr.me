import '@/js/common';
import {createApp} from 'vue';
import AuthLoginBox from './AuthLoginBox.vue';

const app = createApp({});

app.component('auth-login-box', AuthLoginBox);

Object
    .entries(import.meta.glob('./*.vue', {eager: true}))
    .forEach(([path, definition]) => app.component(path.split('/')
        .pop().replace(/\.\w+$/, ''), definition.default)
    );

app.mount('#app');
