<script setup>
import {vaah} from '../../../vaahvue/pinia/vaah'
import {useCustomerStore} from '../../../stores/store-customers'

const store = useCustomerStore();
const useVaah = vaah();

</script>

<template>

    <div v-if="store.list">
        <DataTable :value="store.list.data"
                   dataKey="id"
                   class="p-datatable-sm p-datatable-hoverable-rows"
                   v-model:selection="store.action.items"
                   stripedRows
                   responsiveLayout="scroll">

            <Column selectionMode="multiple"
                    v-if="store.isViewLarge()"
                    headerStyle="width: 3em">
            </Column>

            <Column field="id" header="ID" :style="{width: store.getIdWidth()}" :sortable="true">
            </Column>

            <Column header="Name" :sortable="true">

                <template #body="prop">
                    <Avatar :image="prop.data.image_url" class="absolute bg-transparent" shape="circle" />
                    <span class="text-center ml-6">{{prop.data.name}}</span>
                    <Badge v-if="prop.data.deleted_at"
                           value="Trashed"
                           severity="danger"></Badge>
                </template>
            </Column>

            <Column field="channels" header="Channels">
                <template #body="{data}">
                    <div class="p-inputgroup">
                        <tag class="cursor-pointer px-2 mx-1 border-round hover:bg-green-300"
                             @click="store.toChannels(data.slug)"
                             :value="data.channels.length"
                             rounded/>
                        <span class="icon hover:text-indigo-600"><i
                            class="pi pi-plus-circle text-2xl text-primary mx-1
                                 cursor-pointer hover:text-green-700"
                            v-if="store.hasPermission('customerchannel-can-create-channel')"
                            @click.prevent="store.toChannelsForm(data.id)"
                        ></i></span>
                    </div>
                </template>
            </Column>

            <Column field="country" header="Country"
                    :sortable="true">
            </Column>


            <Column field="updated_at" header="Updated"
                    v-if="store.isViewLarge()"
                    style="width:150px;"
                    :sortable="true">

                <template #body="prop">
                    {{useVaah.toLocalTimeShortFormat(prop.data.updated_at)}}
                </template>

            </Column>

            <Column field="is_active" v-if="store.isViewLarge()"
                    :sortable="true"
                    style="width:100px;"
                    header="Is Active">
                <template #body="prop">
                    <InputSwitch v-model.bool="prop.data.is_active"
                                 data-testid="customers-table-is-active"
                                 v-bind:false-value="0" v-bind:true-value="1"
                                 :disabled="!store.hasPermission('customerchannel-can-update-customer')"
                                 class="p-inputswitch-sm"
                                 @input="store.toggleIsActive(prop.data)">SSS
                    </InputSwitch>
                </template>

            </Column>

            <Column field="actions" style="width:150px;"
                    :style="{width: store.getActionWidth() }"
                    :header="store.getActionLabel()">

                <template #body="prop">
                    <div class="p-inputgroup ">
                        <Button class="p-button-tiny p-button-text"
                                data-testid="customers-table-to-view"
                                :disabled="store.item && store.item.id === prop.data.id"
                                v-tooltip.top="'View'"
                                @click="store.toView(prop.data)"
                                icon="pi pi-eye"/>


                        <Button class="p-button-tiny p-button-text"
                                data-testid="customers-table-to-edit"
                                v-if="store.hasPermission('customerchannel-can-update-customer')"
                                :disabled="store.item && store.item.id === prop.data.id"
                                v-tooltip.top="'Update'"
                                @click="store.toEdit(prop.data)"
                                icon="pi pi-pencil"/>

                        <template v-if="store.hasPermission('customerchannel-can-delete-customer')">
                        <Button class="p-button-tiny p-button-danger p-button-text"
                                data-testid="customers-table-action-trash"
                                v-if="store.isViewLarge() && !prop.data.deleted_at"
                                @click="store.itemAction('trash', prop.data)"
                                v-tooltip.top="'Trash'"
                                icon="pi pi-trash"/>
                        <Button class="p-button-tiny p-button-success p-button-text"
                                data-testid="customers-table-action-restore"
                                v-if="store.isViewLarge() && prop.data.deleted_at"
                                @click="store.itemAction('restore', prop.data)"
                                v-tooltip.top="'Restore'"
                                icon="pi pi-replay"/>
                        </template>


                    </div>

                </template>


            </Column>


        </DataTable>
        <!--/table-->

        <!--paginator-->
        <Paginator v-model:rows="store.query.rows"
                   :totalRecords="store.list.total"
                   :first="(store.query.page-1)*store.query.rows"
                   @page="store.paginate($event)"
                   :rowsPerPageOptions="store.rows_per_page"
                   class="bg-white-alpha-0 pt-2">
        </Paginator>
        <!--/paginator-->

    </div>

</template>
