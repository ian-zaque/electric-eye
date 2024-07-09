<template>
    <div class="blackened container">
        <b-row align-h="between" style="margin-top: 5px;" class="container">
            <b-col cols="10">
                <h3>Classes de UDE</h3>
            </b-col>

            <b-col cols="2">
                <!-- <b-button :disabled="isDownloadingCsv" @click="openModalUdeClasses" variant="primary" squared>
                    <i class="fa-solid fa-plus"></i>
                </b-button> -->

                <b-button :disabled="isDownloadingCsv || udeClassesList.length == 0" @click="downloadCsv" variant="outline-success" outlined squared>
                    <i class="fa-solid fa-download"></i>
                </b-button>
            </b-col>
        </b-row>

        <b-row cols="12">
            <b-col>
                <b-card footer-classes="pb-2">
                    <div>
                        <b-table :items="udeClassesList" :fields="udeClassesFields" :busy="isLoading" :sortDesc="true" empty-text="Não há Classes de UDE registradas." hover show-empty 
                            responsive="sm" small>
                            <template #table-busy>
                                <div class="text-center my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Carregando...</strong>
                                </div>
                            </template>

                            <template #cell(actions)="data">
                                <b-row align-h="around">
                                    <b-button :disabled="isDownloadingCsv" @click="editUdeClass(data)" size="sm" variant="outline-secondary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </b-button>

                                    <!-- <b-button disabled @click="deleteUde(data)" size="sm" variant="outline-danger">
                                        <i class="fa-solid fa-trash"></i>
                                    </b-button> -->
                                </b-row>
                            </template>
                        </b-table>
                    </div>
                </b-card>
            </b-col>
        </b-row>

        <ude-classes-modal :showModal="openModal" @closeModal="closeModalUdeClass" :isEditing="isEditing"></ude-classes-modal>
    </div>
</template>
  
<script>
import { mapGetters, mapActions } from "vuex";

export default {
    name: 'UdeClassPage',

    components:{
    },

    data() {
        return {
            openModal: false, isEditing: false, isDownloadingCsv: false,
            udeClassesFields:[
                { key: "id", label: "ID", sortable: true }, { key: "class", label: "Classe", sortable: true },
                { key: "fullname", label: "Nome", sortable: true }, { key: "actions", label: "Ações", sortable: false },
            ]
        }
    },

    async mounted(){
        await this.fetchUdeClasses();
    },

    computed:{
        ...mapGetters('udeClasses',{
            errors: "getErrorsUdeClasses",
            isLoading: "getIsLoading",
            udeClassesList: "getUdeClassesList",
        }),
    },

    methods: {
        ...mapActions('udeClasses',[
            "fetchUdeClasses",
            "udeClassStoreCommit",
        ]),

        editUdeClass(data){
            var udeClassCopy = { ...data.item}
            this.udeClassStoreCommit({ mutation: "SET_CURRENT_UDE_CLASS", value: udeClassCopy })
            this.isEditing = true
            this.openModalUdeClass()
        },

        deleteUde(ude){
            console.log("TYPE ude >>", ude)
        },

        openModalUdeClass(){ this.udeClassStoreCommit({ mutation: "RESET_ERRORS_UDE_CLASSES" }); this.openModal = true; },
        closeModalUdeClass(){ this.openModal = false; this.isEditing = false },

        downloadCsv(){
            this.isDownloadingCsv = true
            var data = new Date().toLocaleString().toString().replace(/\//g, '-')

            var mat = this.udeClassesList.map(function(val){
                return [
                    val.id,
                    val.class,
                    val.fullname,
                    new Date(val.created_at).toLocaleString().toString().replace(/\//g, '-'),
                ];
            });

            mat.unshift([
                'ID', 'Classe', 'Nome da Classe', 'Criado em',
            ]);
            var universalBOM = "\uFEFF";
            let csvContent = "data:text/csv;charset=utf-8," + universalBOM + mat.map(e => e.join(";")).join("\n");
            var encodedUri = encodeURI(csvContent);
            var link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "Planilha Classes de UDE - " + data +  ".csv");
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