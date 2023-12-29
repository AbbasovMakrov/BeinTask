import Index from "./Index.vue";
import Create from "./Create.vue";

export default [
    {
      path:"/categories/:menuId",
      name:"categories.index",
      component:Index
    },
    {
      path:"/categories/create/:menuId",
      name:"categories.create",
      component:Create
    },

];
