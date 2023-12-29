<script>
import ValidationErrors from "../utils/ValidationErrors.vue";
import SubCategoriesSelect from "../utils/SubCategoriesSelect.vue";

export default {
    name: "Create",
    components: {SubCategoriesSelect, ValidationErrors},
    data(){
      return {
         categories:[],
          model:{
             name:"",
             menu_id:"",
             parent_id:null
          },
          validation_errors:{
             name:[],
             parent_id:[],
             amount:[]
          },
          discount_model:{
              amount:null
          },
      };
    },
    mounted() {
        this.model.menu_id = this.$route.params.menuId;
        axios.get("/categories",{
            params:{
                menu_id : this.$route.params.menuId
            }
        }).then(r => this.categories = r.data.data.categories);
    },
    methods:{
        submit(){
            window.axios.post("/categories",this.model)
                .then(r => {
                    if (this.discount_model.amount != null){
                        window.axios.put(`/categories/discount/${r.data.data.category_id}`,this.discount_model)
                            .then().catch(e => {
                            if (e.response.status !== 422){
                                console.log(e.response);
                                return;
                            }
                            this.validation_errors = e.response.data.validation_errors;
                        })
                    }
                    this.$swal({
                        'text':'Category Added!',
                        'icon':'success',
                    }).then(res => {
                        if (!res.isConfirmed)
                            return;
                    this.$router.push(`/categories/${this.model.menu_id}`)    ;
                    })
                }).catch(e => {
                    if (e.response.status !== 422){
                        console.log(e.response);
                        return;
                    }
                    this.validation_errors = e.response.data.validation_errors;
            })
        }
    }
}
</script>

<template>
<div class="row">
    <div class="col-md-12">
        <div class="form-group mb-3">
            <label for="CategoryName" class="form-label">Name</label>
            <input type="text" required v-model="model.name" class="form-control" id="CategoryName" placeholder="Category Name...">
            <ValidationErrors :field-errors="this.validation_errors.name"></ValidationErrors>
        </div>
        <div class="form-group mb-3">
            <label for="suCategoriesSelect" class="form-label">Category</label>
            <SubCategoriesSelect v-model="this.model.parent_id" :categories="this.categories"></SubCategoriesSelect>
            <ValidationErrors :field-errors="this.validation_errors.parent_id"></ValidationErrors>
        </div>
        <div class="form-group mb-3">
            <label for="ItemDiscount" class="form-label">Discount</label>
            <input type="text" v-model="discount_model.amount" class="form-control" id="ItemDiscount" placeholder="Discount...">
            <ValidationErrors :field-errors="this.validation_errors.amount"></ValidationErrors>
        </div>
        <div class="form-group mb-3">
            <button @click="this.submit" class="btn btn-success btn-block w-100">
                <span class="fa fa-save"></span> Save
            </button>
        </div>

    </div>

</div>
</template>

<style scoped>

</style>
