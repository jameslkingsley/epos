<template>
    <md-whiteframe md-elevation="1" :class="classes" @click.native="select">
        <md-ink-ripple />

        <span class="item-title">
            {{ item.model.name }}
        </span>

        <span class="item-price">
            {{ item.model.gross | currency }}
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
                    'cursor-pointer': true,
                    'no-select': true,
                    'has-discount': this.item.discounted
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
