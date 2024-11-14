<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitUde" size="lg" no-close-on-backdrop no-close-on-esc hide-header-close>
            <b-container fluid>
                <b-row>
                    <b-col cols="6">
                        <b-form-group label="Nome">
                            <b-form-input v-model="ude.name" type="text" placeholder="Insira o nome da UDE" required @click="nameClick" :state="stateName">
                            </b-form-input>

                            <small class="text-danger" :hidden="!errorsUdes.name">{{ formatErrorsArray(errorsUdes.name) }}</small>
                        </b-form-group>
                    </b-col>

                    <b-col cols="6">
                        <b-form-group label="Endereço MAC">
                            <b-form-input v-model="ude.mac_id" v-mask="'XX:XX:XX:XX:XX:XX'" @change="convertToUppercase" type="text" placeholder="Insira o endereço MAC da UDE" 
                                required @click="macIdClick" :state="stateMacId"> 
                            </b-form-input>

                            <small class="text-danger" :hidden="!errorsUdes.mac_id">{{ formatErrorsArray(errorsUdes.mac_id) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="6">
                        <b-form-group label="Classe da UDE">
                            <b-form-select v-model="ude.class_id" @click="classIdClick" :state="stateClassId">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>Selecione uma Classe de UDE</b-form-select-option>
                                </template>

                                <b-form-select-option v-for="(ude_class, idx) in udeClassesList" :key="idx" :value="ude_class.id">
                                    {{ ude_class.class + ' - ' +  ude_class.fullname }}
                                </b-form-select-option>
                            </b-form-select>

                            <small class="text-danger" :hidden="!errorsUdes.class_id">{{ formatErrorsArray(errorsUdes.class_id) }}</small>
                        </b-form-group>
                    </b-col>

                    <b-col cols="6">
                        <b-form-group label="Zona de Interesse">
                            <b-form-select v-model="ude.interest_zone_id" :options="interestZonesList" value-field="id" text-field="name" @click="interestZoneIdClick" :state="stateInterestZoneId">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>Selecione uma Zona de Interesse</b-form-select-option>
                                </template>
                            </b-form-select>

                            <small class="text-danger" :hidden="!errorsUdes.interest_zone_id">{{ formatErrorsArray(errorsUdes.interest_zone_id) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="6">
                        <b-form-group label="Latitude">
                            <b-form-input v-model="ude.latitude" type="number" placeholder="Insira a latitude da UDE" required @click="latitudeClick" :state="stateLatitude">
                            </b-form-input>

                            <small class="text-danger" :hidden="!errorsUdes.latitude">{{ formatErrorsArray(errorsUdes.latitude) }}</small>
                        </b-form-group>
                    </b-col>

                    <b-col cols="6">
                        <b-form-group label="Longitude">
                            <b-form-input v-model="ude.longitude" type="number" placeholder="Insira a longitude da UDE" required @click="longitudeClick" :state="stateLongitude">
                            </b-form-input>

                            <small class="text-danger" :hidden="!errorsUdes.longitude">{{ formatErrorsArray(errorsUdes.longitude) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Sensores Associados">
                            <multiselect v-model="ude.sensors" label="model" value="id" track-by="id" placeholder="Escolha um ou mais sensores" 
                                :options="sensorsList" :multiple="true" :taggable="true" :searchable="true" selectLabel="Selecione uma opção" class="border rounded">
                            </multiselect>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-container>

            <template #modal-footer>
                <div class="text-center">
                    <b-row align-h="end">
                        <b-col cols="6">
                            <b-button @click="submitUde" variant="primary" class="float-right">{{ okButtonTitle }}</b-button>
                        </b-col>

                        <b-col cols="6">
                            <b-button @click="closeModal" variant="secondary" class="float-right">Cancelar</b-button>
                        </b-col>
                    </b-row>
                </div>
            </template>
        </b-modal>
    </div>
</template>
<script>
import { VueMaskDirective } from 'v-mask'
import { mapGetters, mapActions } from "vuex"

const defaultInputState = {
    name: false,
    mac_id: false,
    latitude: false,
    longitude: false,
    class_id: false,
    interest_zone_id: false,
    sensors: false,
};

export default {
    component: 'UdeModal',

    directives: { mask: VueMaskDirective },

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
        ...mapGetters('udes',{
            errorsUdes: "getErrorsUdes",
            ude: "getCurrentUde",
        }),

        ...mapGetters('interestZones',{
            interestZonesList: "getInterestZonesList",
        }),

        ...mapGetters('udeClasses',{
            udeClassesList: "getUdeClassesList",
        }),

        ...mapGetters('sensors',{
            sensorsList: "getSensorsList",
        }),

        isModalVisible(){ return this.showModal },

        modalTitle(){ return this.isEditing ? "Editando UDE" : "Cadastro de UDE" },

        okButtonTitle(){ return this.isEditing ? "Confirmar" : "Cadastrar" },

        stateName() {
            if (this.inputState.name || this.errorsUdes == {}) { return null; }
            return Object.keys(this.errorsUdes).length === 0 ? null: this.errorsUdes.name ? false : true;
        },

        stateMacId() {
            if (this.inputState.mac_id || this.errorsUdes == {}) { return null; }
            return Object.keys(this.errorsUdes).length === 0 ? null: this.errorsUdes.mac_id ? false : true;
        },

        stateInterestZoneId() {
            if (this.inputState.interest_zone_id || this.errorsUdes == {}) { return null; }
            return Object.keys(this.errorsUdes).length === 0 ? null: this.errorsUdes.interest_zone_id ? false : true;
        },

        stateClassId() {
            if (this.inputState.class_id || this.errorsUdes == {}) { return null; }
            return Object.keys(this.errorsUdes).length === 0 ? null: this.errorsUdes.class_id ? false : true;
        },

        stateLatitude() {
            if (this.inputState.latitude || this.errorsUdes == {}) { return null; }
            return Object.keys(this.errorsUdes).length === 0 ? null: this.errorsUdes.latitude ? false : true;
        },

        stateLongitude() {
            if (this.inputState.longitude || this.errorsUdes == {}) { return null; }
            return Object.keys(this.errorsUdes).length === 0 ? null: this.errorsUdes.longitude ? false : true;
        },

        stateSensors() {
            if (this.inputState.sensors || this.errorsUdes == {}) { return null; }
            return Object.keys(this.errorsUdes).length === 0 ? null: this.errorsUdes.sensors ? false : true;
        },
    },

    methods: {
        ...mapActions('udes', [
            "fetchUdes",
            "createUde",
            "editUde",
            "udeStoreCommit",
        ]),

        ...mapActions('interestZones', [
            "fetchInterestZones",
        ]),

        ...mapActions('udeClasses', [
            "fetchUdeClasses",
        ]),

        ...mapActions('sensors',[
            "fetchSensors",
        ]),

        convertToUppercase(){ this.ude.mac_id = this.ude.mac_id.toUpperCase(); },

        async submitUde(bvModalEvt){
            // Prevent modal from closing
            bvModalEvt.preventDefault();

            try {
                if(this.isEditing){ this.editUde(this.ude) }
                else{ this.createUde(this.ude) }

                if(Object.values(this.errorsUdes).length == 0 || this.errorsUdes == null || this.errorsUdes == undefined){
                    this.closeModal()
                }
            }
            catch (error) {
                console.log(error);
            }
        },

        resetForm(){ this.udeStoreCommit({mutation: "RESET_CURRENT_UDE"}) },

        closeModal(){ this.$emit("closeModal"); this.resetForm() },

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

        nameClick() { if (this.errorsUdes.name) { this.inputState.name = true; } },
        latitudeClick() { if (this.errorsUdes.latitude) { this.inputState.latitude = true; } },
        longitudeClick() { if (this.errorsUdes.longitude) { this.inputState.longitude = true; } },
        macIdClick() { if (this.errorsUdes.mac_id) { this.inputState.mac_id = true; } },
        classIdClick() { if (this.errorsUdes.class_id) { this.inputState.class_id = true; } },
        interestZoneIdClick() { if (this.errorsUdes.interest_zone_id) { this.inputState.interest_zone_id = true; } },
        sensorsClick() { if (this.errorsUdes.sensors) { this.inputState.sensors = true; } },
    },

    async mounted() {
        await this.fetchInterestZones()
        await this.fetchUdeClasses()
        await this.fetchSensors()
    },

}

</script>