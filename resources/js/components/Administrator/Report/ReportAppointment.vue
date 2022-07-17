<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-10">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">REPORT APPOINTMENT</div>

                        <div class="level">
                            <div class="level-left">
                                <b-field label="From-To">
                                    <b-datepicker v-model="search.from"></b-datepicker>
                                    <b-datepicker v-model="search.to"></b-datepicker>
                                    <p class="control">
                                        <b-button label="..." type="is-info" @click="loadAsyncData"></b-button>
                                    </p>
                                </b-field>
                            </div>

                            <div class="level-right">
                                <div class="level-item">

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

                            <b-table-column field="appointment_id" label="ID" v-slot="props">
                                {{ props.row.appointment_id }}
                            </b-table-column>

                            <b-table-column field="patient_name" label="Patient Name" v-slot="props">
                                {{ props.row.user_lname }}, {{ props.row.user_fname }} {{ props.row.user_mname }}
                            </b-table-column>

                            <b-table-column field="appoint_date" label="Apointment" v-slot="props">
                                {{ props.row.appoint_date }} - {{ props.row.appoint_time | formatTime }}
                            </b-table-column>

                            <b-table-column field="dentist_name" label="Dentist Name" v-slot="props">
                                {{ props.row.dentist_lname }}, {{ props.row.dentist_fname }} {{ props.row.dentist_mname }}
                            </b-table-column>

                            <b-table-column field="appoint_status" centered label="Status" v-slot="props">
                                <span class="pending" v-if="props.row.appoint_status === 0">PENDING</span>
                                <span class="approve" v-else-if="props.row.appoint_status === 1">ADMITTED</span>
                                <span class="cancel" v-else>CANCELLED</span>
                            </b-table-column>

                        </b-table>

                        <div class="buttons mt-3">
                            <b-button icon-right="printer" @click="printMe" class="is-info is-outlined">PRINT PREVIEW</b-button>
                        </div>

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


            global_id : 0,

            search: {
                from: new Date(),
                to: new Date(),
                itemname: '',
                nFrom: '',
                nTo: '',
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
            this.search.nFrom = this.search.from.getFullYear() + '-' + (this.search.from.getMonth() + 1) + '-' + this.search.from.getDate();
            this.search.nTo = this.search.to.getFullYear() + '-' + (this.search.to.getMonth() + 1) + '-' + this.search.to.getDate();


            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `from=${this.search.nFrom}`,
                `to=${this.search.nTo}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/report/get-appointment?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.forEach((item) => {
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

        printMe(){
            let fromYear = this.search.from.getFullYear();
            let fromMonth = this.search.from.getMonth() + 1;
            let fromDay = this.search.from.getDate()
            fromMonth = fromMonth > 9 ? fromMonth : '0'+fromMonth;
            fromDay = fromDay > 9 ? fromDay : '0'+fromDay;
            let wFrom = fromYear + '-' + fromMonth + '-' + fromDay;


            let toYear = this.search.to.getFullYear();
            let toMonth = this.search.to.getMonth() + 1;
            let toDay = this.search.to.getDate()
            toMonth = toMonth > 9 ? toMonth : '0'+toMonth;
            toDay = toDay > 9 ? toDay : '0'+toDay;
            let wTo = toYear + '-' + toMonth + '-' + toDay;

             window.location = '/report/print-appointment?from='+wFrom+'&to='+wTo;
        }



    },

    mounted() {
        this.loadAsyncData();
    }

}
</script>

<style scoped>

</style>
