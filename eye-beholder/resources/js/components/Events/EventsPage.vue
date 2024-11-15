<template>
    <div>
        <b-row align-h="between" class="container mt--3">
            <b-col cols="10">
                <h3>Eventos</h3>
            </b-col>
        </b-row>

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
import * as Leaflet from 'leaflet';
import markerIcon from "leaflet/dist/images/marker-icon.png";
import "leaflet/dist/leaflet.css"
import 'leaflet.markercluster/dist/MarkerCluster.css';
import 'leaflet.markercluster/dist/MarkerCluster.Default.css';
import "leaflet.markercluster";

export default {
    name: 'EventsPage',

    components:{
    },

    props:{
    },

    computed: {
      ...mapGetters('events', { 
           eventsList: "getEventsList",
           errors: "getErrorsEvents",
        }),

        ...mapGetters('loading', {
            isLoading: "isLoading",
        }),
    },

    watch: {
    },

    data() {
        return {
            eventsMap: null
        }
    },

    methods: {
      ...mapActions('events', [
            'fetchEvents',
            "eventsStoreCommit",
        ]),

        populateEventsMap(){
            if(this.eventsList && this.eventsList.length > 0){
                const markers = Leaflet.markerClusterGroup();
                this.eventsList.map(function(value, index){
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
        
    },

    async mounted(){
        await this.fetchEvents()
        .then(() => {
            this.createEventsMap()
            this.populateEventsMap()
        })
    },

}
</script>