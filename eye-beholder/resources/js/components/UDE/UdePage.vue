<template>
    <div class="blackened container">
        <b-row align-h="between" style="margin-top: 5px;" class="container">
            <b-col cols="10">
                <h3>UDEs</h3>
            </b-col>

            <b-col cols="2">
                <b-button :disabled="isDownloadingCsv" @click="openModalUdes" variant="primary">
                    <i class="fa-solid fa-plus"></i>
                </b-button>

                <b-button :disabled="isDownloadingCsv || udesList.length == 0" @click="downloadCsv" variant="outline-success" outlined>
                    <i class="fa-solid fa-download"></i>
                </b-button>
            </b-col>
        </b-row>

        <b-row cols="12">
            <b-col>
                <b-card footer-classes="pb-2">
                    <div>
                        <b-table :items="udesList" :fields="udesFields" :busy="isLoading" :sortDesc="true" empty-text="Não há UDEs registradas." hover show-empty responsive="sm" small>
                            <template #table-busy>
                                <div class="text-center text-secondary my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Carregando...</strong>
                                </div>
                            </template>

                            <template #cell(actions)="data">
                                <b-row align-h="around">
                                    <b-button :disabled="isDownloadingCsv" @click="editUde(data)" size="sm" variant="outline-secondary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </b-button>

                                    <b-button :disabled="isDownloadingCsv" @click="confirmDeleteUde(data.item)" size="sm" variant="outline-danger">
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
                { key: "ude_class.class", label: "Classe", sortable: true }, { key: "interest_zone.region.name", label: "Região", sortable: true },
                { key: "interest_zone.name", label: "Zona de Interesse", sortable: true }, { key: "actions", label: "Ações", sortable: false },
            ]
        }
    },

    async mounted(){
        await this.fetchUdes();
    },

    computed:{
        ...mapGetters('udes',{
            errors: "getErrorsUdes",
            udesList: "getUdesList",
        }),

        ...mapGetters('loading', {
            isLoading: "isLoading",
        })
    },

    methods: {
        ...mapActions('udes',[
            "fetchUdes",
            "udeStoreCommit",
            "deleteUde",
        ]),

        editUde(data){
            var udeCopy = { ...data.item}
            this.udeStoreCommit({ mutation: "SET_CURRENT_UDE", value: udeCopy })
            this.isEditing = true
            this.openModalUdes()
        },

        confirmDeleteUde(ude){
            this.$bvModal
                .msgBoxConfirm(`Deseja mesmo deletar a UDE ${ude.name} - ${ude.id}'?`, {
                title: "Por favor confirme",
                size: "sm",
                buttonSize: "sm",
                okVariant: "danger",
                okTitle: "Sim",
                cancelTitle: "Não",
                footerClass: "p-2",
                hideHeaderClose: false,
                centered: false,
                top: true,
            })
            .then((confirmacao) => {
                if (confirmacao) {
                    this.deleteUde(ude);
                }
            })
            .catch((err) => {
            // An error occurred
            });
        },

        openModalUdes(){ this.udeStoreCommit({ mutation: "RESET_ERRORS_UDES" }); this.openModal = true; },
        closeModalUdes(){ this.openModal = false; this.isEditing = false },

        downloadCsv(){
            this.isDownloadingCsv = true
            var data = new Date().toLocaleString().toString().replace(/\//g, '-')

            var mat = this.udesList.map(function(val){
                return [
                    val.id,
                    val.name,
                    val.ude_class.class,
                    val.interest_zone.region.name,
                    val.interest_zone.name,
                    val.latitude,
                    val.longitude,
                    new Date(val.created_at).toLocaleString().toString().replace(/\//g, '-'),
                ];
            });

            mat.unshift([
                'ID', 'Nome', 'Classe de UDE', 'Região', 'Zona de Interesse', 'Latitude', 'Longitude', 'Criado em',
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