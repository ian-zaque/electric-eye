<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitSensor()" no-close-on-backdrop no-close-on-esc hide-header-close>
            <b-container fluid>
                <b-row align-v="center">
                    <b-col cols="12">
                        <b-form-group label="Tipo de Sensor">
                            <b-form-select v-model="sensor.type_sensor" class="mb-3">
                                <template #first>
                                    <b-form-select-option value="" disabled>Selecione o Tipo de Sensor</b-form-select-option>
                                </template>

                                <b-form-select-option v-for="(atrat, idx) in typeSensors" :value="atrat.id" :key="idx">
                                   {{ atrat.type }}
                                </b-form-select-option>
                            </b-form-select>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Descrição">
                            <b-form-input v-model="sensor.description" type="text" placeholder="Insira a descrição do sensor" required>
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Modelo do Sensor">
                            <b-form-input v-model="sensor.model" type="text" placeholder="Insira o modelo do sensor" required>
                            </b-form-input>
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
        }
    },

    computed: {
        ...mapGetters('sensors',{
            errorsSensors: "getErrorsSensors",
            isLoading: "getIsLoading",
            sensor: "getCurrentSensor",
        }),

        ...mapGetters('typeSensors',{
            typeSensors: "getTypeSensorsList",
        }),

        isModalVisible(){ return this.showModal },

        modalTitle(){ return this.isEditing ? "Editando Sensor" : "Cadastro de Sensor" },

        okButtonTitle(){ return this.isEditing ? "Confirmar" : "Cadastrar" }
    },

    watch: {
    },

    methods: {
        ...mapActions('sensors', [
            "createSensors",
            "editSensor",
            "sensorStoreCommit",
        ]),

        ...mapActions('typeSensors', [
            "fetchTypeSensors",
        ]),


        submitSensor(){
            if(this.isEditing){
                this.editSensor()
                    .then( () => {
                        this.closeModal()
                    })
                    .catch(() => {

                    })
            }
            else{
                this.createSensors(this.sensor)
                    .then( () => {
                        this.closeModal()
                    })
                    .catch(() => {

                    })
            }
        },

        resetForm(){ this.sensorStoreCommit({mutation: "RESET_CURRENT_SENSOR"}) },

        closeModal(){ this.$emit("closeModal"); this.resetForm() }
    },

    mounted() {
        this.fetchTypeSensors()
    },

}

</script>