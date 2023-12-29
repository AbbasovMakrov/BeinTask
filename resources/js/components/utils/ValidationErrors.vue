<script>
export default {
    name: "ValidationErrors",
    props:{
        fieldErrors : {
            type:Array,
            default:[]
        }
    }
}
</script>

<template>
    <div v-if="this.fieldErrors.length > 0" v-for="err in this.fieldErrors" class="text-danger">{{err}}</div>

</template>

<style scoped>

</style>
