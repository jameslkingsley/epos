<template>
    <div>
        <div class="keypad-cover" v-if="show" @click="cancel"></div>

        <transition name="slide">
            <md-whiteframe :class="classes" v-if="show">
                <div class="keypad-row keypad-error" v-if="errorMessage.length > 0">
                    {{ errorMessage }}
                </div>

                <div class="keypad-row">
                    <input type="text" class="keypad-input" v-model="displayValue">
                </div>

                <div class="keypad-row" v-for="(row, index) in keys">
                    <span
                        class="keypad-key has-ripple"
                        v-for="(key, index) in row"
                        @click="key.method(key)">
                        <md-ink-ripple></md-ink-ripple>
                        <span v-html="key.text"></span>
                    </span>
                </div>

                <div class="keypad-row">
                    <span class="keypad-key has-ripple" @click="confirm">
                        <md-ink-ripple></md-ink-ripple>
                        Enter
                    </span>
                </div>
            </md-whiteframe>
        </transition>
    </div>
</template>

<script>
    export default {
        props: {
            options: {
                type: Object,
                default: {}
            }
        },

        data() {
            return {
                value: '',
                errorMessage: '',
                show: false,
                shouldShake: false,
                currency: null,
                autocomplete: null,
                minimum: null,
                maximum: null,
                keys: [
                    [
                        {text: '7', method: this.handleKey},
                        {text: '8', method: this.handleKey},
                        {text: '9', method: this.handleKey}
                    ],
                    [
                        {text: '4', method: this.handleKey},
                        {text: '5', method: this.handleKey},
                        {text: '6', method: this.handleKey}
                    ],
                    [
                        {text: '1', method: this.handleKey},
                        {text: '2', method: this.handleKey},
                        {text: '3', method: this.handleKey}
                    ],
                    [
                        {text: '0', method: this.handleKey},
                        {text: '00', method: this.handleKey},
                        {text: '<i class="material-icons" style="line-height:inherit">backspace</i>', method: this.backspace}
                    ]
                ]
            };
        },

        computed: {
            displayValue() {
                return this.currency
                    ? this.formatAsCurrency(this.value)
                    : this.value;
            },

            classes() {
                return {
                    'keypad': true,
                    'shake': this.shouldShake
                };
            }
        },

        methods: {
            handleKey(key) {
                this.value += key.text;

                // Emit keypress event
                this.$emit('keypress', {
                    key: key,
                    value: this.value
                });

                if (this.hasErrors()) return;

                // Confirm if auto-completed
                if (this.isAutoCompleted()) this.confirm();
            },

            hasErrors() {
                // Minimum number value
                if (this.minimum && Number(this.value) < this.minimum) {
                    return this.hasError(
                        'Minimum value of ' + (this.currency
                            ? this.formatAsCurrency(this.minimum)
                            : this.minimum)
                        );
                }

                // Maximum number value
                if (this.maximum && Number(this.value) > this.maximum) {
                    return this.hasError(
                        'Maximum value of ' + (this.currency
                            ? this.formatAsCurrency(this.maximum)
                            : this.maximum)
                        );
                }

                this.errorMessage = '';
                return false;
            },

            hasError(text) {
                this.errorMessage = text;
                return true;
            },

            backspace(key) {
                this.value = this.value.slice(0, -1);
                this.hasErrors();
            },

            shake() {
                this.shouldShake = true;

                setTimeout(() => this.shouldShake = false, 500);
            },

            confirm() {
                if (this.hasErrors()) {
                    return this.shake();
                }

                Event.fire('keypad-confirm', this.value);
                this.clear();
            },

            cancel() {
                Event.fire('keypad-cancel');
                this.clear();
            },

            clear() {
                this.value = '';
                this.errorMessage = '';
                this.show = false;
                this.shouldShake = false;
            },

            formatAsCurrency(value) {
                let langage = (navigator.language || navigator.browserLanguage).split('-')[0];

                return (value / 100).toLocaleString(langage, {
                    style: 'currency',
                    currency: this.currency
                });
            },

            isAutoCompleted() {
                return this.autocomplete && this.value.length == this.autocomplete;
            }
        },

        created() {
            Event.listen('keypad', state => this.show = state);
            Event.listen('keypad-options', options => {
                for (let key in options) {
                    this[key] = options[key];
                }
            });

            for (let key in this.options) {
                this[key] = this.options[key];
            }
        }
    }
</script>

<style lang="scss" scoped>
    .keypad-cover {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 999;
    }

    .keypad {
        position: fixed;
        width: 300px;
        left: calc(50% - 150px);
        right: calc(50% - 150px);
        bottom: 5%;
        z-index: 1000;

        &.shake {
            animation: shake .5s cubic-bezier(.36, .07, .19, .97) both;
            transform: translate3d(0, 0, 0);
        }

        .keypad-error {
            color: #de4444;
            justify-content: center;
            height: 5vh;
            line-height: 5vh;
            display: flex;
            flex: 1;
            font-size: 16px;
        }

        .keypad-input {
            display: flex;
            flex: 1;
            border: none;
            border-bottom: 1px solid #eee;
            padding: 5vh 0;
            height: 0;
            text-align: center;
            font-size: 22px;
            outline: 0;
        }

        .keypad-row {
            display: flex;
            flex: 1;

            .keypad-key {
                display: flex;
                flex: 1;
                height: 10vh;
                line-height: 10vh;
                justify-content: center;
                font-size: 22px;
                cursor: pointer;
                user-select: none;

                &.has-ripple {
                    position: relative;
                }

                &:hover {
                    background: #f2f2f2;
                }
            }
        }
    }

    .slide-enter-active, .slide-leave-active {
        transition: bottom .25s cubic-bezier(.55, 0, .1, 1);
    }

    .slide-enter, .slide-leave-to {
        bottom: -100%;
    }

    @keyframes shake {
        10%, 90% {
            transform: translate3d(-2px, 0, 0);
        }

        20%, 80% {
            transform: translate3d(4px, 0, 0);
        }

        30%, 50%, 70% {
            transform: translate3d(-6px, 0, 0);
        }

        40%, 60% {
            transform: translate3d(8px, 0, 0);
        }
    }
</style>
