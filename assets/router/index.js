import { createWebHistory, createRouter } from 'vue-router';
import News from '../components/News/News.vue';
import {defineComponent} from "vue";
import New from "../components/New/New";
import CreateNew from "../components/CreateNew/CreateNew";
import UserLogin from "../components/User/UserLogin/UserLogin";
import UserRegister from "../components/User/UserRegister/UserRegister";

const routes = [
    {
        path: '/',
        name: 'Home',
        component: defineComponent(News),
    },
    {
        path: '/news/:page',
        name: 'News',
        component: defineComponent(News),
        props: true,
    },
    {
        path: '/news/create',
        name: 'CreateNew',
        component: defineComponent(CreateNew),
    },
    {
        path: '/news/:newId/edit',
        name: 'EditNew',
        props: true,
        component: defineComponent(CreateNew),
    },
    {
        path: '/new/:newId',
        name: 'New',
        props: true,
        component: defineComponent(New),
    },
    {
        path: '/user/login',
        name: 'UserLogin',
        component: defineComponent(UserLogin),
    },
    {
        path: '/user/register',
        name: 'UserRegister',
        component: defineComponent(UserRegister),
    },
    {
        path: '/*',
        redirect: { name: 'home' }
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;