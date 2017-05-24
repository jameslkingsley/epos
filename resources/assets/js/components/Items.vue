<template>
    <div>
        <md-layout md-gutter v-for="(chunk, index) in chunked" :key="index">
            <md-layout v-for="(item, index) in chunk" :key="index">
                <component
                    :item="item"
                    v-bind:is="getComponent(item)">
                </component>
            </md-layout>
        </md-layout>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                items: []
            }
        },

        computed: {
            chunked() {
                return _.chunk(this.items, 4);
            }
        },

        methods: {
            componentExists(name) {
                return name in this.$options.components;
            },

            getComponent(item) {
                let model = 'models-' + item.model_type.split('\\').pop().toLowerCase();
                return this.componentExists(model) ? model : 'item';
            }
        },

        created() {
            Event.listen('category-items', items => this.items = items);
        }
    }
</script>
