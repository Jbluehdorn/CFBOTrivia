<template>
    <div class="editable-field">
        <div v-show="!beingEdited">
            <p>{{internalValue}}
                <i class="fa fa-pencil clickable" @click="beingEdited = true"></i>
                <i class="fa fa-close clickable" @click="deleteModalShown = true"></i>
            </p>
        </div>
        <div v-show="beingEdited">
            <input
                    type="text"
                    class="_editable_field_input"
                    v-model="internalValue"
                    @keyup.enter="beingEdited = false"
                    ref="editField">
            <i class="fa fa-check clickable" @click="beingEdited = false"></i>
        </div>

        <modal header="Delete" v-if="deleteModalShown"  @close="deleteModalShown = false">
            Are you sure you want to delete this entry?
            <button type="button" class="btn btn-primary" @click="deleteModalShown = false">Cancel</button>
            <button type="button" class="btn btn-danger" @click="remove">Delete</button>
        </modal>
    </div>
</template>

<style>
    .editable-field .fa-pencil {
        margin-left: 5px;
    }

    .editable-field .fa-pencil:hover, .editable-field .fa-check:hover {
        color: #16BB16;
    }

    .editable-field .fa-close:hover {
        color: #BB1616;
    }

    .editable-field p {
        margin-bottom: 0;
    }

    ._editable_field_input {
        padding: .1em;
        border: none;
        border-bottom: solid 1px #c9c9c9;
        transition: border 0.3s;
    }

    ._editable_field_input:focus {
        border-bottom: solid 1px #969696;
    }
</style>

<script>
    export default {
        data() {
            return {
                beingEdited: false,
                deleteModalShown: false,
                internalValue: ''
            }
        },
        props: ['value'],
        watch: {
            'internalValue': function() {
                this.$emit('input', this.internalValue);
            },
            'beingEdited': function() {
                if(this.beingEdited) {
                    var self = this;
                    Vue.nextTick(function() {
                        self.$refs.editField.focus();
                    });
                }
            }
        },
        methods: {
          remove() {
              this.deleteModalShown = false;
              this.$emit('remove');
          }
        },
        created() {
            this.internalValue = this.value;
            this.beingEdited = this.value === undefined;
        }
    }
</script>