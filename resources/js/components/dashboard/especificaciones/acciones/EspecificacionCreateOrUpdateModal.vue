<template>
    <Dialog
        v-model:visible="visible"
        :style="{ width: '450px' }"
        :header="
            manageEspecificacion
                ? 'Agregar Especificacion'
                : 'Editar Especificacion'
        "
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
                <label
                    for="descripcion"
                    class="p-col-fixed"
                    style="width: 100px"
                    >Descripcion</label
                >
                <div class="p-col">
                    <Textarea
                        id="descripcion"
                        type="text"
                        v-model="form.descripcion"
                        class="p-component"
                        :class="{ 'p-invalid': errors.descripcion }"
                        autoResize
                        maxlength="512"
                    />
                    <small v-if="errors.descripcion" class="p-error">{{
                        errors.descripcion
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
    props: ["manageEspecificacion", "dataForm", "visibleModal"],
    watch: {
        dataForm(newValue) {
            if (Object.keys(newValue).length !== 0) {
                this.form = {
                    id: newValue.id,
                    nombre: newValue.nombre,
                    descripcion: newValue.descripcion,
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
                descripcion: "",
            },
            errors: {},
            visible: false,
        };
    },
    components: {},
    mounted() {},
    created() {},
    methods: {
        async validateForm() {
            const schema = Yup.object().shape({
                nombre: Yup.string().required(),
                descripcion: Yup.string().required(),
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
                if (this.manageEspecificacion) {
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
                descripcion: "",
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
<style>
.text-invalid {
    color: red;
}
</style>
