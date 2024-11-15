const getCurrentEvent = (state) =>{ return state.event }

const getEventsList = (state) =>{ return state.eventsList }

const getErrorsEvents = (state) =>{ return state.errorsEvents }

export default {
    getCurrentEvent,
    getEventsList,
    getErrorsEvents,
}