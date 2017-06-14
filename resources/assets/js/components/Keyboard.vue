<template>
    <div>
        <div class="keyboard-cover" v-if="show" @click="cancel"></div>

        <transition name="slide">
            <md-whiteframe class="keyboard" v-if="show">
                <div class="keyboard-row">
                    <input type="text" class="keyboard-input" v-model="text">
                </div>

                <div class="keyboard-row" v-for="(row, index) in keys">
                    <span
                        v-for="(key, index) in row"
                        :class="keyClasses(key)"
                        :style="getStyle(key)"
                        @click="getMethod(key)">
                        <md-ink-ripple></md-ink-ripple>
                        <span v-html="key.lower" v-if="!('upper' in key) || !shifted"></span>
                        <span v-html="key.upper" v-if="'upper' in key && shifted"></span>
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
                text: '',
                shifted: true,
                caps: false,
                show: false,
                keys: [
                    [
                        {lower: '1', upper: '!'},
                        {lower: '2', upper: '"'},
                        {lower: '3', upper: '£'},
                        {lower: '4', upper: '$'},
                        {lower: '5', upper: '%'},
                        {lower: '6', upper: '^'},
                        {lower: '7', upper: '&'},
                        {lower: '8', upper: '*'},
                        {lower: '9', upper: '('},
                        {lower: '0', upper: ')'}
                    ],
                    [
                        {lower: 'q', upper: 'Q'},
                        {lower: 'w', upper: 'W'},
                        {lower: 'e', upper: 'E'},
                        {lower: 'r', upper: 'R'},
                        {lower: 't', upper: 'T'},
                        {lower: 'y', upper: 'Y'},
                        {lower: 'u', upper: 'U'},
                        {lower: 'i', upper: 'I'},
                        {lower: 'o', upper: 'O'},
                        {lower: 'p', upper: 'P'}
                    ],
                    [
                        {lower: 'a', upper: 'A'},
                        {lower: 's', upper: 'S'},
                        {lower: 'd', upper: 'D'},
                        {lower: 'f', upper: 'F'},
                        {lower: 'g', upper: 'G'},
                        {lower: 'h', upper: 'H'},
                        {lower: 'j', upper: 'J'},
                        {lower: 'k', upper: 'K'},
                        {lower: 'l', upper: 'L'}
                    ],
                    [
                        {lower: '<i class="material-icons" style="line-height:inherit">keyboard_arrow_up</i>', method: this.shift, unfixed: true},
                        {lower: 'z', upper: 'Z'},
                        {lower: 'x', upper: 'X'},
                        {lower: 'c', upper: 'C'},
                        {lower: 'v', upper: 'V'},
                        {lower: 'b', upper: 'B'},
                        {lower: 'n', upper: 'N'},
                        {lower: 'm', upper: 'M'},
                        {lower: '<i class="material-icons" style="line-height:inherit">backspace</i>', method: this.backspace, unfixed: true}
                    ],
                    [
                        {lower: ','},
                        {lower: 'Space', unfixed: true, method: this.space},
                        {lower: '.'},
                        {lower: '<i class="material-icons" style="line-height:inherit">keyboard_return</i>', method: this.confirm, accent: 'primary'}
                    ]
                ]
            };
        },

        methods: {
            keyClasses(key) {
                let classes = {
                    'keyboard-key': true,
                    'has-ripple': true
                };

                if ('accent' in key) {
                    classes['accent-' + key.accent] = true;
                }

                return classes;
            },

            getMethod(key) {
                return ('method' in key)
                    ? key.method(key)
                    : this.handleKey(key);
            },

            getStyle(key) {
                return ('unfixed' in key)
                    ? 'max-width: none;'
                    : '';
            },

            handleKey(key) {
                this.text += this.shifted ? key.upper : key.lower;

                if (!this.caps) {
                    this.shifted = false;
                }
            },

            backspace() {
                this.text = this.text.slice(0, -1);
            },

            shift() {
                this.shifted = !this.shifted;
            },

            space() {
                this.text += ' ';
            },

            capsLock() {
                this.caps = !this.caps;
                this.shifted = !this.shifted;
            },

            clear() {
                this.text = '';
                this.show = false;
                this.shifted = true;
            },

            cancel() {
                Event.fire('keyboard-cancel');
                this.clear();
            },

            confirm() {
                Event.fire('keyboard-confirm', this.text);
                this.clear();
            }
        },

        created() {
            Event.listen('keyboard', state => this.show = state);
            Event.listen('keyboard-options', options => {
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
    .keyboard-cover {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 999;
    }

    .keyboard {
        position: fixed;
        bottom: 5%;
        left: 50%;
        transform: translate(-50%, 0);
        z-index: 1000;

        &.shake {
            animation: shake .5s cubic-bezier(.36, .07, .19, .97) both;
            transform: translate(-50%, 0);
        }

        .keyboard-error {
            color: #de4444;
            justify-content: center;
            height: 5vh;
            line-height: 5vh;
            display: flex;
            flex: 1;
            font-size: 16px;
        }

        .keyboard-input {
            display: flex;
            flex: 1;
            border: none;
            border-bottom: 1px solid #eee;
            padding: 4vh 0;
            height: 0;
            text-align: center;
            font-size: 22px;
            outline: 0;
        }

        .keyboard-row {
            display: flex;
            flex: 1;
            justify-content: center;

            .keyboard-key {
                display: flex;
                flex: 1;
                height: 8vh;
                min-width: 8vh;
                max-width: 8vh;
                line-height: 8vh;
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
            transform: translate(-55%, 0);
        }

        20%, 80% {
            transform: translate(-45%, 0);
        }

        30%, 50%, 70% {
            transform: translate(-60%, 0);
        }

        40%, 60% {
            transform: translate(-40%, 0);
        }
    }
</style>
