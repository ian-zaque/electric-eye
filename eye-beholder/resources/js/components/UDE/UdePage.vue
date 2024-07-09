<template>
    <div class="blackened container">
        <b-row align-h="between" style="margin-top: 5px;" class="container">
            <b-col cols="10">
                <h3>UDEs</h3>
            </b-col>

            <b-col cols="2">
                <b-button :disabled="isDownloadingCsv" @click="openModalUdes" variant="primary" squared>
                    <i class="fa-solid fa-plus"></i>
                </b-button>

                <b-button :disabled="isDownloadingCsv || udeList.length == 0" @click="downloadCsv" variant="outline-success" outlined squared>
                    <i class="fa-solid fa-download"></i>
                </b-button>
            </b-col>
        </b-row>

        <b-row cols="12">
            <b-col>
                <b-card footer-classes="pb-2">
                    <div>
                        <b-table :items="udeList" :fields="udesFields" :busy="isLoading" :sortDesc="true" empty-text="Não há UDEs registradas." hover show-empty 
                            responsive="sm" small>
                            <template #table-busy>
                                <div class="text-center my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Carregando...</strong>
                                </div>
                            </template>

                            <template #cell(ude_class)="data">
                                {{  data.value.name }}
                            </template>

                            <template #cell(interest_zone)="data">
                                {{  data.value.name }}
                            </template>

                            <template #cell(actions)="data">
                                <b-row align-h="around">
                                    <b-button :disabled="isDownloadingCsv" @click="editUde(data)" size="sm" variant="outline-secondary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </b-button>

                                    <b-button disabled @click="deleteUde(data)" size="sm" variant="outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </b-button>
                                </b-row>
                            </template>
                        </b-table>
                    </div>
                </b-card>
            </b-col>
        </b-row>

        <udes-modal :showModal="openModal" @closeModal="closeModalUdes" :isEditing="isEditing"></udes-modal>
    </div>
</template>
  
<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: 'UdesPage',

    components:{
    },

    data() {
        return {
            openModal: false, isEditing: false, isDownloadingCsv: false,
            udesFields:[
                { key: "id", label: "ID", sortable: true }, { key: "name", label: "Nome", sortable: true },
                { key: "ude_class", label: "Classe", sortable: true }, { key: "interest_zone", label: "Zona de Interesse", sortable: true }, 
                { key: "actions", label: "Ações", sortable: false },
            ]
        }
    },

    mounted(){
        this.fetchUdes();
    },

    computed:{
        ...mapGetters('udes',{
            errors: "getErrorsUdes",
            isLoading: "getIsLoading",
            udeList: "getUdesList",
        }),
    },

    methods: {
        ...mapActions('udes',[
            "fetchUdes",
            "UdestoreCommit",
        ]),

        editUde(data){
            var udeCopy = { ...data.item}
            this.UdestoreCommit({ mutation: "SET_CURRENT_UDE", value: udeCopy })
            this.isEditing = true
            this.openModalUdes()
        },

        deleteUde(ude){
            console.log("TYPE ude >>", ude)
        },

        openModalUdes(){ this.openModal = true; },
        closeModalUdes(){ this.openModal = false; this.isEditing = false },

        downloadCsv(){
            this.isDownloadingCsv = true
            var data = new Date().toLocaleString().toString().replace(/\//g, '-')

            var mat = this.udeList.map(function(val){
                return [
                    val.id,
                    val.name,
                    val.region.name,
                    val.description,
                    new Date(val.created_at).toLocaleString().toString().replace(/\//g, '-'),
                ];
            });

            mat.unshift([
                'ID', 'Nome', 'Região', 'Descrição', 'Criado em',
            ]);
            var universalBOM = "\uFEFF";
            let csvContent = "data:text/csv;charset=utf-8," + universalBOM + mat.map(e => e.join(";")).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Planilha Unidades de Detecção de Emergências - " + data +  ".csv");
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