<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitSensor()" size="lg" no-close-on-backdrop no-close-on-esc hide-header-close>
            <b-container fluid>
                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Nome da Zona de Interesse">
                            <b-form-input v-model="interestZone.name" type="text" placeholder="Insira o nome da zona de interesse" required>
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Descrição">
                            <b-form-textarea v-model="interestZone.description" type="text" placeholder="Insira a descrição da zona de interesse" required>
                            </b-form-textarea>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <!-- @input="tipo_rap_idClick" :state="stateTipo_rap_id" -->
                    <b-col>
                        <b-form-group label="Região">
                            <b-form-select v-model="interestZone.region_id" :options="regionsList" value-field="id" text-field="name">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>Seleciona uma Região</b-form-select-option>
                                </template>
                            </b-form-select>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-container>

            <template #modal-footer>
                <div class="text-center">
                    <b-row align-h="end">
                        <b-col cols="6">
                            <b-button @click="submitInterestZone" variant="primary" class="float-right">{{ okButtonTitle }}</b-button>
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
import { mapGetters, mapActions } from "vuex"

export default {
    component: 'InterestZoneModal',

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
        ...mapGetters('interestZones',{
            errorsInterestZones: "getErrorsInterestZones",
            isLoading: "getIsLoading",
            interestZone: "getCurrentInterestZone",
        }),

        ...mapGetters('regions',{
            regionsList: "getRegionsList",
        }),


        isModalVisible(){ return this.showModal },

        modalTitle(){ return this.isEditing ? "Editando Região" : "Cadastro de Região" },

        okButtonTitle(){ return this.isEditing ? "Confirmar" : "Cadastrar" }
    },

    watch: {
    },

    methods: {
        ...mapActions('interestZones', [
            "createInterestZone",
            "editInterestZone",
            "interestZoneStoreCommit",
            "fetchInterestZones",
        ]),

        ...mapActions('regions', [
            "fetchRegions",
        ]),


        submitInterestZone(){
            if(this.isEditing){
                this.editInterestZone(this.interestZone)
                    .then(() => {
                        this.closeModal()
                    })
                    .catch(() => {
                    })
            }
            else{
                console.log('InterestZone >>>>', this.interestZone);
                this.createInterestZone(this.interestZone)
                    .then(() => {
                        this.closeModal()
                    })
                    .catch(() => {

                    })
            }
        },

        resetForm(){ this.interestZoneStoreCommit({mutation: "RESET_CURRENT_INTEREST_ZONE"}) },

        closeModal(){ this.$emit("closeModal"); this.resetForm() }
    },

    mounted() {
        this.fetchRegions()
    },

}

</script>