<template>
    <Dialog
        v-model:visible="visible"
        :style="{ width: '450px' }"
        :header="manageAsignacion ? 'Agregar Asignación' : 'Editar Asignación'"
        :modal="true"
        class="p-fluid p-dialog-top"
        :position="'top'"
        @hide="handleDialogClose"
        ><form @submit.prevent="handleSubmit">
            <div class="p-field p-grid my-row-spacing">
                <label for="tipo" class="p-col-fixed" style="width: 100px"
                    >Modistas</label
                >
                <div class="p-col">
                    <Dropdown
                        v-model="form.modista_id"
                        :options="listModistas"
                        optionLabel="nombre"
                        optionValue="id"
                        placeholder="Seleccione un tipo"
                        class="p-dropdown p-component"
                        :class="{ 'p-invalid': errors.modista_id }"
                        showClear
                        filter
                    />
                    <small v-if="errors.modista_id" class="p-error">{{
                        errors.modista_id
                    }}</small>
                </div>
            </div>
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
    props: ["manageAsignacion", "dataForm", "visibleModal"],
    watch: {
        dataForm(newValue) {
            if (Object.keys(newValue).length !== 0) {
                this.form = {
                    id: newValue.id,
                    corte_id: newValue.corte_id,
                    modista_id: newValue.modista_id,
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
                modista_id: "",
            },
            errors: {},
            visible: false,
            listCortes: [],
            listModistas: [],
        };
    },
    components: {},
    mounted() {},
    created() {
        this.getListSelects();
        this.form = {
            corte_id: "",
            modista_id: "",
        };
    },
    methods: {
        async validateForm() {
            const schema = Yup.object().shape({
                corte_id: Yup.string().required(
                    "El corte es un campo requerido"
                ),
                modista_id: Yup.string().required(
                    "La especificacion es un campo requerido"
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
                if (this.manageAsignacion) {
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
                modista_id: "",
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
            this.listModistas = await this.$listModistasNombresAndIds();
        },
    },
};
</script>
