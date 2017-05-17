<template>
    <div :class="classes" @click="select">
        <div class="content" style="padding: 15px 0 10px 0;">
            <div class="row">
                <div class="col-xs-5">
                    <div class="text-left f-18">
                        {{ product.title }}
                    </div>
                </div>

                <div class="col-xs-7">
                    <div class="numbers">
                        <p>Price</p>
                        {{ product.price }}
                    </div>
                </div>
            </div>

            <div class="footer">
                <hr />
                <div class="stats">
                    {{ product.meta.created_at }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['product'],

        computed: {
            classes() {
                return {
                    'card': true,
                    'cursor-pointer': true
                };
            }
        },

        methods: {
            select() {
                Event.fire('product-select', this.product);
            }
        },

        created() {
            for (let key in this.product)
                this[key] = this.product[key];
        }
    }
</script>
