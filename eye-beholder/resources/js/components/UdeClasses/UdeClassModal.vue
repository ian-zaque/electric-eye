<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitUdeClass()" size="lg" no-close-on-backdrop no-close-on-esc hide-header-close>
            <b-container fluid>
                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Classe de UDE">
                            <b-form-input v-model="udeClass.class" disabled type="text" placeholder="Insira a Classe de UDE" required>
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Nome da Classe de UDE">
                            <b-form-input v-model="udeClass.fullname" disabled type="text" placeholder="Insira o nome da Classe de UDE" required>
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-container>

            <template #modal-footer>
                <div class="text-center">
                    <b-row align-h="end">
                        <!-- <b-col cols="6">
                            <b-button @click="submitUdeClass" variant="primary" class="float-right">{{ okButtonTitle }}</b-button>
                        </b-col> -->

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
    component: 'UdeClassesModal',

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
        ...mapGetters('udeClasses',{
            errorsUdeClasses: "getErrorsUdeClasses",
            isLoading: "getIsLoading",
            udeClass: "getCurrentUdeClass",
        }),

        isModalVisible(){ return this.showModal },

        modalTitle(){ return this.isEditing ? "Editando Classe de UDE" : "Cadastro de Classe de UDE" },

        okButtonTitle(){ return this.isEditing ? "Confirmar" : "Cadastrar" }
    },

    watch: {
    },

    methods: {
        ...mapActions('udeClasses', [
            "createUdeClass",
            "editUdeClass",
            "udeClassStoreCommit",
            "fetchUdeClasses",
        ]),

        async submitUdeClass(bvModalEvt){
            // Prevent modal from closing
            bvModalEvt.preventDefault();

            try {
                if(this.isEditing){ await this.editUdeClass(this.udeClass) }
                else{ await this.createUdeClass(this.udeClass) }

                if(Object.values(this.errorsUdeClasses).length == 0 || this.errorsUdeClassess == null || this.errorsUdeClassess == undefined){
                    this.closeModal()
                }
            }
            catch (error) {
                console.log(error);
            }
        },

        resetForm(){ this.udeClassStoreCommit({mutation: "RESET_CURRENT_UDE_CLASS"}) },

        closeModal(){ this.$emit("closeModal"); this.resetForm() }
    },

    mounted() {
    },

}

</script>