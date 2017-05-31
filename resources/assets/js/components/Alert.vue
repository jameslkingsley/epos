<template>
    <md-snackbar :md-position="position" ref="snackbar" :md-duration="duration">
        <span v-text="text"></span>
    </md-snackbar>
</template>

<script>
    export default {
        data() {
            return {
                vertical: 'top',
                horizontal: 'center',
                duration: 3000,
                text: ''
            };
        },

        computed: {
            position() {
                return this.vertical + ' ' + this.horizontal;
            }
        },

        methods: {
            open() {
                this.$refs.snackbar.open();
            }
        },

        created() {
            Event.listen('alert', text => {
                this.text = text;
                this.open();
            });
        }
    }
</script>
