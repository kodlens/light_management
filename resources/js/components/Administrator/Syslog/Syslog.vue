<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-10">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">SYSTEM LOGS</div>

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
                                                v-model="search.activity" placeholder="Search Appointment"
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

                                <b-table-column field="id" label="ID" v-slot="props">
                                    {{ props.row.id }}
                                </b-table-column>

                                <b-table-column field="syslog" label="Log Activity" v-slot="props">
                                    {{ props.row.syslog }}
                                </b-table-column>

                                <b-table-column field="action_type" label="Action Type" v-slot="props">
                                    {{ props.row.action_type }}
                                </b-table-column>

                                <b-table-column field="username" label="Username" v-slot="props">
                                    {{ props.row.username }}
                                </b-table-column>

                                <b-table-column field="created_at" label="Date created" v-slot="props">
                                    {{ new Date(props.row.created_at).toLocaleDateString() + ' ' +  new Date(props.row.created_at).toLocaleTimeString() }}
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

    data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',

            locale: undefined, // Browser locale

            global_id : 0,

            search: {
                activity: '',
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
                `activity=${this.search.activity}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-syslogs?${params}`)
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
            axios.delete('/schedules/' + delete_id).then(res => {
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
            axios.get('/schedules/' + data_id).then(res=>{
                this.fields.training_center = res.data.training_center_id;
                let dateNTime = res.data.app_date + ' ' + res.data.app_time;
                this.fields.appointment_date = new Date(dateNTime);
                this.fields.remarks = res.data.remarks;

            });
        },

 

        loadTrainingCenter(){
            axios.get('/get-open-training-centers').then(res=>{
                this.trainingCenters = res.data;
            })
        },

    },

    mounted() {
        this.loadAsyncData();
    }

}
</script>

<style scoped>
    .approved{
        font-weight: bold;
        color: green;
    }
    .cancelled{
        font-weight: bold;
        color: red;
    }

    .pending{
        font-weight: bold;
        color: #1a73bd;
    }
</style>
