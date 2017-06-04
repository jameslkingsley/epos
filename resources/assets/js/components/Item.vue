<template>
    <div :class="classes" @click="select">
        <span class="item-title">{{ item.model_type }} : {{ item.model_id }}</span>
        <span class="item-price"></span>
        <span class="item-meta"></span>
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
