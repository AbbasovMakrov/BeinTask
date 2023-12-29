import Index from "./Index.vue";
import Create from "./Create.vue";
import Edit from "./Edit.vue";
import Show from "./Show.vue";

export default [
    {
        path: '/menus',
        name:'menus.index',
        component: Index
    },
    {
        path: "/menus/create",
        name: "menus.create",
        component: Create
    },
    {
        path: "/menus/edit/:id",
        name :"menus.edit",
        component: Edit
    },
    {
        path: "/menus/show/:id",
        name :"menus.show",
        component: Show
    },
]
