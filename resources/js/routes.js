
const Home = () => import('./components/Home.vue');
const Login = () => import('./components/Login.vue');
const RecoverPassword = () => import('./components/RecoverPassword.vue');
const ResetPassword = () => import('./components/ResetPassword.vue');
const Register = () => import('./components/Register.vue');
const Dashboard = () => import('./components/Dashboard.vue');
const Layout = () => import('./components/Layout.vue');
const NotFound = () => import('./components/NotFound.vue');
const Rol = () => import('./components/rol/Index.vue');
const Settings = () => import('./components/settings/Index.vue');
const Usuario = () => import('./components/usuario/index.vue');
const Sede = () => import('./components/sedes/index.vue');
const Perfil = () => import('./components/usuario/Perfil.vue');
const Estacionamiento = () => import('./components/estacionamiento/Index.vue');
const Programacion = () => import('./components/programacion/Index.vue');

export default{
    mode: 'history',
    routes: [
        {
            path: '*',
            component: NotFound
        },
        {
            path: '/',
            component: Home,
            name: "Home"
        },
        {
            path: '/register',
            component: Register
        },
        {
            path: '/login',
            component: Login,
            name: 'Login'
        },
        {
            path: '/recover-password',
            component: RecoverPassword,
            name: 'RecoverPassword'
        },
        {
            path: '/reset-password',
            component: ResetPassword,
            name: 'ResetPassword'
        },
        {
            path: '/layout',
            component: Layout,
            name: 'Layout',
            beforeEnter: (to, form, next) => {
                const token = localStorage.getItem('access_token');
                if (token) {
                    axios.get('api/getSession/'+ token).then((res)=>{
                        next()
                    }).catch((error) => {
                        return next({ name: 'Login'})
                    })
                } else { 
                    return next({ name: 'Login'})
                }
               
            },
            children: [
               {
                    path: "/dashboard",
                    name: "dashboard",
                    component: Dashboard,
                },
                {
                    path: '/usuarios',
                    component: Usuario,
                    name: 'usuario'
                },
                {
                    path: '/sedes',
                    component: Sede,
                    name: 'sedes'
                },
                {
                    path: '/estacionamiento',
                    component: Estacionamiento,
                    name: 'estacionamiento'
                },
                {
                    path: '/programacion',
                    component: Programacion,
                    name: 'programacion'
                },
                {
                    path: '/rol',
                    component: Rol,
                    name: 'rol'
                },
                {
                    path: '/perfil',
                    component: Perfil,
                    name: 'perfil'
                },
                {
                    path: '/settings',
                    component: Settings,
                    name: 'settings'
                },
            ],
        },
    ]
}
