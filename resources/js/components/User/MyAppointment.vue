<template>
    <div>
        <div class="section">

            <div class="columns">
                <div class="column is-8 is-offset-2">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">MY APPOINTMENT</div>

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
                                        <b-datepicker
                                            editable
                                                 v-model="search.appointment_date" placeholder="Search Appointment Date"
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

                            <b-table-column field="appointment_type_id" label="ID" v-slot="props">
                                {{ props.row.appointment_id }}
                            </b-table-column>

                            <b-table-column field="ref_no" label="Reference" v-slot="props">
                                {{ props.row.ref_no }}
                            </b-table-column>

                            <b-table-column field="training_center" label="Training Center" v-slot="props">
                                {{ props.row.training_center.training_center }}
                            </b-table-column>


                            <b-table-column field="app_date" label="Appointment Date" v-slot="props">
                                {{ props.row.app_date }}
                            </b-table-column>

                            <b-table-column field="app_time" label="Time" v-slot="props">
                                {{ props.row.app_time_from | formatTime }} - {{ props.row.app_time_to | formatTime }}
                            </b-table-column>

                            <b-table-column field="remarks" label="Remarks" v-slot="props">
                                {{ props.row.remarks }}
                            </b-table-column>

                            <b-table-column field="is_approved" label="Is Approved" v-slot="props">
                                <span style="font-weight: bold; color: green;" v-if="props.row.app_status === 1">APPROVED</span>
                                <span style="font-weight: bold; color: red;" v-else-if="props.row.app_status === 2">CANCELLED</span>
                                <span style="font-weight: bold; color: blue;" v-else>PENDING</span>
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">


                                    <b-tooltip label="Cancel appointment" type="is-danger">
                                        <b-button class="button is-small is-danger mr-1" icon-right="minus-circle" @click="cancelAppointment(props.row)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column>

                        </b-table>

                    </div>
                </div><!--close column-->
            </div>

        </div><!--section div-->

    </div>
</template>

<script>
export default {
    name: "AppointmentType",
    data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'appointment_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',

            search: {
                appointment_type: '',
                appointment_date: new Date(),
            },


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


            if(this.search.appointment_date){
                this.search.ndate = new Date(this.search.appointment_date).toLocaleDateString();
            }else{
                this.search.ndate = '';
            }

            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `appdate=${this.search.ndate}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-my-appointments?${params}`)
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


        //alert box ask for deletion
        cancelAppointment(row) {
            this.$buefy.dialog.confirm({
                title: 'CANCEL?',
                type: 'is-danger',
                message: 'Are you sure you want to cancel this data?',
                cancelText: 'Close',
                confirmText: 'Cancel',
                onConfirm: () => this.cancelSubmit(row.appointment_id)
            });
        },
        //execute delete after confirming
        cancelSubmit(dataId) {
            axios.post('/cancel-my-appointment/' + dataId).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


    },

    mounted() {
        this.search.appointment_date = null;
        this.loadAsyncData();
    }

}
</script>

<style scoped>

</style>
