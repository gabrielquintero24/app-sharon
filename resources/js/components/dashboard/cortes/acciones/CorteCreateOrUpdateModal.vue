<template>
    <Dialog
        v-model:visible="visible"
        :style="{ width: '450px' }"
        :header="manageCorte ? 'Agregar Corte' : 'Editar Corte'"
        :modal="true"
        class="p-fluid p-dialog-top"
        :position="'top'"
        @hide="handleDialogClose"
        ><form @submit.prevent="handleSubmit">
            <div class="p-field p-grid my-row-spacing">
                <label for="nombre" class="p-col-fixed">Nombre</label>
                <div class="p-col">
                    <InputText
                        id="nombre"
                        type="text"
                        v-model="form.nombre"
                        class="p-inputtext p-component"
                        :class="{ 'p-invalid': errors.nombre }"
                    />
                    <small v-if="errors.nombre" class="p-error">{{
                        errors.nombre
                    }}</small>
                </div>
            </div>
            <div class="p-field p-grid my-row-spacing">
                <label for="codigo_referencia" class="p-col-fixed"
                    >Codigo Referencia</label
                >
                <div class="p-col">
                    <InputText
                        id="codigo_referencia"
                        type="text"
                        v-model="form.codigo_referencia"
                        class="p-inputtext p-component"
                        :class="{ 'p-invalid': errors.codigo_referencia }"
                    />
                    <small v-if="errors.codigo_referencia" class="p-error">{{
                        errors.codigo_referencia
                    }}</small>
                </div>
            </div>
            <div class="p-field p-grid my-row-spacing">
                <label for="cantidad_entrada" class="p-col-fixed"
                    >Cantidad Entrada</label
                >
                <div class="p-col">
                    <InputNumber
                        id="cantidad_entrada"
                        type="text"
                        v-model="form.cantidad_entrada"
                        class="p-number p-component"
                        :class="{ 'p-invalid': errors.cantidad_entrada }"
                        :min="0"
                        showButtons
                    />
                    <small v-if="errors.cantidad_entrada" class="p-error">{{
                        errors.cantidad_entrada
                    }}</small>
                </div>
            </div>
            <div class="p-field p-grid my-row-spacing">
                <label for="cantidad_salida" class="p-col-fixed"
                    >Cantidad Salida</label
                >
                <div class="p-col">
                    <InputNumber
                        id="cantidad_salida"
                        type="text"
                        v-model="form.cantidad_salida"
                        class="p-number p-component"
                        :class="{ 'p-invalid': errors.cantidad_salida }"
                        :min="0"
                        showButtons
                    />
                    <small v-if="errors.cantidad_salida" class="p-error">{{
                        errors.cantidad_salida
                    }}</small>
                </div>
            </div>
            <div class="p-field p-grid my-row-spacing">
                <label for="fecha_creacion" class="p-col-fixed"
                    >Fecha Creación</label
                >
                <div class="p-col">
                    <Calendar
                        id="fecha_creacion"
                        type="text"
                        v-model="form.fecha_creacion"
                        class="p-calender p-component"
                        :class="{ 'p-invalid': errors.fecha_creacion }"
                        showIcon
                        dateFormat="dd/mm/yy" 
                    />
                    <small v-if="errors.fecha_creacion" class="p-error">{{
                        errors.fecha_creacion
                    }}</small>
                </div>
            </div>
            <Button
                label="Enviar"
                type="submit"
                class="p-button p-component p-button-primary"
                style="width: 100%; margin-top: 20px"
            />
        </form>
    </Dialog>
</template>

<script>
import * as Yup from "yup";
import InputText from "primevue/inputtext";
import InputNumber from "primevue/inputnumber";
import Calendar from "primevue/calendar";
import Dropdown from "primevue/dropdown";
import Button from "primevue/button";
import Dialog from "primevue/dialog";

export default {
    props: ["manageCorte", "dataForm", "visibleModal"],
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
        visibleModal(value) {
            this.visible = value;
        },
    },
    data() {
        return {
            form: {
                nombre: "",
                codigo_referencia: "",
                cantidad_salida: 0,
                cantidad_entrada: 0,
                fecha_creacion: "",
            },
            errors: {},
            visible: false,
        };
    },
    components: {
        InputText,
        InputNumber,
        Calendar,
        Dropdown,
        Button,
        Dialog,
    },
    mounted() {},
    created() {
        this.form = {
            nombre: "",
            codigo_referencia: "",
            cantidad_salida: 0,
            cantidad_entrada: 0,
            fecha_creacion: "",
        };
    },
    methods: {
        async validateForm() {
            const schema = Yup.object().shape({
                nombre: Yup.string().required(
                    "El nombre es un campo requerido"
                ),
                codigo_referencia: Yup.string().required(
                    "El codigo referencia es un campo requerido"
                ),
                cantidad_salida: Yup.number()
                    .typeError(
                        "La cantidad de salida debe ser un número válido"
                    )
                    .required("La cantidad de salida es obligatorio"),
                cantidad_entrada: Yup.number()
                    .nullable(true)
                    .transform((value, originalValue) =>
                        String(originalValue).trim() === "" ? null : value
                    )
                    .integer("La cantidad de entrada debe ser un número entero")
                    .typeError(
                        "La cantidad de entrada debe ser un número válido"
                    ),
                fecha_creacion: Yup.string().required(
                    "La fecha creacion es un campo requerido"
                ),
            });
            this.errors = {};
            try {
                await schema.validate(this.form, { abortEarly: false });
                return true;
            } catch (err) {
                err.inner.forEach((error) => {
                    this.errors[error.path] = error.message;
                });
                return false;
            }
        },
        async handleSubmit() {
            const isValid = await this.validateForm();
            if (isValid) {
                if (this.manageCorte) {
                    this.$emit("save", this.form);
                } else {
                    this.$emit("update", this.form);
                }
                this.handleDialogClose();
            }
        },
        resetForm() {
            this.form = {
                nombre: "",
                codigo_referencia: "",
                cantidad_salida: "",
                cantidad_entrada: "",
                fecha_creacion: "",
            };
            this.errors = {};
        },
        handleDialogClose() {
            this.resetForm();
            this.visible = false;
            this.$emit("hidden", this.visible);
        },
    },
};
</script>
