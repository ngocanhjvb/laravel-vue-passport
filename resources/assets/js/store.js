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
        hasInvitation(state, companies) {
            state.currentCompany = null;
            state.invitations = companies;
        },
        acceptCompany(state, company) {
            state.invitations = null;
            state.currentCompany = company;
        },
        refuseCompany(state, companies) {
            state.currentCompany = null;
            state.invitations = companies;
        },
        layoff(state) {
            state.invitations = null;
            state.currentCompany = null;
        },
    },
    actions: {}
};
