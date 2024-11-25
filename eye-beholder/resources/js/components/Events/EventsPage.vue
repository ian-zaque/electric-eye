<template>
    <div>
        <div>
            <b-row align-v="end" align-h="between">
                <b-col>
                    <h3 class="mb-1">Eventos</h3>
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

            <b-row v-if="eventsList.length > 0">
                <b-col>
                    <h5 class="small">{{ eventsList.length + ' eventos registrados' }}</h5>
                </b-col>
            </b-row>
        </div>

        <b-card class="rounded border">
            <div v-if="!isLoading" id="map" style="height:500px;">
            </div>

            <div v-else>
                <b-skeleton-img height="500px"></b-skeleton-img>
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
    },

    watch: {
    },

    data() {
        return {
            eventsMap: null, filtro_inicio: "", filtro_final: "",
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
            var vm = this

            if(this.eventsList && this.eventsList.length > 0){
                const markers = Leaflet.markerClusterGroup();
                this.eventsList.map(function(value, index){
                    var emergency = Object.values(JSON.parse(value.event))[0]
                    var parameter = null
                    var event_type = ''
                    var each_marker = null

                    vm.sensorsList.map(function(sensor, idx){
                        sensor.emergencies.map(function(params, i){
                            params.emergency_parameters.map(function(emerg){
                                if(emerg.name == emergency.sensor){
                                    parameter = emerg
                                }
                            })
                        })
                    })

                    if(parameter.value > emergency.value){
                        each_marker = Leaflet.marker([value.ude.latitude, value.ude.longitude])
                        event_type = 'Padrão'
                    }
                    else {
                        var goldenIcon = new L.Icon({
                            iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-gold.png',
                            shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
                            iconSize: [25, 41],
                            iconAnchor: [12, 41],
                            popupAnchor: [1, -34],
                            shadowSize: [41, 41]
                        });
                        event_type = 'Anômalo'

                        each_marker = Leaflet.marker([value.ude.latitude, value.ude.longitude], { icon: goldenIcon } )
                    }

                    var popup = `<strong> Evento ${value.id} </strong> <br>
                            UDE ${value.ude.ude_class.class}: ${value.ude.name} <br>
                            Data: ${moment(value.timestamp).format("DD/MM/YYYY hh:mm:ss")} <br>
                            Tipo: ${event_type} <br>
                            <strong>${emergency.sensor}: ${emergency.value} </strong> <br>
                            Parâmetro: ${parameter.value}.`

                    each_marker.bindPopup(popup);
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
                .then(() => {
                    this.createEventsMap()
                    this.populateEventsMap()
                })
            }
        },
        
    },

    async mounted(){
        this.fetchSensors()

        await this.fetchEvents()
            .then(() => {
                this.createEventsMap()
                this.populateEventsMap()
            })
    },

}
</script>