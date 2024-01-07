<template>
    <div
        class="modal fade"
        id="addRecordModal"
        tabindex="-1"
        aria-labelledby="addRecordModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addRecordModalLabel">
                        {{ manageModista ? "Agregar" : "Editar" }} Modista
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <Form
                        @submit="submitForm"
                        :validation-schema="schemaCreate"
                        v-slot="{ errors }"
                        ref="form"
                    >
                        <div class="form-group mb-3">
                            <label for="nombre">Nombre</label>
                            <Field
                                name="nombre"
                                type="text"
                                v-model="form.nombre"
                                class="form-control"
                                :class="{ 'is-invalid': errors['nombre'] }"
                            />
                            <ErrorMessage
                                name="nombre"
                                class="invalid-feedback"
                            />
                        </div>
                        <div class="form-group mb-3">
                            <label for="direccion">Dirección</label>
                            <Field
                                name="direccion"
                                type="text"
                                v-model="form.direccion"
                                class="form-control"
                                :class="{ 'is-invalid': errors['direccion'] }"
                            />
                            <ErrorMessage
                                name="direccion"
                                class="invalid-feedback"
                            />
                        </div>
                        <div class="form-group mb-3">
                            <label for="celular">Celular</label>
                            <Field
                                id="celular"
                                name="celular"
                                type="number"
                                v-model="form.celular"
                                class="form-control"
                                :class="{ 'is-invalid': errors['celular'] }"
                            />
                            <ErrorMessage
                                name="celular"
                                class="invalid-feedback"
                            />
                        </div>
                        <button
                            type="submit"
                            class="btn btn-primary"
                            style="width: 100%"
                        >
                            Guardar
                        </button>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Form, Field, ErrorMessage } from "vee-validate";
import * as yup from "yup";
import { setLocale } from "yup";
import { es } from "yup-locales";

setLocale(es);

export default {
    components: {
        Form,
        Field,
        ErrorMessage,
    },
    props: ["manageModista", "dataForm"],
    watch: {
        dataForm(newValue) {
            if (Object.keys(newValue).length !== 0) {
                this.form = {
                    id: newValue.id,
                    nombre: newValue.nombre,
                    direccion: newValue.direccion,
                    celular: newValue.celular,
                };
            }
        },
    },
    data() {
        return {
            form: {
                nombre: "",
                direccion: "",
                celular: "",
            },
        };
    },
    mounted() {
        var myModalEl = document.getElementById("addRecordModal");
        myModalEl.addEventListener("hidden.bs.modal", () => {
            this.resetForm();
        });
    },
    created() {
        this.form = {
            nombre: "",
            direccion: "",
            celular: "",
        };
    },
    methods: {
        submitForm() {
            this.$refs.form
                .validate()
                .then((isValid) => {
                    if (isValid) {
                        if (this.manageModista) {
                            this.$emit("save", this.form);
                        } else {
                            this.$emit("update", this.form);
                        }
                        var myModalEl =
                            document.getElementById("addRecordModal");
                        var modal = bootstrap.Modal.getInstance(myModalEl);
                        modal.hide();
                    }
                })
                .catch((errors) => {
                    console.error("Errores de validación:", errors);
                });
        },
        resetForm() {
            this.form = {
                nombre: "",
                direccion: "",
                celular: "",
            };
            this.$refs.form.resetForm();
        },
    },
    computed: {
        schemaCreate() {
            return yup.object({
                nombre: yup.string().required(),
                direccion: yup.string().required(),
                celular: yup
                    .number()
                    .typeError("El celular debe ser un número válido")
                    .required("El número de celular es obligatorio"),
            });
        },
    },
};
</script>
