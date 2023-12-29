import MainComponent from "./components/MainComponent.vue";
import * as menusRoutes from "./components/Menu/routes.js"
import * as categoriesRoutes from "./components/Category/routes.js"
import CreateItem from "./components/CreateItem.vue";
export const vueRoutes = [
    {
        path: '/',
        name: 'home',
        component: MainComponent
    },
    ...menusRoutes.default,
    ...categoriesRoutes.default,
    {
        path: '/items/create/:menuId',
        name: 'items.create',
        component: CreateItem
    }
];
