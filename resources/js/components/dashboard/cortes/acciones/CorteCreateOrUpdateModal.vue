<template>
    <div
        class="modal fade"
        id="manageCorteModal"
        tabindex="-1"
        aria-labelledby="manageCorteModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manageCorteModalLabel">
                        {{ manageCorte ? "Agregar" : "Editar" }} Corte
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>
                <div class="modal-body">
                    <!-- <Form
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
                            <label for="codigo_referencia"
                                >Codigo Referencia</label
                            >
                            <Field
                                name="codigo_referencia"
                                type="text"
                                v-model="form.codigo_referencia"
                                class="form-control"
                                :class="{
                                    'is-invalid': errors['codigo_referencia'],
                                }"
                            />
                            <ErrorMessage
                                name="codigo_referencia"
                                class="invalid-feedback"
                            />
                        </div>
                        <div class="form-group mb-3">
                            <label for="cantidad_salida">Cantidad Salida</label>
                            <Field
                                name="cantidad_salida"
                                type="number"
                                v-model="form.cantidad_salida"
                                class="form-control"
                                :class="{
                                    'is-invalid': errors['cantidad_salida'],
                                }"
                            />
                            <ErrorMessage
                                name="cantidad_salida"
                                class="invalid-feedback"
                            />
                        </div>
                        <div class="form-group mb-3">
                            <label for="cantidad_entrada"
                                >Cantidad Entrada</label
                            >
                            <Field
                                name="cantidad_entrada"
                                type="text"
                                v-model="form.cantidad_entrada"
                                class="form-control"
                                :class="{
                                    'is-invalid': errors['cantidad_entrada'],
                                }"
                            />
                            <ErrorMessage
                                name="cantidad_entrada"
                                class="invalid-feedback"
                            />
                        </div>
                        <div class="form-group mb-3">
                            <label for="fecha_creacion">Fecha Creación</label>
                            <Field
                                name="fecha_creacion"
                                type="datetime-local"
                                v-model="form.fecha_creacion"
                                class="form-control"
                                :class="{
                                    'is-invalid': errors['fecha_creacion'],
                                }"
                            />
                            <ErrorMessage
                                name="fecha_creacion"
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
                    </Form> -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as yup from "yup";
import { setLocale } from "yup";
import { es } from "yup-locales";

setLocale(es);

export default {
    components: {
    },
    props: ["manageCorte", "dataForm"],
    watch: {
        dataForm(newValue) {
            if (Object.keys(newValue).length !== 0) {
                this.form = {
                    id: newValue.id,
                    nombre: newValue.nombre,
                    codigo_referencia: newValue.codigo_referencia,
                    cantidad_salida: newValue.cantidad_salida,
                    cantidad_entrada: newValue.cantidad_entrada,
                    fecha_creacion: newValue.fecha_creacion,
                };
            }
        },
    },
    data() {
        return {
            form: {
                nombre: "",
                codigo_referencia: "",
                cantidad_salida: "",
                cantidad_entrada: "",
                fecha_creacion: "",
            },
        };
    },
    mounted() {
        var myModalEl = document.getElementById("manageCorteModal");
        myModalEl.addEventListener("hidden.bs.modal", () => {
            this.resetForm();
        });
    },
    created() {
        this.form = {
            nombre: "",
            codigo_referencia: "",
            cantidad_salida: "",
            cantidad_entrada: "",
            fecha_creacion: "",
        };
    },
    methods: {
        submitForm() {
            this.$refs.form
                .validate()
                .then((isValid) => {
                    if (isValid) {
                        if (this.manageCorte) {
                            this.$emit("save", this.form);
                        } else {
                            this.$emit("update", this.form);
                        }
                        var myModalEl =
                            document.getElementById("manageCorteModal");
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
                codigo_referencia: "",
                cantidad_salida: "",
                cantidad_entrada: "",
                fecha_creacion: "",
            };
            this.$refs.form.resetForm();
        },
    },
    computed: {
        schemaCreate() {
            return yup.object({
                nombre: yup.string().required(),
                codigo_referencia: yup
                    .string()
                    .required("El codigo referencia es un campo requerido"),
                cantidad_salida: yup
                    .number()
                    .typeError(
                        "La cantidad de salida debe ser un número válido"
                    )
                    .required("La cantidad de salida es obligatorio"),
                cantidad_entrada: yup
                    .number()
                    .nullable(true)
                    .transform((value, originalValue) =>
                        String(originalValue).trim() === "" ? null : value
                    )
                    .integer("La cantidad de entrada debe ser un número entero")
                    .typeError(
                        "La cantidad de entrada debe ser un número válido"
                    ),
                fecha_creacion: yup
                    .string()
                    .required("La fecha creacion es un campo requerido"),
            });
        },
    },
};
</script>
