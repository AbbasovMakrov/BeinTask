<script>
export default {
    name: "Items",
    props:{
        items:{
            type:Array,
            default:[]
        },
        parentDiscount:{
            type:Number,
            default: 0
        }
    }
}
</script>

<template>
    <ol type="I" v-if="this.items.length > 0">
        <li v-for="item in this.items">
            <p>{{item.name}} ({{item.discount?.amount ?? parentDiscount}}%)</p>
        </li>
    </ol>
</template>

<style scoped>

</style>
