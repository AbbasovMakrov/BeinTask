<script>
import ValidationErrors from "../utils/ValidationErrors.vue";

export default {
    name: "Create",
    components: {ValidationErrors},
    data() {
        return {
            model:{
                name:'',
                discount_amount:0
            },
            validation_errors:{
                name:[],
                discount_amount:[]
            }
        };
    },
    methods: {
        submit(){
            window.axios.post("/menus",this.model)
                .then(r => {
                      if (r.status === 201){
                          this.$router.push("/menus");
                      }
                }).catch(e => {
                    if (e.response.status === 422){
                        this.validation_errors = e.response.data.validation_errors;
                        return;
                    }
                    console.log(e.response);
            });
        }
    }
}
</script>

<template>
    <div class="col-md-12">
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
            <button v-on:click="this.submit()" type="button" class="btn btn-success btn-block w-100">
                <span class="fa fa-save"></span> Save
            </button>
        </div>
    </div>

</template>

<style scoped>

</style>
