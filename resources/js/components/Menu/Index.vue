<script>
export default {
    name: "Index",
    mounted() {
        window.axios.get("/menus").then(r => {
            this.menus = r.data.data.menus;
            localStorage.setItem("menus",JSON.stringify(this.menus))
        }).catch(e => {
            console.log(e);
            if (localStorage.getItem("menus") !== undefined){
                this.menus = JSON.parse(localStorage.getItem("menus"));
            }
        });
    },
    data() {
        return {
            menus:[]
        }
    },
    methods:{
        deleteMenu(id){
             this.$swal({
                 'title' : 'Are you sure ?',
                 'icon' : 'info',
                 'text':'After clicking delete you can not return back',
                 'confirmButtonText' : 'Confirm'
             }).then(r => {
                 if (r.isConfirmed)
                     this.confirmDeleteMenu(id)
             });
        },
        confirmDeleteMenu(id) {
            window.axios.delete(`/menus/${id}`)
                .then(r => {
                    if (r.status !== 204){
                        console.log(r);
                        return;
                    }
                    this.$swal({
                        'title' : 'Menu Deleted!',
                        'icon' : 'success',
                        'confirmButtonText' : 'OK'
                    }).then(s => {
                        if (s.isConfirmed)
                            window.location.reload();
                    })
                })
        }
    }

}
</script>
<template>
    <div class="row">
        <div class="col-md-12 form-group">
            <router-link  to="/menus/create" class="btn btn-lg btn-primary btn-block w-100 mb-5" >
                <span class="fa fa-plus"></span> Add
            </router-link>
        </div>
    </div>
    <div class="row">

        <div v-for="menu in this.menus" class="col-sm-3">
            <div  class="card">
                <div class="card-body">
                    <router-link  :to="'/menus/show/' + menu.id">
                        <h5 class="card-title">{{menu.name}}</h5>
                    </router-link>
                    <router-link class="btn btn-info text-white"  :to="{
                        name:'menus.edit',
                        params:{
                           id:menu.id
                        }
                    }">
                        <span class="fa fa-edit"></span> Edit
                    </router-link>
                    <button @click="this.deleteMenu(menu.id)" style="margin-left: 12px" class="btn btn-danger">
                        <span class="fa fa-trash"></span> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>

</style>
