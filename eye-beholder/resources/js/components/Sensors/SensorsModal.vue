<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitSensor()" no-close-on-backdrop no-close-on-esc hide-header-close>
            <b-container fluid>
                <b-row align-v="end">
                    <b-col cols="6">
                        <b-form-group label="Tipo de Sensor">
                            <b-form-select v-model="sensor.type_sensor_id" @click="typeSensorClick" :state="stateTypeSensor" class="mb-0">
                                <template #first>
                                    <b-form-select-option value="" disabled>Selecione o Tipo de Sensor</b-form-select-option>
                                </template>

                                <b-form-select-option v-for="(atrat, idx) in typeSensors" :value="atrat.id" :key="idx">
                                   {{ atrat.type }}
                                </b-form-select-option>

                                <small class="text-danger" :hidden="!errorsSensors.type_sensor">{{ formatErrorsArray(errorsSensors.type_sensor) }}</small>
                            </b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col cols="6">
                        <b-form-group label="Modelo do Sensor">
                            <b-form-input v-model="sensor.model" @click="modelClick" :state="stateModel" type="text" placeholder="Insira o modelo do sensor" required>
                            </b-form-input>

                            <small class="text-danger" :hidden="!errorsSensors.model">{{ formatErrorsArray(errorsSensors.model) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Descrição">
                            <b-form-textarea v-model="sensor.description" @click="descriptionClick" :state="stateDescription" type="text" placeholder="Insira a descrição do sensor" required>
                            </b-form-textarea>

                            <small class="text-danger" :hidden="!errorsSensors.description">{{ formatErrorsArray(errorsSensors.description) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Emergências Associadas">
                            <multiselect v-model="sensor.emergencies" label="name" track-by="id" placeholder="Escolha uma ou mais emergências" 
                                :options="emergenciesList" :multiple="true" :taggable="true" :searchable="true">
                            </multiselect>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-container>

            <template #modal-footer>
                <div class="text-center">
                    <b-row align-h="end">
                        <b-col cols="6">
                            <b-button @click="submitSensor" variant="primary" size="sm" class="float-right">{{ okButtonTitle }}</b-button>
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
    model: false,
    description: false,
    emergencies: false,
};

export default {
    component: 'SensorsModal',

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
        ...mapGetters('sensors',{
            errorsSensors: "getErrorsSensors",
            sensor: "getCurrentSensor",
        }),

        ...mapGetters('emergencies',{
            emergenciesList: "getEmergenciesList",
        }),

        ...mapGetters('typeSensors',{
            typeSensors: "getTypeSensorsList",
        }),

        isModalVisible(){ return this.showModal },

        modalTitle(){ return this.isEditing ? "Editando Sensor" : "Cadastro de Sensor" },

        okButtonTitle(){ return this.isEditing ? "Confirmar" : "Cadastrar" },

        stateTypeSensor() {
            if (this.inputState.type_sensor_id || this.errorsSensors == {}) { return null; }
            return Object.keys(this.errorsSensors).length === 0 ? null: this.errorsSensors.type_sensor_id ? false : true;
        },

        stateModel() {
            if (this.inputState.model || this.errorsSensors == {}) { return null; }
            return Object.keys(this.errorsSensors).length === 0 ? null: this.errorsSensors.model ? false : true;
        },

        stateDescription() {
            if (this.inputState.description || this.errorsSensors == {}) { return null; }
            return Object.keys(this.errorsSensors).length === 0 ? null: this.errorsSensors.description ? false : true;
        },

        stateEmergencies() {
            if (this.inputState.emergencies || this.errorsSensors == {}) { return null; }
            return Object.keys(this.errorsSensors).length === 0 ? null: this.errorsSensors.emergencies ? false : true;
        },
    },

    methods: {
        ...mapActions('sensors', [
            "createSensor",
            "editSensor",
            "sensorStoreCommit",
        ]),

        ...mapActions('typeSensors', [
            "fetchTypeSensors",
        ]),

        ...mapActions('emergencies',[
            "fetchEmergencies",
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

        async submitSensor(bvModalEvt){
            // Prevent modal from closing
            bvModalEvt.preventDefault();

            try {
                if(this.isEditing){ await this.editSensor(this.sensor) }
                else{ await this.createSensor(this.sensor) }

                if(Object.values(this.errorsSensors).length == 0 || this.errorsSensors == null || this.errorsSensors == undefined){
                    this.closeModal()
                }
            }
            catch (error) {
                console.log(error);
            }
        },

        resetForm(){ this.sensorStoreCommit({mutation: "RESET_CURRENT_SENSOR"}) },

        closeModal(){ this.$emit("closeModal"); this.resetForm() },

        typeSensorClick() { if (this.errorsSensors.type_sensor_id) { this.inputState.type_sensor_id = true; } },
        modelClick() { if (this.errorsSensors.model) { this.inputState.model = true; } },
        descriptionClick() { if (this.errorsSensors.description) { this.inputState.description = true; } },
        emergenciesClick() { if (this.errorsSensors.emergencies) { this.inputState.emergencies = true; } },
    },

    mounted() {
        this.fetchTypeSensors()
        this.fetchEmergencies()
    },

}

</script>