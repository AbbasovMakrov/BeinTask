<script>

export default {
    name: "SubCategoriesSelect",
    props:{
        categories:{
            type:Array,
            default:[],
        }
    },
    data(){
        return {
            parent_id:null,
            subCategories:[]
        };
    },
    methods:{
        fetchOtherCategories(){
            if (this.parent_id == null)
                return;
            window.axios.get(`/categories/${this.parent_id}`)
                .then(r => {
                    this.subCategories = r.data.data.category.subCategories;
                })
           let parent = this.$parent;

            while (parent.$data.model == null){
                parent = parent.$parent;
            }
            if (parent.$options.name === "CreateItem"){
                parent.$data.model.category_id = this.parent_id;
                return;
            }
            parent.$data.model.parent_id = this.parent_id;

        }
    }
}
</script>

<template>
    <div  >
        <select  v-model="this.parent_id"  @change="this.fetchOtherCategories()"  v-if="this.categories.length > 0" class="form-control mb-3" >
            <option :selected="this.parent_id == null" >
                Select Category
            </option>
            <option v-for="(category,key) in this.categories" :key="key"  :value="category.id">
                {{category.name}}
            </option>
        </select>
        <SubCategoriesSelect v-if="this.parent_id" v-model="this.parent_id" :categories="this.subCategories"></SubCategoriesSelect>
    </div>


</template>

<style scoped>

</style>
