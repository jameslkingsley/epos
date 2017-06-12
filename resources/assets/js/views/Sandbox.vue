<template>
    <div class="p-a-5">
        <md-button @click.native="open">Open Keypad</md-button>

        <keypad :options="keypadOptions" />
    </div>
</template>

<script>
    export default {
        data() {
            return {
                keypadOptions: window.KeypadOptions
            }
        },

        methods: {
            open() {
                Keypad.open({
                    minimum: 25
                }).then(value => console.log(value));
            }
        }
    }
</script>
