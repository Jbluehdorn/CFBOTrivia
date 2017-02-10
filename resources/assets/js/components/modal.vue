<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <i class="fa fa-close" id="modal-close-button" @click="$emit('close')"></i>
                    <div class="modal-header" v-if="header">
                        <h3>{{header}}</h3>
                    </div>
                    <slot>

                    </slot>
                </div>
            </div>
        </div>
    </transition>
</template>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 500px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
        color: #333;
        position: relative;
    }

    .modal-header {
        padding: 0;
        border-bottom: 0;
    }

    #modal-close-button {
        position: absolute;
        top: .2em;
        right: .4em;
        cursor: pointer;
        font-size: 1.1em;
    }

    /*****************
        Transitions
     *****************/
    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
</style>

<script>
    export default {
        props: ['header'],
        methods: {
            hide() {
                this.show = false;
            }
        }
    }
</script>