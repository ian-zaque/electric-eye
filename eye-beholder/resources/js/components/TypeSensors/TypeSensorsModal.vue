<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitTypeSensor()" no-close-on-backdrop no-close-on-esc hide-header-close>
            <b-container fluid>
                <b-row align-v="center">
                    <b-col cols="12">
                        <b-form-group label="Tipo de Sensor">
                            <b-form-input v-model="type_sensor.type" @click="typeClick" :state="stateType" type="text" placeholder="Insira o tipo de sensor" required>
                            </b-form-input>

                            <small class="text-danger" :hidden="!errorsTypeSensors.type">{{ formatErrorsArray(errorsTypeSensors.type) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Unidade de Medida">
                            <b-form-input v-model="type_sensor.unit" @click="unitClick" :state="stateUnit" type="text" placeholder="Insira a unidade de medida" required>
                            </b-form-input>

                            <small class="text-danger" :hidden="!errorsTypeSensors.unit">{{ formatErrorsArray(errorsTypeSensors.unit) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Descrição">
                            <b-form-textarea v-model="type_sensor.description" @click="descriptionClick" :state="stateDescription" type="text" placeholder="Insira a descrição do sensor" required>
                            </b-form-textarea>

                            <small class="text-danger" :hidden="!errorsTypeSensors.description">{{ formatErrorsArray(errorsTypeSensors.description) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-container>

            <template #modal-footer>
                <div class="text-center">
                    <b-row align-h="end">
                        <b-col cols="6">
                            <b-button @click="submitTypeSensor" variant="primary" size="sm" class="float-right">{{ okButtonTitle }}</b-button>
                        </b-col>

                        <b-col cols="6">
                            <b-button @click="closeModal" variant="secondary" size="sm" class="float-right">Cancelar</b-button>
                        </b-col>
                    </b-row>
                </div>
            </template>
        </b-modal>
    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex"

const defaultInputState = {
    type_sensor_id: false,
    unit: false,
    description: false,
};

export default {
    component: 'TypeSensorsModal',

    props:{
        showModal:{
            type: Boolean,
            default: false,
        },

        isEditing: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
            inputState: { ...defaultInputState },
        }
    },

    computed: {
        ...mapGetters('typeSensors',{
            errorsTypeSensors: "getErrorsTypeSensors",
            isLoading: "getIsLoading",
            type_sensor: "getCurrentTypeSensor",
        }),

        isModalVisible(){ return this.showModal },

        modalTitle(){ return this.isEditing ? "Editando Tipo de Sensor" : "Cadastro de Tipo de Sensor" },

        okButtonTitle(){ return this.isEditing ? "Confirmar" : "Cadastrar" },

        stateType() {
            if (this.inputState.type || this.errorsTypeSensors == {}) { return null; }
            return Object.keys(this.errorsTypeSensors).length === 0 ? null: this.errorsTypeSensors.type ? false : true;
        },

        stateUnit() {
            if (this.inputState.unit || this.errorsTypeSensors == {}) { return null; }
            return Object.keys(this.errorsTypeSensors).length === 0 ? null: this.errorsTypeSensors.unit ? false : true;
        },

        stateDescription() {
            if (this.inputState.description || this.errorsTypeSensors == {}) { return null; }
            return Object.keys(this.errorsTypeSensors).length === 0 ? null: this.errorsTypeSensors.description ? false : true;
        },
    },

    watch: {
    },

    methods: {
        ...mapActions('typeSensors', [
            "createTypeSensors",
            "editTypeSensors",
            "typeSensorStoreCommit",
        ]),

        formatErrorsArray(arrayError){
            if(arrayError != null && arrayError != undefined && arrayError.length > 0){
                var errorText = ""
                arrayError.map(function(value, index){
                    if(index == arrayError.length - 1){ errorText += value }
                    if(index != arrayError.length - 1){ errorText += value + ". \n" }
                })
                return errorText
            }
            return ""
        },

        async submitTypeSensor(bvModalEvt){
            // Prevent modal from closing
            bvModalEvt.preventDefault();

            try {
                if(this.isEditing){ await this.editTypeSensors(this.type_sensor) }
                else{ await this.createTypeSensors(this.type_sensor) }

                if(Object.values(this.errorsTypeSensors).length == 0 || this.errorsTypeSensors == null || this.errorsTypeSensors == undefined){
                    this.closeModal()
                }
            }
            catch (error) {
                console.log(error);
            }
        },

        resetForm(){ this.typeSensorStoreCommit({ mutation: "RESET_CURRENT_TYPE_SENSOR" }) },

        closeModal(){ this.$emit("closeModal"); this.resetForm() },

        typeClick() { if (this.errorsTypeSensors.type) { this.inputState.type = true; } },
        unitClick() { if (this.errorsTypeSensors.unit) { this.inputState.unit = true; } },
        descriptionClick() { if (this.errorsTypeSensors.description) { this.inputState.description = true; } },
    },

    mounted() {
    },

}

</script>