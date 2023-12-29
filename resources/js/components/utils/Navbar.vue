<script>
export default {
    name: "Navbar"
}
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">


            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <router-link  class="nav-link"  :to="{name:'home'}" >Main</router-link>
                    <router-link  class="nav-link"  :to="{name:'menus.index'}">Menus</router-link>

                </div>
            </div>
        </div>
    </nav>
</template>

<style scoped>

</style>
