<template>
    <div class="messages-list">
        <notification v-for="notification in notifications" :key="notification.id" :notification="notification" />
    </div>
</template>

<script>
import { mapGetters } from "vuex";

export default {
    name: "FlashNotification",

    computed: {
        ...mapGetters('notifications', { 
            notifications: "getNotifications" 
        }),
    },
};
</script>

<style>
/* Posionamento Superior central */
.messages-list {
    position: fixed;
    z-index: 999;
    top: 38px;
    right: 40px;
    width: 40%;
}
</style>