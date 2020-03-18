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
        component: require('./components/Profile').default
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
        path: '*',
        component: require('./components/NotFound').default
    }
];