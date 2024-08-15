<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitEmergency" size="lg" no-close-on-backdrop no-close-on-esc hide-header-close>
            <b-container fluid>
                <b-row>
                    <b-col cols="6">
                        <b-form-group label="Nome">
                            <b-form-input v-model="emergency.name" type="text" placeholder="Insira o nome da Emergência" required @click="nameClick" :state="stateName">
                            </b-form-input>

                            <small class="text-danger" :hidden="!errorsEmergencies.name">{{ formatErrorsArray(errorsEmergencies.name) }}</small>
                        </b-form-group>
                    </b-col>

                    <b-col cols="6">
                        <b-form-group label="Zona de Interesse">
                            <b-form-select v-model="emergency.interest_zone_id" :options="interestZonesList" value-field="id" text-field="name" @click="interestZoneIdClick" :state="stateInterestZoneId">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>Selecione uma Zona de Interesse</b-form-select-option>
                                </template>
                            </b-form-select>

                            <small class="text-danger" :hidden="!errorsEmergencies.interest_zone_id">{{ formatErrorsArray(errorsEmergencies.interest_zone_id) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Descrição">
                            <b-form-textarea v-model="emergency.description" type="text" placeholder="Insira a descrição da emergência" required 
                                @click="descriptionClick" :state="stateDescription">
                            </b-form-textarea>

                            <small class="text-danger" :hidden="!errorsEmergencies.description">{{ formatErrorsArray(errorsEmergencies.description) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-form-group label="Parâmetros da Emergência" label-size="lg">
                    <div v-for="(param, idx) in emergency.emergency_parameters" :key="idx">
                        <b-row align-h="around">
                            <b-col cols="6">
                                <b-form-group label="Chave">
                                    <b-form-input v-model="emergency.emergency_parameters[idx].name" type="text" placeholder="Nome do Parâmetro" required @click="nameClick" :state="stateName">
                                    </b-form-input>

                                    <small class="text-danger" :hidden="!errorsEmergencies.name">{{ formatErrorsArray(errorsEmergencies.name) }}</small>
                                </b-form-group>
                            </b-col>

                            <b-col cols="5">
                                <b-form-group label="Valor">
                                    <b-form-input v-model="emergency.emergency_parameters[idx].value" type="number" placeholder="Parâmetro de referência" required @click="nameClick" :state="stateName">
                                    </b-form-input>

                                    <small class="text-danger" :hidden="!errorsEmergencies.name">{{ formatErrorsArray(errorsEmergencies.name) }}</small>
                                </b-form-group>
                            </b-col>

                            <b-col>
                                <b-button v-show="idx || (!idx && emergency.emergency_parameters.length > 1)" @click="removeNewParameter(idx)" size="sm" type="button" variant="outline-secondary" style="margin-top: 32px;"> 
                                    <i class="fas fa-minus fa-sm"></i> 
                                </b-button>
                            </b-col>
                        </b-row>

                        <b-row class="text-right">
                            <b-col>
                                <b-button v-show="idx == emergency.emergency_parameters.length - 1" @click="addNewParameter()" size="sm" variant="outline-secondary" type="button">
                                    <i class="fas fa-plus fa-sm"></i>
                                </b-button>
                            </b-col>
                        </b-row>
                    </div>
                </b-form-group>
            </b-container>

            <template #modal-footer>
                <div class="text-center">
                    <b-row align-h="end">
                        <b-col cols="6">
                            <b-button @click="submitEmergency" variant="primary" class="float-right">{{ okButtonTitle }}</b-button>
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
    description: false,
    interest_zone_id: false,
    emergency_parameters: false,
    interest_zone_id: false,
    interest_zone: false,
};

export default {
    component: 'EmergencyModal',

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
        ...mapGetters('emergencies',{
            errorsEmergencies: "getErrorsEmergencies",
            isLoading: "getIsLoading",
            emergency: "getCurrentEmergency",
        }),

        ...mapGetters('interestZones',{
            interestZonesList: "getInterestZonesList",
        }),

        isModalVisible(){ return this.showModal },

        modalTitle(){ return this.isEditing ? "Editando Emergência" : "Cadastro de Emergência" },

        okButtonTitle(){ return this.isEditing ? "Confirmar" : "Cadastrar" },

        stateName() {
            if (this.inputState.name || this.errorsEmergencies == {}) { return null; }
            return Object.keys(this.errorsEmergencies).length === 0 ? null: this.errorsEmergencies.name ? false : true;
        },

        stateDescription() {
            if (this.inputState.description || this.errorsEmergencies == {}) { return null; }
            return Object.keys(this.errorsEmergencies).length === 0 ? null: this.errorsEmergencies.description ? false : true;
        },

        stateInterestZoneId() {
            if (this.inputState.interest_zone_id || this.errorsEmergencies == {}) { return null; }
            return Object.keys(this.errorsEmergencies).length === 0 ? null: this.errorsEmergencies.interest_zone_id ? false : true;
        },
    },

    methods: {
        ...mapActions('emergencies', [
            "fetchEmergencies",
            "createEmergency",
            "editEmergency",
            "emergenciesStoreCommit",
        ]),

        ...mapActions('interestZones', [
            "fetchInterestZones",
        ]),

        async submitEmergency(bvModalEvt){
            // Prevent modal from closing
            bvModalEvt.preventDefault();

            try {
                if(this.isEditing){ await this.editEmergency(this.emergency) }
                else{ await this.createEmergency(this.emergency) }

                if(Object.values(this.errorsEmergencies).length == 0 || this.errorsEmergencies == null || this.errorsEmergencies == undefined){
                    this.closeModal()
                }
            }
            catch (error) {
                console.log(error);
            }
        },

        resetForm(){ this.emergenciesStoreCommit({mutation: "RESET_CURRENT_EMERGENCY"}) },

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

        addNewParameter(){ this.emergency.emergency_parameters.push({ name: "", value: ""}); },
        removeNewParameter(i){ this.emergency.emergency_parameters.splice(i,1); },

        nameClick() { if (this.errorsEmergencies.name) { this.inputState.name = true; } },
        descriptionClick() { if (this.errorsEmergencies.description) { this.inputState.description = true; } },
        interestZoneIdClick() { if (this.errorsEmergencies.interest_zone_id) { this.inputState.interest_zone_id = true; } },
    },

    async mounted() {
        await this.fetchInterestZones()
    },

}

</script>