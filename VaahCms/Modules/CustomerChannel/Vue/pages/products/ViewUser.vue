<script setup>
import {onMounted, ref} from "vue";
import {useRoute} from 'vue-router';

import {useProductStore} from '../../stores/store-products';
import {vaah} from '../../vaahvue/pinia/vaah';

const store = useProductStore();
const route = useRoute();
const useVaah = vaah();

onMounted(async () => {

    /**
     * If record id is not set in url then
     * redirect user to list view
     */
    if (route.params && !route.params.id) {
        store.toList();
        return false;
    }

    /**
     * Fetch the record from the database
     */
    if (route.params && route.params.id) {
        await store.getItem(route.params.id);
    }

    /**
     * Fetch item users from the database
     */
    if (store.item && !store.product_users) {
        await store.getItemUsers();
    }

    /**
     * Fetch user menu item from store
     */
    await store.getProductUserMenuItems();
});

//--------toggle item menu--------//
const user_items_menu = ref();

const toggleItemMenu = (event) => {
    user_items_menu.value.toggle(event);
};
</script>

<template>
    <div class="col-6">
        <Panel v-if="store && store.item" class="is-small">
            <template class="p-1" #header>
                <div class="flex flex-row">

                    <div class="font-semibold text-sm">
                        {{ store.item.name }}
                    </div>
                </div>
            </template>

            <template #icons>
                <div class="p-inputgroup">

                    <Button class="p-button-sm"
                            :label=" '#' + store.item.id"
                            @click="useVaah.copy(store.item.id)"
                            data-testid="role-user_id"
                    />

                    <!--/item_menu-->
                        <Button class="p-button-sm"
                                icon="pi pi-angle-down"
                                aria-haspopup="true"
                                @click="toggleItemMenu"
                                data-testid="users_product_menu"
                        />

                        <Menu ref="user_items_menu"
                              :model="store.product_user_menu_items"
                              :popup="true"
                        />

                    <!--/item_menu-->

                    <Button class="p-button-sm"
                            icon="pi pi-times"
                            data-testid="product-user_list"
                            @click="store.toList()"
                    />
                </div>
            </template>

            <div class="grid p-fluid mt-1 mb-2">
                <div class="col-12">
                    <div class="p-inputgroup">
                         <span class="p-input-icon-left">
                            <i class="pi pi-search"/>
                            <InputText v-model="store.product_users_query.q"
                                       @keyup.enter="store.delayedProductUsersSearch()"
                                       @keyup.enter.native="store.delayedProductUsersSearch()"
                                       @keyup.13="store.delayedProductUsersSearch()"
                                       placeholder="Search"
                                       type="text"
                                       data-testid="product-user_search"
                                       class="w-full p-inputtext-sm"
                            />
                         </span>

                        <Button class="p-button-sm"
                                data-testid="product_user_search_reset"
                                label="Reset"
                                @click="store.resetProductUserFilters()"
                        />
                    </div>
                </div>
            </div>


            <DataTable v-if="store && store.product_users"
                       :value="store.product_users.list.data"
                       dataKey="id"
                       class="p-datatable-sm"
                       stripedRows
                       responsiveLayout="scroll"
            >
                <Column field="name"
                        header="Name"
                >
                    <template #body="prop">
                        {{ prop.data.name }}
                    </template>
                </Column>

                <Column field="email"
                        header="Email"
                >
                    <template #body="prop">
                        {{ prop.data.email }}
                    </template>
                </Column>

                <Column field="" header="Has Product">
                    <template #body="prop">
                        <Button label="Yes"
                                class="p-button-sm p-button-success p-button-rounded"
                                v-if="prop.data.pivot.is_active === 1"
                                @click="store.changeUserProduct(prop.data)"
                                data-testid="role-user_status_yes"
                        />

                        <Button label="No"
                                class="p-button-sm p-button-danger p-button-rounded"
                                data-testid="role-user_status_no"
                                v-else
                                @click="store.changeUserProduct(prop.data)"
                        />
                    </template>
                </Column>

                <Column>
                    <template #body="prop">
<!--                        <Button class="p-button-sm p-button-rounded p-button-outlined"-->
<!--                                @click="openDetailsViewModal(), store.active_product_user = prop.data"-->
<!--                                icon="pi pi-eye"-->
<!--                                label="View"-->
<!--                                data-testid="role-user_view_details"-->
<!--                        />-->
                        <Button class="p-button-sm p-button-rounded p-button-outlined"
                                v-tooltip.top="'View'"
                                @click="store.showModal(prop.data)"
                                data-testid="users-role_details_view"
                                icon="pi pi-eye"
                                label="View"
                        />
                    </template>
                </Column>
            </DataTable>
            <!--paginator-->
            <Paginator v-if="store && store.product_users"
                       v-model:rows="store.product_users_query.rows"
                       :totalRecords="store.product_users.list.total"
                       @page="store.userPaginate($event)"
                       :rowsPerPageOptions="store.rows_per_page"
                       class="bg-white-alpha-0 pt-2"
            />
            <!--/paginator-->
        </Panel>

        <Dialog header="Details"
                v-model:visible="store.displayModal"
                :breakpoints="{'960px': '75vw', '640px': '90vw'}" :style="{width: '50vw'}"
                :modal="true"
        >
            <div v-for="(item,index) in store.modalData" :key="index">
                <span> {{ index }} </span> : {{ item }}
                {{}}

                <Divider />
            </div>
        </Dialog>
    </div>
</template>
