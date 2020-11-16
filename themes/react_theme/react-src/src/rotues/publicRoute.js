import Home from "../pages/Home";
import About from "../pages/About";
import Studios from "../pages/Studios";

const publicRoute = [
    {
        path: '/',
        component: Home,
        exact: true,
    },
    {
        path: '/about',
        component: About,
        exact: true,
    },
    {
        path: '/studios',
        component: Studios,
        exact: true,
    },
]
export default publicRoute;
