import {vueLarApi} from "./helpers";

export default {
    state: {
        currentCompany: null,
        invitations: null
    },
    getters: {
        currentCompany(state) {
            return state.currentCompany;
        },
        invitations(state) {
            return state.invitations;
        }
    },
    mutations: {
        checkInvitation(state, company) {
            state.invitations = company;
        },
        checkCurrentCompany(state, company) {
            state.currentCompany = company;
        },
        enterCompany(state, company) {
            state.invitations = company;
            state.currentCompany = null;
        },
        layOff(state) {
            state.invitations = null;
            state.currentCompany = null;
        },
        retract(state) {
            state.invitations = null;
            state.currentCompany = null;
        }
    },
    actions: {
        checkInvitation(context) {
            vueLarApi('api/check-invitation')
                .then((res) => {
                    context.commit('checkInvitation', res);
                })
                .catch((error) => {

                });
        },
        getMessages() {
            var start_time = new Date().getTime();
            const a = axios.get('api/messages')
                .then(res => {
                    var request_time = new Date().getTime() - start_time;
                    return res
                })
            return a
        }
    }
};
