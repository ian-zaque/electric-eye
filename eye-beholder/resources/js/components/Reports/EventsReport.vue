<template>
    <div>
        <div>
            <b-row align-v="end" align-h="between" class="mb-3">
                <b-col>
                    <h3 class="mb-1 container">Relatórios</h3>
                </b-col>

                <b-col class="pb-2 m-0 pl-0 pr-0">
                    <b-form inline>
                        <label class="sr-only" for="inline-form-input-inicio">Início</label>
                        <b-input-group size="sm" class="mr-sm-2 mb-sm-0">
                            <date-picker v-model="filtro_inicio" :picker-options="pickerOptions" type="datetime" placeholder="Início" format="dd/MM/yyyy HH:mm:ss" 
                                value-format="yyyy-MM-dd HH:mm:ss" size="small" id="inline-form-input-inicio">
                            </date-picker>
                        </b-input-group>
                        
                        <label class="sr-only" for="inline-form-input-final">Final</label>
                        <b-input-group size="sm" class="mr-sm-2 mb-sm-0">
                            <date-picker v-model="filtro_final" :picker-options="pickerOptions" type="datetime" placeholder="Final" format="dd/MM/yyyy HH:mm:ss" 
                                value-format="yyyy-MM-dd HH:mm:ss" size="small" id="inline-form-input-final">
                            </date-picker>
                        </b-input-group>

                        <b-button @click.prevent="searchEvents($event)" class="mr-sm-2 mb-sm-0" size="sm" variant="outline-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Buscar">
                            <b-icon icon="search"></b-icon>
                        </b-button>
                    </b-form>
                </b-col>
            </b-row>

            <b-container fluid>
                <b-row>
                    <b-col xs="12" sm="12" md="3" lg="3">
                        <b-card class="subcard-p-3">
                            <h4 class="card-title mb-0">Regiões</h4>
                            <p v-if="!isLoading" class="text-gray mb-0">
                                <b>{{ regionsList.length }}</b>
                            </p>
                        </b-card>
                    </b-col>

                    <b-col xs="12" sm="12" md="3" lg="3">
                        <b-card class="subcard-p-3">
                            <h4 class="card-title mb-0">ZIs</h4>
                            <p v-if="!isLoading" class="text-gray mb-0">
                                <b>{{ interestZonesList.length }}</b>
                            </p>
                        </b-card>
                    </b-col>

                    <b-col xs="12" sm="12" md="3" lg="3">
                        <b-card class="subcard-p-3">
                            <h4 class="card-title mb-0">UDEs</h4>
                            <p v-if="!isLoading" class="text-gray mb-0">
                                <b>{{ udesList.length }}</b>
                            </p>
                        </b-card>
                    </b-col>

                    <b-col xs="12" sm="12" md="3" lg="3">
                        <b-card class="subcard-p-3">
                            <h4 class="card-title mb-0">Sensores</h4>
                            <p v-if="!isLoading" class="text-gray mb-0">
                                <b>{{ sensorsList.length }}</b>
                            </p>
                        </b-card>
                    </b-col>
                </b-row>

                <b-row>
                    
                </b-row>
            </b-container>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import { DatePicker } from 'element-ui'

export default {
    name: '',

    components:{
        DatePicker,
    },

    props:{

    },

    computed: {
        ...mapGetters('events', { 
           eventsList: "getEventsList",
           errorsEvents: "getErrorsEvents",
        }),

        ...mapGetters('regions',{
            errorsRegions: "getErrorsRegions",
            regionsList: "getRegionsList",
        }),

        ...mapGetters('interestZones',{
            errors: "getErrorsInterestZones",
            interestZonesList: "getInterestZonesList",
        }),

        ...mapGetters('udes',{
            errorsUde: "getErrorsUdes",
            udesList: "getUdesList",
        }),

        ...mapGetters('sensors',{
            errorsSensors: "getErrorsSensors",
            sensorsList: "getSensorsList",
        }),

        ...mapGetters('loading', {
            isLoading: "isLoading",
        }),
        
    },

    watch: {
        
    },

    data() {
        return {
            filtro_inicio: "", filtro_final: "",
            pickerOptions: {
                shortcuts: [
                    { text: 'Semana passada', onClick(picker) { let semanaPassada = new Date(); semanaPassada.setTime(semanaPassada.getTime() - 3600 * 1000 * 24 * 7); picker.$emit('pick', semanaPassada); } },
                    { text: 'Ontem', onClick(picker) { let ontem = new Date(); ontem.setTime(ontem.getTime() - 3600 * 1000 * 24); picker.$emit('pick', ontem); } },
                    { text: 'Hoje', onClick(picker) { let hoje = new Date(); picker.$emit('pick', hoje); picker.$emit('pick', hoje); } },
                    { text: 'Amanhã', onClick(picker) { let amanha = new Date(); amanha.setTime(amanha.getTime() + 3600 * 1000 * 24); picker.$emit('pick', amanha); } },
                    { text: 'Semana que vem', onClick(picker) { let semanaQueVem = new Date(); semanaQueVem.setTime(semanaQueVem.getTime() + 3600 * 1000 * 24 * 7); picker.$emit('pick', semanaQueVem); } },
                ]
            },
        }
    },

    methods: {
        ...mapActions('events', [
            'fetchEventsByDate',
        ]),

        ...mapActions('sensors',[
            "fetchSensors",
        ]),

        ...mapActions('regions',[
            "fetchRegions",
        ]),

        ...mapActions('udes',[
            "fetchUdes",
        ]),

        ...mapActions('interestZones',[
            "fetchInterestZones",
        ]),

        //METHOD TO GROUP BY KEYGETTER.
        //KEYGETTER MUST BE "foo => foo.fieldYouWantToGroupBy"
        groupBy(list, keyGetter) {
            const map = new Map();
            list.forEach((item) => {
                const key = keyGetter(item);
                const collection = map.get(key);

                if (!collection) { map.set(key, [item]); }
                else { collection.push(item); }
            });
            return Array.from(map);
        },

        searchEvents(){
            if(moment(this.filtro_inicio).isAfter(this.filtro_final)){
                this.$bvModal
                    .msgBoxConfirm('A data final é anterior a data inicial. Por favor, altere!', {
                    title: "Seleção inválida de datas",
                    size: "sm",
                    buttonSize: "sm",
                    okVariant: "primary",
                    okTitle: "Ok",
                    cancelTitle: "Voltar",
                    footerClass: "p-2",
                    hideHeaderClose: false,
                    centered: false,
                    top: true,
                })
                .then((confirmacao) => {
                    if (confirmacao) {
                    }
                })

                return
            }
            else {
                this.fetchEventsByDate({ 
                    start_date: this.filtro_inicio,
                    end_date: this.filtro_final,
                })
            }
        },
        
    },

    mounted(){
        this.fetchSensors()
        this.fetchRegions()
        this.fetchUdes()
        this.fetchInterestZones()
    },

}
</script>