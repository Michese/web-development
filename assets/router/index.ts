import { routerEnum } from '@/enums/routerEnum';
import { createWebHistory, createRouter } from 'vue-router';
import GeneralPage from '@/vue/components/generalPage/GeneralPage.vue';
import DetailedPage from '@/vue/components/detailedPage/DetailedPage.vue';

const routes = [
  {
    path: routerEnum.generalPage,
    name: 'Home',
    component: GeneralPage,
  },
  {
    path: routerEnum.detailedPage + '/:post',
    name: 'detailed-page',
    component: DetailedPage,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
