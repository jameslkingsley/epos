<template>
    <div class="p-a-5">
        <md-button @click.native="open">Open Keyboard</md-button>

        <keyboard :options="keyboardOptions" />
    </div>
</template>

<script>
    export default {
        data() {
            return {
                keyboardOptions: window.KeyboardOptions
            };
        },

        methods: {
            open() {
                Keyboard.open().then(text => console.log(text));
            }
        }
    }
</script>
