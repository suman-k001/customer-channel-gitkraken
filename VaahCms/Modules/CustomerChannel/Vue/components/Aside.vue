<script setup>
import {reactive, ref} from 'vue';

import Menu from 'primevue/menu';

const inputs = {
}
const data = reactive(inputs);
const height = ref(window.innerHeight)

const menu = ref();

const items = ref([
    {
        label: 'CustomerChannel',
        items: [
            {
                label: 'Users',
                icon: 'fa-regular fa-user',
                to: "/users"
            },
            {
                label: 'products',
                icon: 'fa-brands fa-product-hunt',
                to: "/products"
            },
            {
                label: 'Dashboard',
                icon: 'fa-regular fa-chart-bar',
                to: "/"
            },
            {
                label: 'Customers',
                icon: 'fa-regular fa-user',
                to: "/customers"
            },
            {
                label: 'Channels',
                icon: 'fa-brands fa-youtube',
                to: "/channels"
            },
        ]
    },
]);

</script>
<template>

    <div v-if="height">
        <Menu :model="items"  class="w-full" />
    </div>

</template>


