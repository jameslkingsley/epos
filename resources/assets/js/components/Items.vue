<template>
    <div>
        <component
            v-for="item in items"
            :key="item._link.id"
            :item="item"
            v-bind:is="getComponent(item)">
        </component>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                items: []
            }
        },

        methods: {
            componentExists(name) {
                return name in this.$options.components;
            },

            getComponent(item) {
                let model = 'models-' + item._link.model_type.split('\\').pop().toLowerCase();
                return this.componentExists(model) ? model : 'item';
            }
        },

        created() {
            Event.listen('category-items', items => this.items = items);
        }
    }
</script>
