import 'bootstrap';
import './styles/app.scss';
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import vBodyOverflow from './helpers/vBodyOverflow';
import vClickOutside from './helpers/vClickOutside';
import {stateUser, userSymbol} from "@/store";

const app = createApp(App);
app.use(router);
app.provide(userSymbol, stateUser);
app.directive('bodyoverflow', vBodyOverflow);
app.directive('clickoutside', vClickOutside);
app.mount('#app');
