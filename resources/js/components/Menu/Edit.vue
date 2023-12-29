<script>
import ValidationErrors from "../utils/ValidationErrors.vue";

export default {
    name: "Edit",
    components: {ValidationErrors},
    data() {
        return {
            model:{
                name:'',
                discount_amount:0
            },
            validation_errors:{
                name:[],
                discount_amount:[],
            },
            not_found : false
        };
    },
    mounted() {
        window.axios.get(`/menus/${this.$route.params.id}`)
            .then(r => {
                const menu = r.data.data.menu;
                this.model.name = menu.name;
                this.model.discount_amount = menu.discount.amount;
            }).catch(e => {
                const status = e.response.status;
                if (status === 404){
                    this.not_found = true;
                    return;
                }
                console.log(e);
        })
    },
    methods:{
        submit() {
            window.axios.put(`/menus/${this.$route.params.id}`,this.model)
                .then(r => {
                    if (r.status !== 204)
                    {
                        console.log(r);
                        return;
                    }

                    this.$swal({
                        title: "Menu Updated!",
                        icon: "success",
                        confirmButtonText : "OK"
                    }).then(res => {
                        if (res.isConfirmed){
                            this.$router.push("/menus");
                        }
                    });
                })
        }
    }
}
</script>

<template>
    <div class="row">
        <div class="col-md-12">
            <div v-if="this.not_found" class="alert alert-danger">
                Not Found Menu!
            </div>
            <div v-if="!this.not_found">
                <div class="form-group mb-3">
                    <label for="MenuName" class="form-label">Name</label>
                    <input type="text" v-model="model.name" class="form-control" id="MenuName" placeholder="Menu Name...">
                    <ValidationErrors :field-errors="this.validation_errors.name"></ValidationErrors>
                </div>
                <div class="form-group mb-3">
                    <label for="Discount" class="form-label">Discount</label>
                    <input type="text" v-model="model.discount_amount" class="form-control" id="Discount" placeholder="Discount..">
                    <ValidationErrors :field-errors="this.validation_errors.discount_amount"></ValidationErrors>
                </div>
                <div class="form-group">
                    <button @click="this.submit()" type="button" class="btn btn-success btn-block w-100">
                        <span class="fa fa-save"></span> Save
                    </button>
                </div>
            </div>

        </div>
    </div>

</template>

<style scoped>

</style>
