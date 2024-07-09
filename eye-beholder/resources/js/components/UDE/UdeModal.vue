<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitUde" size="lg" no-close-on-backdrop no-close-on-esc hide-header-close>
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
                            <b-form-input v-model="ude.mac_id" v-mask="'XX:XX:XX:XX:XX:XX'" @change="convertToUppercase" type="text" placeholder="Insira o endereço MAC da UDE" 
                                required>
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
import { VueMaskDirective } from 'v-mask'
import { mapGetters, mapActions } from "vuex"

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

        convertToUppercase(){ this.ude.mac_id = this.ude.mac_id.toUpperCase(); },

        async submitUde(bvModalEvt){
            // Prevent modal from closing
            bvModalEvt.preventDefault();

            try {
                if(this.isEditing){ await this.editUde(this.ude) }
                else{ await this.createUde(this.ude) }

                if(Object.values(this.errorsUdes).length == 0 || this.errorsUdes == null || this.errorsUdes == undefined){
                    this.closeModal()
                }
            }
            catch (error) {
                console.log(error);
            }
        },

        resetForm(){ this.udeStoreCommit({mutation: "RESET_CURRENT_UDE"}) },

        closeModal(){ this.$emit("closeModal"); this.resetForm() }
    },

    async mounted() {
        await this.fetchInterestZones()
        await this.fetchUdeClasses()
    },

}

</script>