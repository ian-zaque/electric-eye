<template>
    <div class="blackened container">
        <b-row align-h="between" style="margin-top: 5px;" class="container">
            <b-col cols="10">
                <h3>Zonas de Interesse</h3>
            </b-col>

            <b-col cols="2">
                <b-button :disabled="isDownloadingCsv" @click="openModalInterestZones" variant="primary">
                    <i class="fa-solid fa-plus"></i>
                </b-button>

                <b-button :disabled="isDownloadingCsv || interestZonesList.length == 0" @click="downloadCsv" variant="outline-success" outlined>
                    <i class="fa-solid fa-download"></i>
                </b-button>
            </b-col>
        </b-row>

        <b-row cols="12">
            <b-col>
                <b-card footer-classes="pb-2">
                    <div>
                        <b-table :items="interestZonesList" :fields="interestZonesFields" :busy="isLoading" :sortDesc="true" empty-text="Não há Zonas de Interesse registradas." hover show-empty 
                            responsive="sm" small>
                            <template #table-busy>
                                <div class="text-center text-secondary my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Carregando...</strong>
                                </div>
                            </template>

                            <template #cell(region)="data">
                                {{  data.value.name }}
                            </template>

                            <template #cell(actions)="data">
                                <b-row align-h="around">
                                    <b-button :disabled="isDownloadingCsv" @click="editInterestZone(data)" size="sm" variant="outline-secondary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </b-button>

                                    <b-button :disabled="isDownloadingCsv" @click="confirmDeleteInterestZone(data.item)" size="sm" variant="outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </b-button>
                                </b-row>
                            </template>
                        </b-table>
                    </div>
                </b-card>
            </b-col>
        </b-row>

        <interest-zones-modal :showModal="openModal" @closeModal="closeModalInterestZones" :isEditing="isEditing"></interest-zones-modal>
    </div>
</template>
  
<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: 'InterestZonesPage',

    components:{
    },

    data() {
        return {
            openModal: false, isEditing: false, isDownloadingCsv: false,
            interestZonesFields:[
                { key: "id", label: "ID", sortable: true }, { key: "name", label: "Nome", sortable: true },
                { key: "region", label: "Região", sortable: true }, { key: "actions", label: "Ações", sortable: false },
            ]
        }
    },

    mounted(){
        this.fetchInterestZones();
    },

    computed:{
        ...mapGetters('interestZones',{
            errors: "getErrorsInterestZones",
            interestZonesList: "getInterestZonesList",
        }),

        
        ...mapGetters('loading', {
            isLoading: "isLoading",
        })
    },

    methods: {
        ...mapActions('interestZones',[
            "fetchInterestZones",
            "deleteInterestZone",
            "interestZoneStoreCommit",
        ]),

        editInterestZone(data){
            var interestZoneCopy = { ...data.item}
            this.interestZoneStoreCommit({ mutation: "SET_CURRENT_INTEREST_ZONE", value: interestZoneCopy })
            this.isEditing = true
            this.openModalInterestZones()
        },

        confirmDeleteInterestZone(interestZone){
            this.$bvModal
                .msgBoxConfirm(`Deseja mesmo deletar a Zona de Interesse ${interestZone.name} - ${interestZone.id}'?`, {
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
                    this.deleteInterestZone(interestZone);
                }
            })
            .catch((err) => {
            // An error occurred
            });
        },

        openModalInterestZones(){ this.interestZoneStoreCommit({ mutation: "RESET_ERRORS_INTEREST_ZONES" }); this.openModal = true; },
        closeModalInterestZones(){ this.openModal = false; this.isEditing = false },

        downloadCsv(){
            this.isDownloadingCsv = true
            var data = new Date().toLocaleString().toString().replace(/\//g, '-')

            var mat = this.interestZonesList.map(function(val){
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
            link.setAttribute("download", "Planilha Zonas de Interesse - " + data +  ".csv");
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