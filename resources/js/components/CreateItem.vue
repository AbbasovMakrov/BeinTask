<script>
import SubCategoriesSelect from "./utils/SubCategoriesSelect.vue";
import ValidationErrors from "./utils/ValidationErrors.vue";

export default {
    name: "CreateItem",
    components: {ValidationErrors, SubCategoriesSelect},
    data(){
        return {
            categories:[],
            created_item_id:null,
            data_inserted : false,
            model:{
                name:"",
                price:0,
                category_id:null
            },
            discount_model:{
               amount:null
            },
            validation_errors:{
                name:[],
                price:[],
                category_id:[],
                amount:[]
            }
        };
    },
    mounted() {
        window.axios.get("/categories",{
            params:{
                menu_id:this.$route.params.menuId
            }
        }).then(r => {
            this.categories = r.data.data.categories;
        })
    },
    methods:{
        submit(){
            window.axios.post("/items",this.model)
                .then(r => {
                    this.data_inserted = true;
                    this.created_item_id = r.data.data.item_id;
                    if (this.discount_model.amount != null){
                        window.axios.put(`/items/discount/${this.created_item_id}`,this.discount_model)
                            .then(() => {
                                console.log(`Data inserted? = ${this.data_inserted}`)
                                this.data_inserted = this.data_inserted && true;
                                console.log(`Data inserted?? = ${this.data_inserted}`)
                            }).catch(e => {
                            if (e.response.status !== 422){
                                console.log(e.response);
                                return;
                            }
                            this.validation_errors = e.response.data.validation_errors;
                        })
                    }
                }).catch(e => {
                if (e.response.status !== 422){
                    console.log(e.response);
                    return;
                }
                this.validation_errors = e.response.data.validation_errors;
            })

        }
    },
    watch:{
        data_inserted(newValue,oldValue){
            if (!newValue){
                return;
            }
            this.$swal({
                'text':'Item Added!',
                'icon':'success',
            }).then(res => {
                if (!res.isConfirmed)
                    return;
                this.$router.push(`/menus/show/${this.$route.params.menuId}`)    ;
            })
        }
    }
}
</script>

<template>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                <label for="ItemName" class="form-label">Name</label>
                <input type="text" required v-model="model.name" class="form-control" id="ItemName" placeholder="Item Name...">
                <ValidationErrors :field-errors="this.validation_errors.name"></ValidationErrors>
            </div>
            <div class="form-group mb-3">
                <label for="ItemPrice" class="form-label">Price</label>
                <input type="text" required v-model="model.price" class="form-control" id="ItemPrice" placeholder="Item Price...">
                <ValidationErrors :field-errors="this.validation_errors.price"></ValidationErrors>
            </div>

            <div class="form-group mb-3">
                <label for="suCategoriesSelect" class="form-label">Category</label>
                <SubCategoriesSelect v-model="this.model.category_id" :categories="this.categories"></SubCategoriesSelect>
                <ValidationErrors :field-errors="this.validation_errors.category_id"></ValidationErrors>
            </div>
            <div class="form-group mb-3">
                <label for="ItemDiscount" class="form-label">Discount</label>
                <input type="text" v-model="discount_model.amount" class="form-control" id="ItemDiscount" placeholder="Item Discount...">
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
