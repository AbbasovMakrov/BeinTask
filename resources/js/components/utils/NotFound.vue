<script>
export default {
    name: "NotFound",
    props:{
        value:{
            type:Object,
            default :null
        }
    }
}
</script>

<template>
  <div  class="alert alert-danger" v-if="!this.value">
      Not Found Resource!
  </div>
</template>

<style scoped>

</style>
