<template>
    <Dialog
        v-model:visible="visible"
        :style="{ width: '450px' }"
        :header="manageVinculado ? 'Agregar Vinculacion' : 'Editar Vinculacion'"
        :modal="true"
        class="p-fluid p-dialog-top"
        :position="'top'"
        @hide="handleDialogClose"
        ><form @submit.prevent="handleSubmit">
            <div class="p-field p-grid my-row-spacing">
                <label for="tipo" class="p-col-fixed" style="width: 100px"
                    >Cortes</label
                >
                <div class="p-col">
                    <Dropdown
                        v-model="form.corte_id"
                        :options="listCortes"
                        optionLabel="nombre"
                        optionValue="id"
                        placeholder="Seleccione un tipo"
                        class="p-dropdown p-component"
                        :class="{ 'p-invalid': errors.corte_id }"
                        showClear
                        filter
                    />
                    <small v-if="errors.corte_id" class="p-error">{{
                        errors.corte_id
                    }}</small>
                </div>
            </div>
            <div class="p-field p-grid my-row-spacing">
                <label for="tipo" class="p-col-fixed" style="width: 100px"
                    >Especificaciones</label
                >
                <div class="p-col">
                    <Dropdown
                        v-model="form.especificacion_id"
                        :options="listEspecificaciones"
                        optionLabel="nombre"
                        optionValue="id"
                        placeholder="Seleccione un tipo"
                        class="p-dropdown p-component"
                        :class="{ 'p-invalid': errors.especificacion_id }"
                        showClear
                        filter
                    />
                    <small v-if="errors.especificacion_id" class="p-error">{{
                        errors.especificacion_id
                    }}</small>
                </div>
            </div>
            <div class="p-field p-grid my-row-spacing">
                <label for="cantidad" class="p-col-fixed">Cantidad</label>
                <div class="p-col">
                    <InputNumber
                        id="cantidad"
                        v-model="form.cantidad"
                        class="p-number p-component"
                        :class="{ 'p-invalid': errors.cantidad }"
                        :min="0"
                        showButtons
                    />
                    <small v-if="errors.cantidad" class="p-error">{{
                        errors.cantidad
                    }}</small>
                </div>
            </div>
            <div class="p-field p-grid my-row-spacing">
                <label for="precio" class="p-col-fixed">Precio</label>
                <div class="p-col">
                    <InputNumber
                        id="precio"
                        v-model="form.precio"
                        class="p-number p-component"
                        :class="{ 'p-invalid': errors.precio }"
                        :min="0"
                        showButtons
                    />
                    <small v-if="errors.precio" class="p-error">{{
                        errors.precio
                    }}</small>
                </div>
            </div>
            <Button
                label="Guardar"
                type="submit"
                class="p-button p-button-primary custom-button-primary"
                style="width: 100%; margin-top: 20px"
            />
        </form>
    </Dialog>
</template>

<script>
import * as Yup from "yup";

export default {
    props: ["manageVinculado", "dataForm", "visibleModal"],
    watch: {
        dataForm(newValue) {
            if (Object.keys(newValue).length !== 0) {
                this.form = {
                    id: newValue.id,
                    corte_id: newValue.corte_id,
                    especificacion_id: newValue.especificacion_id,
                    cantidad: newValue.cantidad,
                    precio: newValue.precio,
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
                corte_id: "",
                especificacion_id: "",
                cantidad: 0,
                precio: 0,
            },
            errors: {},
            visible: false,
            listCortes: [],
            listEspecificaciones: [],
        };
    },
    components: {},
    mounted() {},
    created() {
        this.getListSelects();
        this.form = {
            corte_id: "",
            especificacion_id: "",
            cantidad: 0,
            precio: 0,
        };
    },
    methods: {
        async validateForm() {
            const schema = Yup.object().shape({
                corte_id: Yup.string().required(
                    "El corte es un campo requerido"
                ),
                especificacion_id: Yup.string().required(
                    "La especificacion es un campo requerido"
                ),
                cantidad: Yup.number()
                    .typeError("La cantidad debe ser un número válido")
                    .required("La cantidad es obligatorio"),
                precio: Yup.number()
                    .typeError("El precio debe ser un número válido")
                    .required("El precio es obligatorio"),
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
                if (this.manageVinculado) {
                    this.$emit("save", this.form);
                } else {
                    this.$emit("update", this.form);
                }
                this.handleDialogClose();
            }
        },
        resetForm() {
            this.form = {
                corte_id: "",
                especificacion_id: "",
                cantidad: 0,
                precio: 0,
            };
            this.errors = {};
        },
        handleDialogClose() {
            this.resetForm();
            this.visible = false;
            this.$emit("hidden", this.visible);
        },
        async getListSelects() {
            this.listCortes = await this.$listCorteNombresAndIds();
            this.listEspecificaciones =
                await this.$listEspecificacionNombresAndIds();
        },
    },
};
</script>
