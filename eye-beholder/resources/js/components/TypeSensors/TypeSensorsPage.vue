<template>
    <div class="blackened container">
        <b-row align-h="between" align-v="center" style="margin-top: 5px;" class="container">
            <b-col cols="10">
                <h3>Tipos de Sensores</h3>
            </b-col>
            
            <b-col cols="2">
                <b-button :disabled="isDownloadingCsv" @click="openModalTypes" variant="primary" squared>
                    <i class="fa-solid fa-plus"></i>
                </b-button>

                <b-button :disabled="isDownloadingCsv || typeSensorsList.length == 0" @click="downloadCsv" variant="outline-success" outlined squared>
                    <i class="fa-solid fa-download"></i>
                </b-button>
            </b-col>
        </b-row>

        <b-row cols="12">
            <b-col>
                <b-card footer-classes="pb-2">
                    <div>
                        <b-table :items="typeSensorsList" :fields="typesSensorsFields" :busy="isLoading" :sortDesc="true" empty-text="Não há tipos de sensores registrados." 
                            show-empty hover responsive="sm" small>
                            <template #table-busy>
                                <div class="text-center text-secondary my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Carregando...</strong>
                                </div>
                            </template>

                            <template #cell(actions)="data">
                                <b-row align-h="around">
                                    <b-button :disabled="isDownloadingCsv" @click="editTypeSensor(data)" size="sm" variant="outline-secondary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </b-button>
                                    
                                    <b-button @click="deleteTypeSensor(data)" size="sm" variant="outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </b-button>
                                </b-row>
                            </template>

                        </b-table>
                    </div>
                </b-card>
            </b-col>
        </b-row>

        <type-sensors-modal :showModal="openModal" @closeModal="closeModalTypes" :isEditing="isEditing"></type-sensors-modal>
    </div>
</template>
  
<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: 'TypeSensorsPage',

    components:{
    },

    data() {
        return {
            openModal: false, isEditing: false, isDownloadingCsv: false,
            typesSensorsFields:[
                { key: "id", label: "ID", sortable: true }, { key: "type", label: "Tipo", sortable: true },
                { key: "unit", label: "Unidade de Medida", sortable: true }, //{ key: "description", label: "Descrição", sortable: true },
                { key: "actions", label: "Ações", sortable: false },
            ]
        };
    },

    mounted(){
        this.fetchTypeSensors()
    },

    computed:{
        ...mapGetters('typeSensors',{
            errors: "getErrorsTypeSensors",
            typeSensorsList: "getTypeSensorsList",
        }),

        ...mapGetters('loading', {
            isLoading: "isLoading",
        })
    },

    methods: {
        ...mapActions('typeSensors',[
            "fetchTypeSensors",
            "typeSensorStoreCommit",
        ]),

        editTypeSensor(data){
            var typeSensorCopy = { ... data.item}
            this.typeSensorStoreCommit({ mutation: "SET_CURRENT_TYPE_SENSOR", value: typeSensorCopy })
            this.isEditing = true
            this.openModalTypes()
        },

        deleteTypeSensor(typeSensor){
            console.log("TYPE SENSOR >>", typeSensor)
        },

        openModalTypes(){ 
            this.openModal = true;
            this.typeSensorStoreCommit({ mutation: "RESET_ERRORS_TYPE_SENSORS" })
        },

        closeModalTypes(){ 
            this.openModal = false; this.isEditing = false
            this.typeSensorStoreCommit({ mutation: "RESET_ERRORS_TYPE_SENSORS" })
        },

        downloadCsv(){
            this.isDownloadingCsv = true
            var data = new Date().toLocaleString().toString().replace(/\//g, '-')

            var mat = this.typeSensorsList.map(function(val){
                return [
                    val.id,
                    val.type,
                    val.unit,
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
            link.setAttribute("download", "Planilha Tipo de Sensores - " + data +  ".csv");
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