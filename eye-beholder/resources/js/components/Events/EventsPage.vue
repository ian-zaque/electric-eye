<template>
    <div>
        <div>
            <b-row align-v="end" align-h="between">
                <b-col>
                    <h3 class="mb-1">Eventos</h3>
                </b-col>

                <b-col class="pb-2 m-0">
                    <!-- <b-button size="sm" variant="outline-transparent" v-b-toggle.collapse-1 data-toggle="tooltip" data-placement="bottom" title="Mais Filtros">
                        <b-icon icon="filter-square-fill" variant="secondary" scale="1.5"></b-icon>
                    </b-button> -->

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
        </div>

        <b-card class="rounded border">
            <div v-if="!isLoading" id="map" style="height:500px;">
            </div>

            <div v-else>
                <div class="text-center text-secondary my-2">
                    <b-spinner class="align-middle"></b-spinner>
                    <strong>Carregando...</strong>
                </div>
            </div>
        </b-card>
    </div>
</template>


<script>
import { mapActions, mapGetters } from 'vuex';
import moment from "moment";
import { DatePicker } from 'element-ui'
import * as Leaflet from 'leaflet';
import markerIcon from "leaflet/dist/images/marker-icon.png";
import "leaflet/dist/leaflet.css"
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';
import "leaflet.markercluster";

export default {
    name: 'EventsPage',

    components:{
        DatePicker
    },

    props:{
    },

    computed: {
      ...mapGetters('events', { 
           eventsList: "getEventsList",
           errors: "getErrorsEvents",
        }),

        ...mapGetters('regions',{
            errorsRegions: "getErrorsRegions",
            regionsList: "getRegionsList",
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

        filteredEvents(){
            if(this.searchQuery.length > 0){
                return this.eventsList.filter(function(value, index){

                })
            }
            else {
                return this.eventsList
            }
        },
    },

    watch: {
    },

    data() {
        return {
            eventsMap: null, searchQuery: "",
            filtro: { regions: [], udes: [], sensors: [], },
            filtro_inicio: new Date(), filtro_final: "",
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
            'fetchEvents',
            'fetchEventsByDate',
            "eventsStoreCommit",
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

        populateEventsMap(){
            if(this.filteredEvents && this.filteredEvents.length > 0){
                const markers = Leaflet.markerClusterGroup();
                this.filteredEvents.map(function(value, index){
                    var measured_value = Object.values(JSON.parse(value.event))[0]

                    const each_marker = Leaflet.marker([value.ude.latitude, value.ude.longitude])
                        .bindPopup(`<strong> Evento ${value.id} </strong> <br>
                            UDE ${value.ude.ude_class.class}: ${value.ude.name} <br>
                            Data: ${moment(value.timestamp).format("DD/MM/YYYY hh:mm:ss")} <br>
                            <strong>${measured_value.sensor}: ${measured_value.value} </strong>
                        `);
                    markers.addLayer(each_marker);
                })
                this.eventsMap.addLayer(markers)
            }
        },

        createEventsMap(){
            this.eventsMap = Leaflet.map('map').setView([-12.2537, -38.9638], 13); // -12.253790862473762, -38.96389722015075 => prefeitura de Feira
            Leaflet.Marker.prototype.setIcon(Leaflet.icon({
                iconUrl: markerIcon
            }))
            Leaflet.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 17,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(this.eventsMap);
        },

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
                    .msgBoxConfirm('A data final é anterior a data inicial', {
                    title: "Seleção de datas",
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
                .then(() => {
                    this.createEventsMap()
                    this.populateEventsMap()
                })
            }
        },
        
    },

    async mounted(){
        this.fetchSensors()
        this.fetchRegions()
        this.fetchUdes()

        await this.fetchEvents()
            .then(() => {
                this.createEventsMap()
                this.populateEventsMap()
            })
    },

}
</script>