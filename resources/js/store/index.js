import { createStore } from "vuex";

import defaultStore from "@/store//defaultStore";

const store = createStore({
    modules:{
        default: defaultStore
    }
})

export default store;
