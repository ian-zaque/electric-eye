<template>
    <div>
        <b-modal v-model="isModalVisible" :title="modalTitle" @ok="submitTypeSensor()" centered no-close-on-backdrop no-close-on-esc hide-header-close>
            <b-container fluid>
                <b-row align-v="center">
                    <b-col cols="12">
                        <b-form-group label="Tipo de Sensor">
                            <b-form-input v-model="type_sensor.type" type="text" placeholder="Insira o tipo de sensor" required>
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Descrição">
                            <b-form-input v-model="type_sensor.description" type="text" placeholder="Insira a descrição do sensor" required>
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>

                <b-row>
                    <b-col cols="12">
                        <b-form-group label="Unidade de Medida">
                            <b-form-input v-model="type_sensor.unit" type="text" placeholder="Insira a unidade de medida" required>
                            </b-form-input>
                        </b-form-group>
                    </b-col>
                </b-row>
            </b-container>

            <template #modal-footer>
                <div class="text-center">
                    <b-row align-h="end">
                        <b-col cols="6">
                            <b-button @click="submitTypeSensor" variant="primary" size="sm" class="float-right">{{ okButtonTitle }}</b-button>
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
    component: 'TypeSensorsModal',

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
            // type_sensor: {
            //     type: '', description: '', unit: ''
            // }
        }
    },

    computed: {
        ...mapGetters('typeSensors',{
            errorsTypeSensors: "getErrorsTypeSensors",
            isLoading: "getIsLoading",
            type_sensor: "getCurrentTypeSensor",
        }),

        isModalVisible(){ return this.showModal },

        modalTitle(){ return this.isEditing ? "Editando Tipo de Sensor" : "Cadastro de Tipo de Sensor" },

        okButtonTitle(){ return this.isEditing ? "Confirmar" : "Cadastrar" }
    },

    watch: {
    },

    methods: {
        ...mapActions('typeSensors', [
            "createTypeSensors",
            "editTypeSensors",
            "typeSensorStoreCommit",
        ]),


        submitTypeSensor(){
            if(this.isEditing){
                this.editTypeSensors(this.type_sensor)
                    .then( () => {
                        this.closeModal()
                    })
                    .catch(() => {

                    })
            }
            else{
                this.createTypeSensors(this.type_sensor)
                    .then( () => {
                        this.closeModal()
                    })
                    .catch(() => {

                    })
            }
        },

        resetForm(){ this.typeSensorStoreCommit({ mutation: "RESET_CURRENT_TYPE_SENSOR" }) },

        closeModal(){ this.$emit("closeModal"); this.resetForm() }
    },

    mounted() {
    },

}

</script>