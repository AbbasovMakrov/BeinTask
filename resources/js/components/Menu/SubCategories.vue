<script>
import Items from "./Items.vue";

export default {
    name: "SubCategories",
    components: {Items},
    props:{
        categories:{
            type:Array,
            default:[],
        },
        fullView:{
            type:Boolean,
            default: false
        }
    }
}
</script>

<template>
    <ul v-if="this.categories.length> 0">
        <li :key="key" v-for="(category,key) in this.categories">
            <p>{{category.name}} <i v-if="this.fullView"> ({{ category.discount.amount }}%)</i>

             <slot :key="category.id"></slot>
            </p>
            <SubCategories :full-view="this.fullView" :categories="category.subCategories" :key="key">
                <slot :key="category.id"></slot>
            </SubCategories>
            <Items v-if="this.fullView" :parent-discount="category.discount?.amount" :items="category.items"></Items>
        </li>
    </ul>
</template>

<style scoped>

</style>
