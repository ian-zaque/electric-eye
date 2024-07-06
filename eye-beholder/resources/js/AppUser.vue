<template>
    <div id="app">
      <side-bar />
  
      <div class="ml-5">
        <flash-notification></flash-notification>

        <router-view></router-view>
      </div>
  </div>
  </template>
  
  <script>
  
  export default {
    name: 'App',
  
    components: {
    },
  
    methods: {
    },
  
  };
  </script>
  
  <style>
  #app {
    text-align: left;
  }
  </style>