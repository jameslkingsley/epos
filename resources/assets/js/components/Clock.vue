<template>
    <span>
        {{ day }} &middot; {{ pad(time.getHours()) }}:{{ pad(time.getMinutes()) }}:{{ pad(time.getSeconds()) }}
    </span>
</template>

<script>
    export default {
        data() {
            return {
                time: new Date()
            };
        },

        computed: {
            day() {
                return this.time.toLocaleString('en-us', {
                    weekday: 'short'
                });
            }
        },

        methods: {
            pad(n) {
                return n < 10 ? '0' + n : n;
            }
        },

        created() {
            setInterval(() => {
                this.time = new Date();
            }, 1000);
        }
    }
</script>
