<template>
    <div>
        <div class="card col-lg-3 col-sm-6 cursor-pointer" v-for="product in products">
            <div class="content" style="padding: 15px 0 10px 0;">
                <div class="row">
                    <div class="col-xs-5">
                        <div class="text-left f-18">
                            {{ product.name }}
                        </div>
                    </div>

                    <div class="col-xs-7">
                        <div class="numbers">
                            <p>Price</p>
                            {{ product.prices[0].trade }}
                        </div>
                    </div>
                </div>

                <div class="footer">
                    <hr />
                    <div class="stats">
                        No deals available
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                products: []
            }
        },

        created() {
            Event.listen('products', products => this.products = products);
        }
    }
</script>
