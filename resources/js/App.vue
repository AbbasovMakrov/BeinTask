<template>
    <Navbar class="mb-lg-5"></Navbar>
    <div  class="container">
        <router-view></router-view>
    </div>

</template>
<script>


import Navbar from "./components/utils/Navbar.vue";

export default {
    components: {Navbar},
    setup() {

    },
}
</script>
