import Welcome from './components/Welcome'
import PageNotFound from "./components/PageNotFound";
import Login from "./components/Login";
import Signup from "./components/Signup";

const routes = [
    {path: '/', name: 'welcome', component: Welcome, meta: {requiresAuth: false}},
    {path: '/login', name: 'login', component: Login},
    {path: '/signup', name: 'signup', component: Signup},
    {path: "*", component: PageNotFound}
];

export default routes
