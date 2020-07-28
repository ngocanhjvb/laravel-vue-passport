import InvitationSmall from "./components/InvitationSmall";

export const routes = [
    {
        path: '/company/:id',
        component: require('./components/DetailCompany').default,
    },
    {
        path: '/dashboard',
        component: require('./components/DashBoard').default,
    },
    {
        path: '/profile',
        component: require('./components/Profile').default,
        children: [
            { path: 'small', component: InvitationSmall },
        ]
    },
    {
        path: '/users',
        component: require('./components/User').default,
        name: 'users',
    },
    {
        path: '/jobs',
        component: require('./components/Job').default,
        name: 'jobs',
    },
    {
        path: '/companies',
        component: require('./components/Company').default,
        name: 'companies',
    },
    {
        path: '/developer',
        component: require('./components/Developer').default
    },
    {
        path: '/chat',
        component: require('./components/chat_components/ChatLayout').default
    },
    {
        path: '*',
        component: require('./components/NotFound').default
    }
];
