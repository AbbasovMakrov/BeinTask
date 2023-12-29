<script>
import SubCategories from "./SubCategories.vue";

export default {
    components: {SubCategories},
    data() {
        return {
            menu: null,
        };
    },
    mounted() {
        window.axios.get(`/menus/${this.$route.params.id}`, {
            params: {
                all_details: true
            }
        })
            .then(r => {
                this.menu = r.data.data.menu;
                console.log(this.menu.categories)
            })
            .catch(err => {
                if (err.response.status !== 404) {
                    console.log(err.response);
                }
            });

    },
    name: "Show"
}
</script>

<template>
    <div class="row">
        <div class="col-md-12">
            <div v-if="!this.menu" class="alert alert-danger">
                Not Found Menu!
            </div>
            <div v-if="this.menu">
                <table class="table table-bordered table-responsive">
                    <tr>
                        <th>Menu Name</th>
                        <td>{{ menu.name }}</td>
                    </tr>
                    <tr>
                        <th>Discount</th>
                        <td>{{ menu.discount?.amount }}%</td>
                    </tr>
                    <tr>
                        <th>Related</th>
                        <td><router-link :to="{name:'categories.index',params:{menuId : menu.id}}">Categories</router-link></td>
                    </tr>
                </table>
                <div :key="key" v-for="(category,key) in this.menu.categories">
                    <h1>{{category.name}} ({{category.discount.amount}}%)</h1>
                    <SubCategories :full-view="true" :categories="category.subCategories"></SubCategories>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
