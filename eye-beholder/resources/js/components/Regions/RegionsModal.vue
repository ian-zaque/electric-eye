<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitRegion" size="lg" no-close-on-backdrop no-close-on-esc hide-header-close>
            <b-container fluid>
                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Nome da Região">
                            <b-form-input v-model="region.name" type="text" placeholder="Insira o nome da região" required>
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Descrição">
                            <b-form-textarea v-model="region.description" type="text" placeholder="Insira a descrição da região" required>
                            </b-form-textarea>
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

        okButtonTitle(){ return this.isEditing ? "Confirmar" : "Cadastrar" }
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

        closeModal(){ this.$emit("closeModal"); this.resetForm() }
    },

    mounted() {
    },

}

</script>