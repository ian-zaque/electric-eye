const SET_NOTIFICATION = (state, notifications) => {
    state.notifications = notifications;
}

const PUSH_NOTIFICATION = (state, notification) => {
    state.notifications.push({
        message: notification.message,
        type: notification.type,
        id: (Math.random().toString(36) + Date.now().toString(36)).substr(2)
    })
}

const POP_NOTIFICATION = (state) => {
    return state.notifications.pop();
}

const RESET_NOTIFICATIONS = (state) => {
    state.notifications = [];
}

const REMOVE_NOTIFICATION = (state, payload) => {
    const index = state.notifications.findIndex((notification) => {
        return notification.message === payload.message;
    });

    if (index != -1) {
        state.notifications.splice(index, 1);
    } else {
        console.log('Messagem não encontrada')
    }
}

// O PADRÃO PARA DESPACHAR NO MÓDULO É:
// state.dispatch("dispatchNotification", { mutation: "PUSH_NOTIFICATION", payload: { message: `${message}`, type: "${type}" }}, {root:true}) 

export default {
    SET_NOTIFICATION,
    PUSH_NOTIFICATION,
    POP_NOTIFICATION,
    RESET_NOTIFICATIONS,
    REMOVE_NOTIFICATION,
}