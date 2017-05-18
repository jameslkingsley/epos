<template>
    <div :class="classes" @click="select">
        <div class="content" style="padding: 15px 0 10px 0;">
            <div class="row">
                <div class="col-xs-5">
                    <div class="text-left f-18">
                        {{ item.title }}
                    </div>
                </div>

                <div class="col-xs-7">
                    <div class="numbers">
                        <p>Price</p>
                        {{ item.price }}
                    </div>
                </div>
            </div>

            <div class="footer">
                <hr />
                <div class="stats">
                    {{ item.meta.created_at }} | {{ item.meta.model }}
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['item'],

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
                Event.fire('item-select', this.item);
            }
        }
    }
</script>
