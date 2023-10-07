import Dashboard from './components/Dashboard.vue';
import ListAppointments from './pages/appointments/index.vue';
import CreateAppointments from './pages/appointments/create.vue';
import EditAppointments from './pages/appointments/edit.vue';
import ListUsers from './pages/users/index.vue';
import ListSettings from './pages/settings/index.vue';
import ListProfiles from './pages/profiles/index.vue';
import Login from './pages/auth/Login.vue';


export default [
    {
        path: '/admin/login',
        name: 'admin.login',
        component: Login,
    },
    { 
        path: '/admin/dashboard',
        name: 'admin.dashboard',
        component: Dashboard,
    },

    {
        path: '/admin/appointments',
        name: 'admin.appointments',
        component: ListAppointments,
    },
    {
        path: '/admin/appointments/create',
        name: 'admin.appointments.create',
        component: CreateAppointments,
    },
    {
        path: '/admin/appointments/:id/edit',
        name: 'admin.appointments.edit',
        component: EditAppointments,
    },
    {
        path: '/admin/users',
        name: 'admin.users',
        component: ListUsers,
    },
    {
        path: '/admin/settings',
        name : 'admin.settings',
        component : ListSettings,
    },
    {
        path: '/admin/profiles',
        name : 'admin.profiles',
        component : ListProfiles,
    },
    
]