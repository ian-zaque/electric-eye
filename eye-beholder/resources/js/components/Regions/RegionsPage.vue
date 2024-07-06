<template>
    <div class="blackened container">
        <b-row align-h="between" style="margin-top: 5px;" class="container">
            <b-col cols="10">
                <h3>Regiões</h3>
            </b-col>

            <b-col cols="2">
                <b-button :disabled="isDownloadingCsv" @click="openModalRegions" variant="primary" squared>
                    <i class="fa-solid fa-plus"></i>
                </b-button>

                <b-button :disabled="isDownloadingCsv" @click="downloadCsv" variant="outline-success" outlined squared>
                    <i class="fa-solid fa-download"></i>
                </b-button>
            </b-col>
        </b-row>

        <b-row cols="12">
            <b-col>
                <b-card footer-classes="pb-2">
                    <div>
                        <b-table :items="regionsList" :fields="regionsFields" :busy="isLoading" :sortDesc="true" empty-text="Não há regiões registradas." hover show-empty 
                            responsive="sm" small>
                            <template #table-busy>
                                <div class="text-center my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Carregando...</strong>
                                </div>
                            </template>

                            <template #cell(actions)="data">
                                <b-row align-h="around">
                                    <b-button :disabled="isDownloadingCsv" @click="editRegion(data)" size="sm" variant="outline-secondary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </b-button>

                                    <b-button disabled @click="deleteRegion(data)" size="sm" variant="outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </b-button>
                                </b-row>
                            </template>
                        </b-table>
                    </div>
                </b-card>
            </b-col>
        </b-row>

        <regions-modal :showModal="openModal" @closeModal="closeModalRegions" :isEditing="isEditing"></regions-modal>
    </div>
</template>
  
<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: 'RegionsPage',

    components:{
    },

    data() {
        return {
            openModal: false, isEditing: false, isDownloadingCsv: false,
            regionsFields:[
                { key: "id", label: "ID", sortable: true }, { key: "name", label: "Nome", sortable: true },
                { key: "description", label: "Descrição", sortable: true }, { key: "actions", label: "Ações", sortable: false },
            ]
        }
    },

    mounted(){
        this.fetchRegions();
    },

    computed:{
        ...mapGetters('regions',{
            errors: "getErrorsRegions",
            isLoading: "getIsLoading",
            regionsList: "getRegionsList",
        }),
    },

    methods: {
        ...mapActions('regions',[
            "fetchRegions",
            "regionStoreCommit",
        ]),

        editRegion(data){
            var regionCopy = { ...data.item}
            this.regionStoreCommit({ mutation: "SET_CURRENT_REGION", value: regionCopy })
            this.isEditing = true
            this.openModalRegions()
        },

        deleteRegion(region){
            console.log("TYPE region >>", region)
        },

        openModalRegions(){ this.openModal = true; },
        closeModalRegions(){ this.openModal = false; this.isEditing = false },

        downloadCsv(){
            this.isDownloadingCsv = true
            var data = new Date().toLocaleString().toString().replace(/\//g, '-')

            var mat = this.regionsList.map(function(val){
                return [
                    val.id,
                    val.name,
                    val.description,
                    new Date(val.created_at).toLocaleString().toString().replace(/\//g, '-'),
                ];
            });

            mat.unshift([
                'ID', 'Nome', 'Descrição', 'Criado em',
            ]);
            var universalBOM = "\uFEFF";
            let csvContent = "data:text/csv;charset=utf-8," + universalBOM + mat.map(e => e.join(";")).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Planilha Regiões - " + data +  ".csv");
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