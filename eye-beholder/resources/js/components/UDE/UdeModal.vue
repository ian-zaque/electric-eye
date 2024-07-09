<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitUde()" size="lg" no-close-on-backdrop no-close-on-esc hide-header-close>
            <b-container fluid>
                <b-row>
                    <b-col cols="6">
                        <b-form-group label="Nome">
                            <b-form-input v-model="ude.name" type="text" placeholder="Insira o nome da UDE" required>
                            </b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col cols="6">
                        <b-form-group label="Endereço MAC">
                            <b-form-input v-model="ude.mac_id" type="text" placeholder="Insira o endereço MAC da UDE" required>
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <!-- @input="tipo_rap_idClick" :state="stateTipo_rap_id" -->
                    <b-col cols="6">
                        <b-form-group label="Classe da UDE">
                            <b-form-select v-model="ude.class_id" :options="udeClassesList" value-field="id" text-field="class">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>Selecione uma Classe de UDE</b-form-select-option>
                                </template>
                            </b-form-select>
                        </b-form-group>
                    </b-col>

                    <b-col cols="6">
                        <b-form-group label="Zona de Interesse">
                            <b-form-select v-model="ude.interest_zone_id" :options="interestZonesList" value-field="id" text-field="name">
                                <template #first>
                                    <b-form-select-option :value="null" disabled>Selecione uma Zona de Interesse</b-form-select-option>
                                </template>
                            </b-form-select>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="6">
                        <b-form-group label="Latitude">
                            <b-form-input v-model="ude.latitude" type="number" placeholder="Insira a latitude da UDE" required>
                            </b-form-input>
                        </b-form-group>
                    </b-col>

                    <b-col cols="6">
                        <b-form-group label="Longitude">
                            <b-form-input v-model="ude.longitude" type="number" placeholder="Insira a longitude da UDE" required>
                            </b-form-input>
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
import { mapGetters, mapActions } from "vuex"

export default {
    component: 'UdeModal',

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
        ...mapGetters('udes',{
            errorsUdes: "getErrorsUdes",
            isLoading: "getIsLoading",
            ude: "getCurrentUde",
        }),

        ...mapGetters('interestZones',{
            interestZonesList: "getInterestZonesList",
        }),

        ...mapGetters('udeClasses',{
            udeClassesList: "getUdeClassesList",
        }),


        isModalVisible(){ return this.showModal },

        modalTitle(){ return this.isEditing ? "Editando UDE" : "Cadastro de UDE" },

        okButtonTitle(){ return this.isEditing ? "Confirmar" : "Cadastrar" }
    },

    watch: {
    },

    methods: {
        ...mapActions('udes', [
            "createUde",
            "editUde",
            "udeStoreCommit",
            "fetchUdes",
        ]),

        ...mapActions('interestZones', [
            "fetchInterestZones",
        ]),

        ...mapActions('udeClasses', [
            "fetchUdeClasses",
        ]),

        submitUde(){
            if(this.isEditing){
                this.editUde(this.ude)
                    .then(() => {
                        this.closeModal()
                    })
                    .catch(() => {
                    })
            }
            else{
                this.createUde(this.ude)
                    .then(() => {
                        this.closeModal()
                    })
                    .catch(() => {

                    })
            }
        },

        resetForm(){ this.udeStoreCommit({mutation: "RESET_CURRENT_UDE"}) },

        closeModal(){ this.$emit("closeModal"); this.resetForm() }
    },

    mounted() {
        this.fetchInterestZones()
        this.fetchUdeClasses()
    },

}

</script>