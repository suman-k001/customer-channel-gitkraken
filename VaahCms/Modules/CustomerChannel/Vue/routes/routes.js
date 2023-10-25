let routes= [];

import dashboard from "./vue-routes-dashboard";
import customer from "./vue-routes-channels";
import channel from "./vue-routes-customers";
import users from "./vue-routes-users";
import products from "./vue-routes-products"

routes= routes.concat(products);
routes = routes.concat(users);
routes = routes.concat(dashboard);
routes = routes.concat(customer);
routes = routes.concat(channel);

export default routes;
