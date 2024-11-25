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
                            Buscar
                        </b-button>
                    </b-form>
                </b-col>
            </b-row>

            <b-container fluid class="pb-5">
                <b-row>
                    <b-col xs="12" sm="12" md="4" lg="4">
                        <b-card class="subcard-p-3">
                            <h4 v-if="!isLoading" class="card-title mb-0">
                                <p class="text-gray mb-0 d-flex justify-content-between">
                                    Eventos <b>{{ eventsList.length }}</b>
                                </p>
                            </h4>
                            <b-skeleton v-else width="85%" class="text-center"></b-skeleton>
                        </b-card>
                    </b-col>

                    <b-col xs="12" sm="12" md="4" lg="4">
                        <b-card class="subcard-p-3">
                            <h4 v-if="!isLoading" class="card-title mb-0">
                                <p class="text-gray mb-0 d-flex justify-content-between">
                                    Regiões <b>{{ regionsList.length }}</b>
                                </p>
                            </h4>
                            <b-skeleton v-else width="85%" class="text-center"></b-skeleton>
                        </b-card>
                    </b-col>

                    <b-col xs="12" sm="12" md="4" lg="4">
                        <b-card class="subcard-p-3">
                            <h4 v-if="!isLoading" class="card-title mb-0">
                                <p class="text-gray mb-0 d-flex justify-content-between">
                                    ZIs <b>{{ interestZonesList.length }}</b>
                                </p>
                            </h4>
                            <b-skeleton v-else width="85%" class="text-center"></b-skeleton>
                        </b-card>
                    </b-col>
                </b-row>

                <b-row class="pt-3">
                    <b-col xs="12" sm="12" md="4" lg="4">
                        <b-card class="subcard-p-3">
                            <h4 v-if="!isLoading" class="card-title mb-0">
                                <p class="text-gray mb-0 d-flex justify-content-between">
                                    UDEs <b>{{ udesList.length }}</b>
                                </p>
                            </h4>
                            <b-skeleton v-else width="85%" class="text-center"></b-skeleton>
                        </b-card>
                    </b-col>

                    <b-col xs="12" sm="12" md="4" lg="4">
                        <b-card class="subcard-p-3">
                            <h4 v-if="!isLoading" class="card-title mb-0">
                                <p class="text-gray mb-0 d-flex justify-content-between">
                                    Sensores <b>{{ sensorsList.length }}</b>
                                </p>
                            </h4>
                            <b-skeleton v-else width="85%" class="text-center"></b-skeleton>
                        </b-card>
                    </b-col>

                    <b-col xs="12" sm="12" md="4" lg="4">
                        <b-card class="subcard-p-3">
                            <h4 v-if="!isLoading" class="card-title mb-0">
                                <p class="text-gray mb-0 d-flex justify-content-between">
                                    Emergências <b>{{ emergenciesList.length }}</b>
                                </p>
                            </h4>
                            <b-skeleton v-else width="85%" class="text-center"></b-skeleton>
                        </b-card>
                    </b-col>
                </b-row>

                <b-row class="pt-5">
                    <b-col cols="6">
                        <b-card class="pb-0" body-class="pb-0" header-bg-variant="transparent">
                            <template v-slot:header>
                                <div class="row">
                                    <h3 class="mb-0 pr-0 col-md-12 col-sm-12">Eventos por região</h3>
                                </div>
                            </template>

                            <div style="margin: 0; padding: 0;">
                                <div v-if="!isLoading && eventsList.length > 0">
                                    <events-by-region-bar-chart :defaultBarThickness="defaultBarThickness" :maxBarThickness="maxBarThickness">
                                    </events-by-region-bar-chart>
                                </div>

                                <b-skeleton-img v-else-if="isLoading" style="margin: 0; padding: 0;" height="200px" class="pb-0"></b-skeleton-img>
                            </div>
                        </b-card>
                    </b-col>

                    <b-col cols="6">
                        <b-card class="pb-0" body-class="pb-0" header-bg-variant="transparent">
                            <template v-slot:header>
                                <div class="row">
                                    <h3 class="mb-0 pr-0 col-md-12 col-sm-12">Eventos por horário</h3>
                                </div>
                            </template>

                            <div style="margin: 0; padding: 0;">
                                <div v-if="!isLoading && eventsList.length > 0">
                                    <events-by-hour-line-chart :defaultBarThickness="defaultBarThickness" :maxBarThickness="maxBarThickness">
                                    </events-by-hour-line-chart>
                                </div>

                                <b-skeleton-img v-else-if="isLoading" style="margin: 0; padding: 0;" height="200px" class="pb-0"></b-skeleton-img>
                            </div>
                        </b-card>
                    </b-col>
                </b-row>

                <b-row class="pt-5">
                    <b-col cols="6">
                        <b-card class="pb-0" body-class="pb-0" header-bg-variant="transparent">
                            <template v-slot:header>
                                <div class="row">
                                    <h3 class="mb-0 pr-0 col-md-12 col-sm-12">Eventos por emergência</h3>
                                </div>
                            </template>

                            <div style="margin: 0; padding: 0;">
                                <div v-if="!isLoading && eventsList.length > 0">
                                    <events-by-emergency-bar-chart :defaultBarThickness="defaultBarThickness" :maxBarThickness="maxBarThickness">
                                    </events-by-emergency-bar-chart>
                                </div>

                                <b-skeleton-img v-else-if="isLoading" style="margin: 0; padding: 0;" height="200px" class="pb-0"></b-skeleton-img>
                            </div>
                        </b-card>
                    </b-col>

                    <b-col cols="6">
                        <b-card class="pb-0" body-class="pb-0" header-bg-variant="transparent">
                            <template v-slot:header>
                                <b-row class="d-flex justify-content-between">
                                    <b-col>
                                        <h3 class="mb-0 pr-0 col-md-12 col-sm-12">Eventos por data</h3>
                                    </b-col>

                                    <b-col v-if="!isLoading && eventsList.length > 0" class="text-right">
                                        <b-button variant="outline-primary" :class="{ 'active': eventByDateView === 'month' }" @click="eventByDateView = 'month'" class="btn btn-sm">
                                            mês
                                        </b-button>

                                        <b-button variant="outline-primary" :class="{ 'active': eventByDateView === 'day' }" @click="eventByDateView = 'day'" class="btn btn-sm">
                                            data
                                        </b-button>

                                        <b-button variant="outline-primary" :class="{ 'active': eventByDateView === 'weekday' }" @click="eventByDateView = 'weekday'" class="btn btn-sm">
                                            dia da semana
                                        </b-button>
                                    </b-col>
                                </b-row>
                            </template>

                            <div style="margin: 0; padding: 0;">
                                <div v-if="!isLoading && eventsList.length > 0">
                                    <events-by-date-bar-chart :eventByDateView="eventByDateView" :defaultBarThickness="defaultBarThickness" :maxBarThickness="maxBarThickness">
                                    </events-by-date-bar-chart>
                                </div>

                                <b-skeleton-img v-else-if="isLoading" style="margin: 0; padding: 0;" height="200px" class="pb-0"></b-skeleton-img>
                            </div>
                        </b-card>
                    </b-col>
                </b-row>
            </b-container>
        </div>
    </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import moment from "moment"
import { DatePicker } from 'element-ui'
import EventsByRegionBarChart from './charts/EventsByRegionBarChart.vue';
import EventsByHourLineChart from './charts/EventsByHourLineChart.vue';
import EventByDateBarChart from './charts/EventByDateBarChart.vue';
import EventsByEmergencyBarChart from './charts/EventsByEmergencyBarChart.vue';

export default {
    name: '',

    components:{
        DatePicker,
        EventsByRegionBarChart,
        EventsByHourLineChart,
        EventByDateBarChart,
        EventsByEmergencyBarChart,
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

        ...mapGetters('emergencies',{
            errorsEmergencies: "getErrorsEmergencies",
            emergenciesList: "getEmergenciesList",
        }),
        
    },

    watch: {
        // eventsList(newValue){
        //     if(newValue){
        //         newValue.map(function(value, index){
        //             console.log('VALUE >>>>', value.timestamp);
        //         })
        //     }
        // },
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
            defaultBarThickness: 12, maxBarThickness: 30,
            eventByDateView: 'weekday',
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

        ...mapActions('emergencies',[
            "fetchEmergencies",
        ]),

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
        this.fetchEmergencies()
    },

}
</script>

<style>
.no-border-card .card-footer {
  border-top: 0;
}

</style>