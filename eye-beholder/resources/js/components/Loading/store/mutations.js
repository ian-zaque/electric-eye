const INCREMENT_LOAD_COUNT = (state) => { state.loadCount++ }
const DECREMENT_LOAD_COUNT = (state) => { state.loadCount-- }
const RESET_LOAD_COUNT = (state) => { state.loadCount = 0 }

export default {
    INCREMENT_LOAD_COUNT,
    DECREMENT_LOAD_COUNT,
    RESET_LOAD_COUNT,
}