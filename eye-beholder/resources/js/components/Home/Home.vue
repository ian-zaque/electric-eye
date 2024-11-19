<template>
    <div>
      <b-row>
        <b-col>
          <h2>Seja bem-vindo(a)!</h2>
          <hr>
        </b-col>
      </b-row>

      <b-container fluid class="pt-4">
        <!-- PRIMEIRA LINHA -->
        <b-row>
          <b-col xs="12" sm="12" md="4" lg="4">
            <router-link to="/reports" class="text-gray">
              <b-card class="subcard-p-3">
                <p class="text-gray mb-0 text-center h1">
                  <i class="fa-solid fa-chart-line"></i>
                </p>
                <h4 class="card-title mb-0 text-center">Relatórios</h4>
              </b-card>
            </router-link>
          </b-col>

          <b-col xs="12" sm="12" md="4" lg="4">
            <router-link to="/events" class="text-gray">
              <b-card class="subcard-p-3">
                <p class="text-gray mb-0 text-center h1">
                  <i class="fa-solid fa-triangle-exclamation"></i>
                </p>
                <h4 class="card-title mb-0 text-center">Eventos</h4>
              </b-card>
            </router-link>
          </b-col>

          <b-col xs="12" sm="12" md="4" lg="4">
            <router-link to="/regions" class="text-gray">
              <b-card class="subcard-p-3">
                <p class="text-gray mb-0 text-center h1">
                  <i class="fa-solid fa-globe"></i>
                </p>
                <h4 class="card-title mb-0 text-center">Regiões</h4>
              </b-card>
            </router-link>
          </b-col>
        </b-row>

        <!-- SEGUNDA LINHA -->
        <b-row class="pt-4">
          <b-col xs="12" sm="12" md="4" lg="4">
            <router-link to="/sensors" class="text-gray">
              <b-card class="subcard-p-3">
                <p class="text-gray mb-0 text-center h1">
                  <i class="fa-solid fa-hard-drive"></i>
                </p>
                <h4 class="card-title mb-0 text-center">UDEs</h4>
              </b-card>
            </router-link>
          </b-col>

          <b-col xs="12" sm="12" md="4" lg="4">
            <router-link to="/sensors" class="text-gray">
              <b-card class="subcard-p-3">
                <p class="text-gray mb-0 text-center h1">
                  <i class="fa-solid fa-satellite-dish"></i>
                </p>
                <h4 class="card-title mb-0 text-center">Sensores</h4>
              </b-card>
            </router-link>
          </b-col>

          <b-col xs="12" sm="12" md="4" lg="4">
            <router-link to="/sensors" class="text-gray">
              <b-card class="subcard-p-3">
                <p class="text-gray mb-0 text-center h1">
                  <i class="fa-solid fa-cloud-bolt"></i>
                </p>
                <h4 class="card-title mb-0 text-center">Emergências</h4>
              </b-card>
            </router-link>
          </b-col>
        </b-row>
      </b-container>
    </div>
  </template>
  
  <script>  
  export default {
    name: 'Home',
  
    components: {
      // HelloWorld
    },
  
  }
  </script>
  