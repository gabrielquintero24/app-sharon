<template>
    <div class="modal fade" id="addRecordModal" tabindex="-1" aria-labelledby="addRecordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRecordModalLabel">Agregar Nuevo Modista</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <Form @submit="submitForm" :validation-schema="schema" v-slot="{ errors }" ref="form">
                        <div class="input-group mb-3">
                            <Field name="password" type="password" v-model="form.password" class="form-control"
                                :class="{ 'is-invalid': errors['password'] }" />
                            <ErrorMessage name="password" class="invalid-feedback" />
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</template>
  
<script>
import { Form, Field, ErrorMessage } from 'vee-validate';
import * as yup from 'yup';

export default {
    components: {
        Form,
        Field,
        ErrorMessage,
    },
    data() {
        return {
            form: {
                password: '',
            },
        };
    },
    methods: {
        submitForm() {
            this.$refs.form.validate().then((isValid) => {
                if (isValid) {
                    this.$emit('save', this.form);
                    var myModalEl = document.getElementById('addRecordModal');
                    var modal = bootstrap.Modal.getInstance(myModalEl);
                    modal.hide();
                    console.log(this.form);
                    //this.form = { password: '' };
                }
            }).catch((errors) => {
                console.error("Errores de validación:", errors);
            });
        }
    },
    computed: {
        schema() {
            return yup.object({
                password: yup.string().required().min(6),
            });
        },
    },
};
</script>
