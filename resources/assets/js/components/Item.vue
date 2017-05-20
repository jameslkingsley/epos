<template>
    <div :class="classes" @click="select">
        <span class="item-title">{{ item.title }}</span>

        <span class="item-price">{{ item.retail_price }}</span>

        <span class="item-meta">
            {{ item.meta.created_at }} | {{ item.meta.model }}
        </span>
    </div>
</template>

<script>
    export default {
        props: ['item'],

        computed: {
            classes() {
                return {
                    'item': true,
                    'cursor-pointer': true
                };
            }
        },

        methods: {
            select() {
                Event.fire('item-select', this.item);
            }
        }
    }
</script>
