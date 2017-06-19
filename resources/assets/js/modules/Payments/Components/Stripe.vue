<template>
    <div>
        Stripe Component
    </div>
</template>

<script>
    export default {
        props: ['form'],

        created() {
            console.log(this.form);
        }
    }
</script>
