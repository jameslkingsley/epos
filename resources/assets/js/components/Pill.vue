<template>
    <i :class="classes">
        <slot></slot>
    </i>
</template>

<script>
    export default {
        props: [
            'primary',
            'info',
            'success',
            'warning',
            'danger',
            'right',
            'left'
        ],

        computed: {
            classes() {
                return {
                    pill: true,
                    primary: this.primary != null,
                    info: this.info != null,
                    success: this.success != null,
                    warning: this.warning != null,
                    danger: this.danger != null,
                    'pull-left': this.left != null,
                    'pull-right': this.right != null
                };
            }
        }
    }
</script>
