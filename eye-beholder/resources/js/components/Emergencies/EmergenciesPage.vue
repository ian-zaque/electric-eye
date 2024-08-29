<template>
    <div class="blackened container">
        <b-row align-h="between" style="margin-top: 5px;" class="container">
            <b-col cols="10">
                <h3>Emergências</h3>
            </b-col>

            <b-col cols="2">
                <b-button :disabled="isDownloadingCsv" @click="openModalEmergencies" variant="primary" squared>
                    <i class="fa-solid fa-plus"></i>
                </b-button>

                <b-button :disabled="isDownloadingCsv || emergenciesList.length == 0" @click="downloadCsv" variant="outline-success" outlined squared>
                    <i class="fa-solid fa-download"></i>
                </b-button>
            </b-col>
        </b-row>

        <b-row cols="12">
            <b-col>
                <b-card footer-classes="pb-2">
                    <div>
                        <b-table :items="emergenciesList" :fields="emergenciesFields" :busy="isLoading" :sortDesc="true" hover show-empty responsive="sm" small empty-text="Não há Emergências registradas.">
                            <template #table-busy>
                                <div class="text-center my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Carregando...</strong>
                                </div>
                            </template>

                            <template #cell(show_details)="row">
                                <b-button @click="row.toggleDetails" size="sm" class="mr-2" variant="outline-secondary">
                                    {{ row.detailsShowing ? 'Recolher' : 'Ver'}}
                                </b-button>
                            </template>

                            <template #row-details="row">
                                <b-container>
                                    <b-table :items="row.item.emergency_parameters" :fields="parametersFields" caption-top small show-empty empty-text="Sem parâmetros cadastrados.">
                                        <template #table-caption>
                                            Parâmetros de <b>{{ row.item.name }}</b>

                                            <b-button @click="downloadCsvParameters(row.item)" :disabled="row.item.emergency_parameters.length == 0" size="sm" variant="outline-primary">
                                                <i class="fa-solid fa-file-arrow-down"></i>
                                            </b-button>
                                        </template>
                                    </b-table>
                                </b-container>
                            </template>

                            <template #cell(actions)="data">
                                <b-row align-h="around">
                                    <b-button :disabled="isDownloadingCsv" @click="editEmergency(data)" size="sm" variant="outline-secondary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </b-button>

                                    <b-button disabled @click="deleteEmergency(data)" size="sm" variant="outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </b-button>
                                </b-row>
                            </template>
                        </b-table>
                    </div>
                </b-card>
            </b-col>
        </b-row>

        <emergencies-modal :showModal="openModal" @closeModal="closeModalEmergencies" :isEditing="isEditing"></emergencies-modal>
    </div>
</template>
  
<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: 'EmergenciesPage',

    components:{
    },

    data() {
        return {
            openModal: false, isEditing: false, isDownloadingCsv: false,
            emergenciesFields:[
                { key: "id", label: "ID", sortable: true }, { key: "name", label: "Nome", sortable: true },
                { key: "interest_zone.name", label: "Zona de Interesse", sortable: true }, { key: "show_details", label: "Parâmetros", sortable: false },
                { key: "actions", label: "Ações", sortable: false },
            ],
            parametersFields: [
                { key: "name", label: "Nome", sortable: true }, { key: "value", label: "Valor", sortable: true },
            ]
        }
    },

    async mounted(){
        await this.fetchEmergencies();
    },

    computed:{
        ...mapGetters('emergencies',{
            errors: "getErrorsEmergencies",
            isLoading: "getIsLoading",
            emergenciesList: "getEmergenciesList",
        }),
    },

    methods: {
        ...mapActions('emergencies',[
            "fetchEmergencies",
            "emergenciesStoreCommit",
        ]),

        editEmergency(data){
            var emergencyCopy = { ...data.item}
            if(emergencyCopy.emergency_parameters.length == 0){
                emergencyCopy.emergency_parameters.push({ name: "", value: ""})
            }
            this.emergenciesStoreCommit({ mutation: "SET_CURRENT_EMERGENCY", value: emergencyCopy })
            this.isEditing = true
            this.openModalEmergencies()
        },

        deleteEmergency(emergency){
            console.log("TYPE emergency >>", emergency)
        },

        openModalEmergencies(){ 
            this.emergenciesStoreCommit({ mutation: "RESET_ERRORS_EMERGENCIES" });
            this.openModal = true;
        },

        closeModalEmergencies(){ 
            this.openModal = false; this.isEditing = false;
            this.emergenciesStoreCommit({ mutation: "RESET_CURRENT_EMERGENCY" })
        },

        downloadCsv(){
            this.isDownloadingCsv = true
            var data = new Date().toLocaleString().toString().replace(/\//g, '-')

            var mat = this.emergenciesList.map(function(val){
                return [
                    val.id,
                    val.name,
                    val.interest_zone.region.name,
                    val.interest_zone.name,
                    new Date(val.created_at).toLocaleString().toString().replace(/\//g, '-'),
                ];
            });

            mat.unshift([
                'ID', 'Nome', 'Região', 'Zona de Interesse', 'Criado em',
            ]);
            var universalBOM = "\uFEFF";
            let csvContent = "data:text/csv;charset=utf-8," + universalBOM + mat.map(e => e.join(";")).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Planilha Emergências - " + data +  ".csv");
            document.body.appendChild(link);

            link.click();
            this.isDownloadingCsv = false
        },

        downloadCsvParameters(emergency){
            this.isDownloadingCsv = true
            var data = new Date().toLocaleString().toString().replace(/\//g, '-')

            var mat = emergency.emergency_parameters.map(function(val){
                return [
                    emergency.name,
                    val.id,
                    val.name,
                    val.value,
                    new Date(val.created_at).toLocaleString().toString().replace(/\//g, '-'),
                ];
            });

            mat.unshift([
                'Emergência', 'ID', 'Parâmetro', 'Valor de referência', 'Criado em',
            ]);
            var universalBOM = "\uFEFF";
            let csvContent = "data:text/csv;charset=utf-8," + universalBOM + mat.map(e => e.join(";")).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Planilha Parâmetros da Emergência " + emergency.name + " - " + data +  ".csv");
            document.body.appendChild(link);

            link.click();
            this.isDownloadingCsv = false
        }

    },
};
</script>
  
<style scoped>
.blackened {
    background-color: #fff;
}
</style>