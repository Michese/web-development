import { routerEnum } from '@/enums/routerEnum';
import { createWebHistory, createRouter } from 'vue-router';
import GeneralPage from '@/vue/components/generalPage/GeneralPage.vue';
import DetailedPage from '@/vue/components/detailedPage/DetailedPage.vue';
import CreatingPage from '@/vue/components/creatingPage/CreatingPage.vue';

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
  {
    path: routerEnum.creatingPage,
    name: 'creating-page',
    component: CreatingPage,
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;