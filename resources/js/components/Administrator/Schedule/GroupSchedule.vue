<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-10-desktop is-10-tablet">
                    <div class="box">

                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">LIST OF GROUP SCHEDULES</div>

                        <div class="level">
                            <div class="level-left">
                                <b-field label="Page">
                                    <b-select v-model="perPage" @input="setPerPage">
                                        <option value="5">5 per page</option>
                                        <option value="10">10 per page</option>
                                        <option value="15">15 per page</option>
                                        <option value="20">20 per page</option>
                                    </b-select>
                                    <b-select v-model="sortOrder" @input="loadAsyncData">
                                        <option value="asc">ASC</option>
                                        <option value="desc">DESC</option>
                                    </b-select>
                                </b-field>
                            </div>

                            <div class="level-right">
                                <div class="level-item">
                                    <b-field label="Search">
                                        <b-input type="text"
                                                 v-model="search.app_date" placeholder="Search"
                                                 @keyup.native.enter="loadAsyncData"/>
                                        <p class="control">
                                            <b-tooltip label="Search" type="is-success">
                                                <b-button type="is-primary" icon-right="account-filter" @click="loadAsyncData"/>
                                            </b-tooltip>
                                        </p>
                                    </b-field>
                                </div>
                            </div>
                        </div>

                        <b-table
                            :data="data"
                            :loading="loading"
                            paginated
                            detailed
                            backend-pagination
                            :total="total"
                            :per-page="perPage"
                            @page-change="onPageChange"
                            aria-next-label="Next page"
                            aria-previous-label="Previous page"
                            aria-page-label="Page"
                            aria-current-label="Current page"
                            backend-sorting
                            :default-sort-direction="defaultSortDirection"
                            @sort="onSort">

                            <b-table-column field="group_schedule_id" label="ID" v-slot="props">
                                {{ props.row.group_schedule_id }}
                            </b-table-column>

                            <b-table-column field="schedule_name" label="Schedule Name" v-slot="props">
                                {{ props.row.schedule_name }}
                            </b-table-column>

                            <b-table-column field="date_time" label="Date and Time" v-slot="props">
                                <span v-if="props.row.date_time">{{ props.row.date_time.toLocaleString() }}</span>
                            </b-table-column>

                            <b-table-column field="schedule_on" label="Schedule On" v-slot="props">
                                <span v-if="props.row.schedule_on">{{ props.row.schedule_on | formatTime }}</span>
                            </b-table-column>

                            <b-table-column field="schedule_off" label="Schedule Off" v-slot="props">
                                <span v-if="props.row.schedule_off">{{ props.row.schedule_off | formatTime }}</span>
                            </b-table-column>

                            <b-table-column field="system_action" label="System Action" v-slot="props">
                                <span v-if="props.row.system_action === 'ON'" class="light-on">ON</span>
                                <span v-else-if="props.row.system_action === 'OFF'" class="light-off">OFF</span>
                                <span v-else></span>
                            </b-table-column>

                            <b-table-column field="user_interact" label="User Interact" v-slot="props">
                                {{ props.row.ntuser }}
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small is-warning mr-1" icon-right="pencil" tag="a" :href="`/group-schedules/${props.row.group_schedule_id}/edit`"></b-button>
                                    </b-tooltip>

                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small is-danger mr-1" icon-right="delete" @click="confirmDelete(props.row.group_schedule_id)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column>


                            <template slot="detail" slot-scope="props">
                                <th>
                                    Device
                                </th>
                                <th>
                                    IP Address
                                </th>

                                <tr v-for="(item, index) in props.row.group_schedule_devices" :key="index">
                                    <td>{{ item.device.device_name }}</td>
                                    <td>{{ item.device.device_ip }}</td>

                                </tr>
                            </template>


                        </b-table>

                        <div class="buttons mt-3">
                            <b-button tag="a" href="/group-schedules/create" icon-right="account-arrow-up-outline" class="is-success">NEW</b-button>
                        </div>

                    </div><!--box -->
                </div><!--col-->
            </div><!--cols-->


        </div><!--section div-->
    </div> <!--root div-->

</template>

<script>
export default {

     data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'group_schedule_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',

            locale: undefined, // Browser locale

            global_id : 0,

            search: {
                from_date: '',
                to_date: '',

            },

            isModalCreate: false,

            fields: {},
            errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },
        }
    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `type=${this.search.appointment_type}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-group-schedules?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
                    })
                    this.loading = false
                    console.log(this.data)
                })
                .catch((error) => {
                    this.data = []
                    this.total = 0
                    this.loading = false
                    throw error
                })
        },
        /*
        * Handle page-change event
        */
        onPageChange(page) {
            this.page = page
            this.loadAsyncData()
        },

        onSort(field, order) {
            this.sortField = field
            this.sortOrder = order
            this.loadAsyncData()
        },

        setPerPage(){
            this.loadAsyncData()
        },


        clearFields(){
            this.fields = {
                appointment_date: null,
                nAppointmentDate: '',
                appointment_type: '',
            };
            this.errors = {};
        },


        //alert box ask for deletion
        confirmDelete(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmit(delete_id) {
            axios.delete('/group-schedules/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        //update code here
        getData: function(data_id){
            this.clearFields();
            this.global_id = data_id;
            this.isModalCreate = true;


            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/group-schedules/' + data_id).then(res=>{
                // this.fields.training_center = res.data.training_center_id;
                // let dateNTime = res.data.app_date + ' ' + res.data.app_time;
                // this.fields.appointment_date = new Date(dateNTime);
                // this.fields.remarks = res.data.remarks;
            });
        },


    },

    mounted() {
        this.loadAsyncData();
    }

}
</script>

<style scoped>
    .light-on{
        font-weight: bold;
        color: green;
    }
    .light-off{
        font-weight: bold;
        color: red;
    }

    .pending{
        font-weight: bold;
        color: #1a73bd;
    }

</style>
