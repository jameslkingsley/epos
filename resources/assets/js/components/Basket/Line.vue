<template>
    <div class="basket-line">
        <span class="basket-line-title" v-text="item.model.title"></span>
        <span class="basket-line-price" v-text="item.model.retail_price"></span>
        <span class="basket-line-qty" v-text="item.qty"></span>
        <div class="basket-line-context">
            <slot></slot>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['item']
    }
</script>
