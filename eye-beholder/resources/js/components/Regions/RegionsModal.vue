<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitRegion" size="lg" no-close-on-backdrop no-close-on-esc hide-header-close>
            <b-container fluid>
                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Nome">
                            <b-form-input v-model="region.name" type="text" placeholder="Insira o nome da região" required @click="nameClick" :state="stateName">
                            </b-form-input>

                            <small class="text-danger" :hidden="!errorsRegions.name">{{ formatErrorsArray(errorsRegions.name) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Descrição">
                            <b-form-textarea v-model="region.description" type="text" placeholder="Insira a descrição da região" required 
                                @click="descriptionClick" :state="stateDescription">
                            </b-form-textarea>

                            <small class="text-danger" :hidden="!errorsRegions.description">{{ formatErrorsArray(errorsRegions.description) }}</small>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-container>

            <template #modal-footer>
                <div class="text-center">
                    <b-row align-h="end">
                        <b-col cols="6">
                            <b-button @click="submitRegion" variant="primary" class="float-right">{{ okButtonTitle }}</b-button>
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

const defaultInputState = {
    name: false,
    description: false,
};

export default {
    component: 'RegionsModal',

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
        ...mapGetters('regions',{
            errorsRegions: "getErrorsRegions",
            isLoading: "getIsLoading",
            region: "getCurrentRegion",
        }),

        isModalVisible(){ return this.showModal },

        modalTitle(){ return this.isEditing ? "Editando Região" : "Cadastro de Região" },

        okButtonTitle(){ return this.isEditing ? "Confirmar" : "Cadastrar" },

        stateName() {
            if (this.inputState.name || this.errorsRegions == {}) { return null; }
            return Object.keys(this.errorsRegions).length === 0 ? null: this.errorsRegions.name ? false : true;
        },

        stateDescription() {
            if (this.inputState.description || this.errorsRegions == {}) { return null; }
            return Object.keys(this.errorsRegions).length === 0 ? null: this.errorsRegions.description ? false : true;
        },
    },

    watch: {
    },

    methods: {
        ...mapActions('regions', [
            "createRegion",
            "editRegion",
            "regionStoreCommit",
        ]),

        ...mapActions('regions', [
            "fetchRegions",
        ]),


        async submitRegion(bvModalEvt){
            // Prevent modal from closing
            bvModalEvt.preventDefault();

            try {
                if(this.isEditing){ await this.editRegion(this.region) }
                else{ await this.createRegion(this.region) }

                if(Object.values(this.errorsRegions).length == 0 || this.errorsRegions == null || this.errorsRegions == undefined){
                    this.closeModal()
                }
            } 
            catch (error) {
                console.log(error);
            }
        },

        resetForm(){ this.regionStoreCommit({mutation: "RESET_CURRENT_REGION"}) },

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

        nameClick() { if (this.errorsRegions.name) { this.inputState.name = true; } },
        descriptionClick() { if (this.errorsRegions.description) { this.inputState.description = true; } },
    },
}

</script>