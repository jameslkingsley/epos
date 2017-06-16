<template>
    <md-dialog class="action-dialog" ref="dialog">
        <md-dialog-content>
            <md-button
                class="action-dialog-option"
                v-for="(item, index) in options"
                :key="index"
                @click.native="dispatch(item)">
                {{ item.text }}
            </md-button>
        </md-dialog-content>
    </md-dialog>
</template>

<script>
    export default {
        data() {
            return {
                show: false,
                options: [],
                data: {},
                autoClose: false
            };
        },

        methods: {
            dispatch(item) {
                item.action(this);

                if (this.autoClose || (item.autoClose || false)) {
                    this.$refs.dialog.close();
                }
            }
        },

        created() {
            Event.listen('actions-options', params => {
                for (let key in params) {
                    this[key] = params[key];
                }
            });

            Event.listen('actions', state => {
                if (state) this.$refs.dialog.open();
                else this.$refs.dialog.close();
            });
        }
    }
</script>

<style lang="scss" scoped>
    .action-dialog {
        .md-dialog-content {
            padding: 1rem 0;

            .action-dialog-option {
                width: 100%;
                margin: 0;
                padding: .66rem 0;
                border-radius: 0;
                font-weight: 100;
                font-size: 16px;
            }
        }
    }
</style>
