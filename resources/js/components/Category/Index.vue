<script>
import SubCategories from "../Menu/SubCategories.vue";

export default {
    name: "Index",
    components: {SubCategories},
    data() {
        return {
            categories:[]
        }
    },
    mounted() {
        window.axios.get("/categories",{
            params:{
                menu_id:this.$route.params.menuId
            }
        }).then(r => this.categories = r.data.data.categories);
    },
}
</script>

<template>
<div class="row">
    <div class="col-md-12">
        <div>
            <router-link class="btn btn-success mb-3 btn-block w-100" :to="{name:'categories.create',params :{ menuId : this.$route.params.menuId}}">
                <span class="fa fa-plus"></span> Add Category
            </router-link>
            <router-link class="btn btn-success btn-block w-100" :to="{name:'items.create',params :{ menuId : this.$route.params.menuId}}">
                <span class="fa fa-plus"></span> Add Item
            </router-link>

        </div>
        <div :key="key" v-for="(category,key) in this.categories">
            <div>
                <h1>{{category.name}}</h1>
            </div>


            <SubCategories :categories="category.subCategories">

            </SubCategories>
        </div>
    </div>
</div>
</template>

<style scoped>

</style>
