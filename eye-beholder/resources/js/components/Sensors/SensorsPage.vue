<template>
    <div class="blackened container">
        <b-row align-h="between" align-v="center" style="margin-top: 5px;" class="container">
            <b-col cols="10">
                <h3>Sensores</h3>
            </b-col>

            <b-col cols="2">
                <b-button :disabled="isDownloadingCsv" @click="openModalSensors" variant="primary" squared>
                    <i class="fa-solid fa-plus"></i>
                </b-button>

                <b-button :disabled="isDownloadingCsv || sensorsList.length == 0" @click="downloadCsv" variant="outline-success" outlined squared>
                    <i class="fa-solid fa-download"></i>
                </b-button>
            </b-col>
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
                                    <b-button :disabled="isDownloadingCsv" @click="editSensor(data)" size="sm" variant="outline-secondary">
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
            openModal: false, isEditing: false, isDownloadingCsv: false,
            sensorsFields:[
                { key: "id", label: "ID", sortable: true }, { key: "type_sensor.type", label: "Tipo de Sensor", sortable: true },
                { key: "model", label: "Modelo", sortable: true },  //{ key: "description", label: "Descrição", sortable: true },
                { key: "actions", label: "Ações", sortable: false },
            ],
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

        openModalSensors(){
            this.sensorStoreCommit({ mutation: "RESET_ERRORS_SENSORS" })
            this.openModal = true; 
        },

        closeModalSensors(){ 
            this.openModal = false; this.isEditing = false
            this.sensorStoreCommit({ mutation: "RESET_CURRENT_SENSOR" })
        },

        downloadCsv(){
            this.isDownloadingCsv = true
            var data = new Date().toLocaleString().toString().replace(/\//g, '-')

            var mat = this.sensorsList.map(function(val){
                return [
                    val.id,
                    val.type_sensor.type,
                    val.model,
                    val.description,
                    new Date(val.created_at).toLocaleString().toString().replace(/\//g, '-'),
                ];
            });

            mat.unshift([
                'ID', 'Tipo de Sensor', 'Modelo', 'Descrição', 'Criado em',
            ]);
            var universalBOM = "\uFEFF";
            let csvContent = "data:text/csv;charset=utf-8," + universalBOM + mat.map(e => e.join(";")).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Planilha Sensores - " + data +  ".csv");
            document.body.appendChild(link);

            link.click();
            this.isDownloadingCsv = false
        },

    },
};
</script>
  
<style scoped>
.blackened {
    background-color: #fff;
}
</style>