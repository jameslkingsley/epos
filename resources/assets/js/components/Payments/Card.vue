<template>
    <md-whiteframe md-elevation="1" :class="classes">
        <span class="item-title">
            Card
        </span>

        <span class="item-price"></span>
        <span class="item-meta"></span>
    </md-whiteframe>
</template>

<script>
    export default {
        computed: {
            classes() {
                return {
                    'item-wrapper': true,
                    'cursor-pointer': true
                };
            }
        }
    }
</script>
