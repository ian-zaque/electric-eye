<template>
    <div>
        <sidebar-menu
            :menu="sidebarItems"
            :theme="sidebarProps.theme"
            :width="sidebarProps.width"
            :disableHover="sidebarProps.disableHover"
            :collapsed="isSidebarOpen"
            @toggle-collapse="toggleSidebar">
            <span v-if="isSidebarOpen" slot="toggle-icon" class="fas fa-bars"></span>
            <span v-else slot="toggle-icon" class="fas fa-stream"></span>
        </sidebar-menu>

    </div>
</template>
  
<script>
export default {
    name: 'SideBar',

    components:{
    },

    data() {
        return {
            isSidebarOpen: true, sidebarProps: { theme: "default", width: "250px", disableHover: false, relative: true, },
            sidebarItems: [
                { header: true, title: "Eye of the Beholder", hiddenOnCollapse: true, },
                { href: "/", title: "Início", icon: "fa-solid fa-house", },
                { href: '/regions', title: "Regiões", icon: 'fa-solid fa-globe' },
                { href: '/zones', title: "Zonas de Interesse", icon: 'fa-solid fa-magnifying-glass-location' },  
                { href: '/udes', title: "UDEs", icon: 'fa-solid fa-tachograph-digital',
                    child: [
                        { href: '/udes', title: 'UDEs', icon: 'fa-solid fa-hard-drive', },
                        { href: '/ude-classes', title: 'Classes de UDEs', icon: 'fa-regular fa-hard-drive', }
                    ], 
                },
                { href: "/emergency", title: "Emergências", icon: "fa-solid fa-cloud-bolt",
                    // child:[
                    //     { href: '/emergency', title: 'Emergências', icon: 'fa-solid fa-cloud-bolt', },
                    //     { href: '/emergency-parameters', title: 'Parâmetros', icon: 'fa-solid fa-toolbox', }
                    // ]
                },
                { href: "/sensors", title: "Dispositivos", icon: "fa-solid fa-satellite",
                    child:[
                        { href: '/sensors', title: 'Sensores', icon: 'fa-solid fa-satellite-dish', },
                        { href: '/sensors-types', title: 'Tipos de Sensores', icon: 'fa-solid fa-microchip', }
                    ]
                },
                { href: '/mqtt', title: "MQTT", icon: 'fa-solid fa-tower-broadcast' },
                { href: '/eventos', title: "Eventos", icon: 'fa-solid fa-map-location-dot' },
                // { href: '/configuration', title: "Configurações", icon: 'fa-solid fa-gears' },
            ],
        };
    },

    methods: {
        toggleSidebar() { this.isSidebarOpen = !this.isSidebarOpen; },
    },
};
</script>
  
<style scoped>
.sidebar {
    height: 100%;
    width: 240px;
    background-color: #9BB5B4;
    color: #fff;
    padding: 20px;
    transition: transform 0.3s ease;
    transform: translateX(0);
    border-right-color: #fff;
}

.sidebar-nav .nav-link {
    color: #ffffff;
    padding: 10px;
}

.sidebar-toggle {
    position: absolute;
    top: 20px;
    right: -30px;
    width: 30px;
    height: 30px;
    background-color: #9BB5B4;
    color: #fff;
    border-radius: 50%;
    border-color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
}

.sidebar-toggle:hover {
    background-color: #1db954;
    color: #fff;
}

.sidebar-toggle i {
    font-size: 20px;
}

@media (max-width: 767px) {
    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        bottom: 0;
        width: 240px;
        transform: translateX(-240px);
        z-index: 999;
        transition: transform 0.3s ease;
    }

    .sidebar-open {
        transform: translateX(0);
    }

    .sidebar-toggle {
        right: -20px;
    }
}
</style>