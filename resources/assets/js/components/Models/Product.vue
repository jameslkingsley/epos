<template>
    <md-whiteframe md-elevation="1" :class="classes" @click.native="select">
        <span class="item-title">
            {{ item.title }}
        </span>

        <span class="item-price">
            {{ item.amount }}
        </span>

        <span class="item-meta">
            {{ item.model.meta.created_at }} | {{ item.model.meta.model }}
        </span>
    </md-whiteframe>
</template>

<script>
    export default {
        props: ['item'],

        computed: {
            classes() {
                return {
                    'item-wrapper': true,
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
