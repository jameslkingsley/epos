<template>
    <div class="basket-line">
        <span class="basket-line-title" v-text="item.title"></span>
        <span class="basket-line-price" v-text="item.amount"></span>
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
