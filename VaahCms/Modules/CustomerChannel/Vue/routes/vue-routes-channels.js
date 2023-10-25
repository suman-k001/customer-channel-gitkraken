let routes= [];
let routes_list= [];

import List from '../pages/channels/List.vue'
import Form from '../pages/channels/Form.vue'
import Item from '../pages/channels/Item.vue'

routes_list = {

    path: '/channels',
    name: 'channels.index',
    component: List,
    props: true,
    children:[
        {
            path: 'form/:id?',
            name: 'channels.form',
            component: Form,
            props: true,
        },
        {
            path: 'view/:id?',
            name: 'channels.view',
            component: Item,
            props: true,
        }
    ]
};

routes.push(routes_list);

export default routes;

