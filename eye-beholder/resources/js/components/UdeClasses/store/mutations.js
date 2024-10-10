const SET_CURRENT_UDE_CLASS = (state, payload) => { state.udeClass = payload }
const RESET_CURRENT_UDE_CLASS = (state) => { 
    state.udeClass = {
        name: "",
        fullname: "",
    } 
}

const SET_UDE_CLASSES_LIST = (state, payload) => { state.udeClassesList = payload }
const ADD_UDE_CLASSES_LIST = (state, payload) => { state.udeClassesList.push(payload) }
const UPDATE_UDE_CLASSES_LIST = (state, payload) => {
    const index = state.udeClassesList.findIndex(r => r.id === payload.id);
    if (index !== -1) {
        state.udeClassesList.splice(index, 1, payload);
    }
}
const RESET_UDE_CLASSES_LIST = (state) => { state.udeClassesList = [] }

const SET_ERRORS_UDE_CLASSES = (state, payload) => { state.errorsUdeClasses = payload }
const RESET_ERRORS_UDE_CLASSES = (state) => { 
    state.errorsUdeClasses = {}
}

export default {
    SET_CURRENT_UDE_CLASS,
    RESET_CURRENT_UDE_CLASS,

    SET_UDE_CLASSES_LIST,
    ADD_UDE_CLASSES_LIST,
    UPDATE_UDE_CLASSES_LIST,
    RESET_UDE_CLASSES_LIST,

    SET_ERRORS_UDE_CLASSES,
    RESET_ERRORS_UDE_CLASSES,
}