<template>
    <b-alert :variant="notification.type" :show="4" dismissible fade @dismissed="clear">
        {{ notification.message }}
    </b-alert>
</template>

<script>
import { mapActions } from "vuex";
export default {
    name: "Notification",

    props: {
        notification: {
            type: Object,
            default: {},
        },
    },

    methods: {
        ...mapActions('notifications', [ 
            "notificationStoreCommit", 
        ]),

        clear() {
            this.notificationStoreCommit({ mutation: "REMOVE_NOTIFICATION", value: this.notification })
            // this.$store.commit("REMOVE_NOTIFICATION", this.notification);
        },
    },
};
</script>
