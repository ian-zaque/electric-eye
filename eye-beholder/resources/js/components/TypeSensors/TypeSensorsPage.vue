<template>
    <div class="blackened container">
        <b-row align-h="between" align-v="center" style="margin-top: 5px;" class="container">
            <h3>Tipos de Sensores</h3>
            
            <b-button @click="openModalTypes" variant="primary" squared>
                <i class="fa-solid fa-plus"></i>
            </b-button>
        </b-row>

        <b-row cols="12">
            <b-col>
                <b-card footer-classes="pb-2">
                    <div>
                        <b-table :items="typeSensorsList" :fields="typesSensorsFields" :busy="isLoading" :sortDesc="true" empty-text="Não há tipos de sensores registrados." 
                            show-empty hover responsive="sm" small>
                            <template #table-busy>
                                <div class="text-center my-2">
                                    <b-spinner class="align-middle"></b-spinner>
                                    <strong>Carregando...</strong>
                                </div>
                            </template>

                            <template #cell(actions)="data">
                                <b-row align-h="around">
                                    <b-button @click="editTypeSensor(data)" size="sm" variant="outline-secondary">
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
            openModal: false, isEditing: false,
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
            isLoading: "getIsLoading",
            typeSensorsList: "getTypeSensorsList",
        }),
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

        openModalTypes(){ this.openModal = true; },

        closeModalTypes(){ this.openModal = false; this.isEditing = false },
    },
};
</script>
  
<style scoped>
.blackened {
    background-color: #fff;
}
</style>