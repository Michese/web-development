import '@/css/index.scss';
import { createApp, Directive } from 'vue';
import App from '@/vue/App.vue';
import router from '@/router';
import vBodyOverflow from '@/helpers/vBodyOverflow';
import vClickOutside from '@/helpers/vClickOutside';

const app = createApp(App);
app.use(router);
app.directive('bodyoverflow', vBodyOverflow as Directive);
app.directive('clickoutside', vClickOutside as Directive);
app.mount('#app');
