<template>
    <div class="blackened container">
        <b-row align-h="between" align-v="center" style="margin-top: 5px;" class="container">
            <h3>Sensores</h3>

            <b-button @click="openModalSensors" variant="primary" squared>
                <i class="fa-solid fa-plus"></i>
            </b-button>
        </b-row>

        <b-row cols="12">
            <b-col>
                <b-card footer-classes="pb-2">
                    <div>
                        <b-table :items="sensorsList" :fields="sensorsFields" :busy="isLoading" :sortDesc="true" empty-text="Não há sensores registrados." 
                            hover show-empty responsive="sm" small>
                            <template #table-busy>
                                <div class="text-center my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Carregando...</strong>
                                </div>
                            </template>

                            <template #cell(actions)="data">
                                <b-row align-h="around">
                                    <b-button @click="editSensor(data)" size="sm" variant="outline-secondary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </b-button>

                                    <b-button @click="deleteSensor(data)" size="sm" variant="outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </b-button>
                                </b-row>
                            </template>
                        </b-table>
                    </div>
                </b-card>
            </b-col>
        </b-row>

        <sensors-modal :showModal="openModal" @closeModal="closeModalSensors" :isEditing="isEditing"></sensors-modal>
    </div>
</template>
  
<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: 'SensorsPage',

    components:{
    },

    data() {
        return {
            openModal: false, isEditing: false,
            sensorsFields:[
                { key: "id", label: "ID", sortable: true }, { key: "type_sensor", label: "Tipo de Sensor", sortable: true },
                { key: "model", label: "Modelo", sortable: true },  //{ key: "description", label: "Descrição", sortable: true },
                { key: "actions", label: "Ações", sortable: false },
            ]
        }
    },

    mounted(){
        this.fetchSensors();
    },

    computed:{
        ...mapGetters('sensors',{
            errors: "getErrorsSensors",
            isLoading: "getIsLoading",
            sensorsList: "getSensorsList",
        }),
    },

    methods: {
        ...mapActions('sensors',[
            "fetchSensors",
            "sensorStoreCommit",
        ]),

        editSensor(data){
            var sensorCopy = { ... data.item}
            this.sensorStoreCommit({ mutation: "SET_CURRENT_SENSOR", value: sensorCopy })
            this.isEditing = true
            this.openModalSensors()
        },

        deleteSensor(sensor){
            console.log("TYPE SENSOR >>", sensor)
        },

        openModalSensors(){ this.openModal = true; },

        closeModalSensors(){ this.openModal = false; this.isEditing = false },
    },
};
</script>
  
<style scoped>
.blackened {
    background-color: #fff;
}
</style>