<template>
    <div class="blackened container">
        <b-row align-h="between" align-v="center" style="margin-top: 5px;" class="container">
            <h3>Regiões</h3>

            <b-button @click="openModalRegions" variant="primary" squared>
                <i class="fa-solid fa-plus"></i>
            </b-button>
        </b-row>

        <b-row cols="12">
            <b-col>
                <b-card footer-classes="pb-2">
                    <div>
                        <b-table :items="regionsList" :fields="regionsFields" :busy="isLoading" :sortDesc="true" empty-text="Não há regiões registradas." 
                            hover show-empty responsive="sm" small>
                            <template #table-busy>
                                <div class="text-center my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Carregando...</strong>
                                </div>
                            </template>

                            <template #cell(actions)="data">
                                <b-row align-h="around">
                                    <b-button @click="editRegion(data)" size="sm" variant="outline-secondary">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </b-button>

                                    <b-button @click="deleteRegion(data)" size="sm" variant="outline-danger">
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
            openModal: false, isEditing: false,
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
            "regionstoreCommit",
        ]),

        editRegion(data){
            var regionCopy = { ... data.item}
            this.regionstoreCommit({ mutation: "SET_CURRENT_REGION", value: regionCopy })
            this.isEditing = true
            this.openModalRegions()
        },

        deleteRegion(region){
            console.log("TYPE region >>", region)
        },

        openModalRegions(){ this.openModal = true; },

        closeModalRegions(){ this.openModal = false; this.isEditing = false },
    },
};
</script>
  
<style scoped>
.blackened {
    background-color: #fff;
}
</style>