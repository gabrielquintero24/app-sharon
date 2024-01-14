<template>
    <Dialog
        v-model:visible="visible"
        :style="{ width: '450px' }"
        :header="manageModista ? 'Agregar Modista' : 'Editar Modista'"
        :modal="true"
        class="p-fluid p-dialog-top"
        :position="'top'"
        @hide="handleDialogClose"
    >
        <form @submit.prevent="handleSubmit">
            <div class="p-field p-grid my-row-spacing">
                <label for="nombre" class="p-col-fixed" style="width: 100px"
                    >Nombre</label
                >
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
                <label for="direccion" class="p-col-fixed" style="width: 100px"
                    >Dirección</label
                >
                <div class="p-col">
                    <InputText
                        id="direccion"
                        type="text"
                        v-model="form.direccion"
                        class="p-inputtext p-component"
                        :class="{ 'p-invalid': errors.direccion }"
                    />
                    <small v-if="errors.direccion" class="p-error">{{
                        errors.direccion
                    }}</small>
                </div>
            </div>
            <div class="p-field p-grid my-row-spacing">
                <label for="celular" class="p-col-fixed" style="width: 100px"
                    >Celular</label
                >
                <div class="p-col">
                    <InputText
                        id="celular"
                        type="text"
                        v-model="form.celular"
                        class="p-inputtext p-component"
                        :class="{ 'p-invalid': errors.celular }"
                    />
                    <small v-if="errors.celular" class="p-error">{{
                        errors.celular
                    }}</small>
                </div>
            </div>
            <div class="p-field p-grid my-row-spacing">
                <label for="tipo" class="p-col-fixed" style="width: 100px"
                    >Tipo</label
                >
                <div class="p-col">
                    <Dropdown
                        id="tipo"
                        v-model="form.tipo_modista_id"
                        :options="rpTipoModista"
                        optionLabel="name"
                        optionValue="id"
                        placeholder="Seleccione un tipo"
                        class="p-dropdown p-component"
                        :class="{ 'p-invalid': errors.tipo_modista_id }"
                        showClear
                        filter
                    />
                    <small v-if="errors.tipo_modista_id" class="p-error">{{
                        errors.tipo_modista_id
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
    props: ["manageModista", "dataForm", "visibleModal"],
    watch: {
        dataForm(newValue) {
            if (Object.keys(newValue).length !== 0) {
                this.form = {
                    id: newValue.id,
                    nombre: newValue.nombre,
                    direccion: newValue.direccion,
                    celular: newValue.celular,
                    tipo_modista_id: newValue.tipo_modista_id,
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
                direccion: "",
                celular: "",
                tipo_modista_id: null,
            },
            errors: {},
            rpTipoModista: null,
            visible: false,
        };
    },
    components: {},
    mounted() {},
    created() {
        this.getEnums();
    },
    methods: {
        async validateForm() {
            const schema = Yup.object().shape({
                nombre: Yup.string().required(),
                direccion: Yup.string().required(),
                celular: Yup.number()
                    .typeError("El celular debe ser un número válido")
                    .required("El número de celular es obligatorio"),
                tipo_modista_id: Yup.string().required(
                    "La categoría es obligatoria"
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
                if (this.manageModista) {
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
                direccion: "",
                celular: "",
                tipo_modista_id: null,
            };
            this.errors = {};
        },
        async getEnums() {
            const enumsCode = ["tipo_modista"];
            const response = await this.$getEnumsRelations(enumsCode);
            const { tipo_modista } = response;
            this.rpTipoModista = tipo_modista;
        },
        handleDialogClose() {
            this.resetForm();
            this.visible = false;
            this.$emit("hidden", this.visible);
        },
    },
};
</script>
<style>
.text-invalid {
    color: red;
}
</style>
