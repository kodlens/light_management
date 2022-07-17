<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-10">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">MY PATIENTS</div>

                        <div class="level">
                            <div class="level-left">
                                <b-field label="Page">
                                    <b-select v-model="perPage" @input="setPerPage">
                                        <option value="5">5 per page</option>
                                        <option value="10">10 per page</option>
                                        <option value="15">15 per page</option>
                                        <option value="20">20 per page</option>
                                    </b-select>
                                  
                                </b-field>
                            </div>

                            <div class="level-right">
                                <div class="level-item">
                                    <b-field label="Search">
                                        <b-input type="text"
                                                 v-model="search.lname" placeholder="Search Lastname"
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

                            <b-table-column field="admit_id" label="ID" sortable v-slot="props">
                                {{ props.row.admit_id }}
                            </b-table-column>

                            <b-table-column field="patient_lname" label="Patient Name" sortable v-slot="props">
                                {{ props.row.patient_lname }}, {{ props.row.patient_fname }} {{ props.row.patient_mname }}
                            </b-table-column>

                            <b-table-column field="service" label="Service" v-slot="props">
                                {{ props.row.service }} (&#8369;{{ props.row.price}})
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">

                                <b-dropdown aria-role="list">
                                    <template #trigger="{ active }">
                                        <b-button
                                            label="Option"
                                            type="is-primary is-small"
                                            :icon-right="active ? 'menu-up' : 'menu-down'" />
                                    </template>
                                    <b-dropdown-item aria-role="listitem" tag="a" :href="`/dentist/dentist-dashboard-patients?admitid=${props.row.admit_id}`">Go</b-dropdown-item>
                                </b-dropdown>

                            </b-table-column>

                        </b-table>

<!--                        <div class="buttons mt-3">-->
<!--                            <b-button icon-right="account-arrow-up-outline" class="is-success">NEW</b-button>-->
<!--                        </div>-->

                    </div>
                </div><!--close column-->
            </div>
        </div><!--section div-->


    </div>
</template>

<script>
export default {
    // props: ['propServices'],

    name: "AppointmentType",
    data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'admit_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',


            global_id : 0,

            search: {
                lname: '',
            },

            modalBookNow: false,


            fields: {},
            errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

            services: [],

        }
    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `lname=${this.search.lname}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/dentist/get-admits-patients?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total

                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
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
            axios.delete('/dentist/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


        clearFields(){
            this.fields = {};
        },


        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/my-appointment/' + this.global_id, this.fields).then(res => {
                    if(res.data.status === 'updated'){
                        this.$buefy.toast.open({
                            message: 'Appointment saved.!',
                            type: 'is-success'
                        });

                        this.fields = {};
                        this.errors = {};
                        this.dentist_fullname = '';
                        this.modalBookNow = false;
                        this.global_id = 0;
                        this.loadAsyncData();
                    }
                    this.btnClass['is-loading'] = false;

                }).catch(err=>{
                    this.btnClass['is-loading'] = false;
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                });
            }else{
                //INSERT HERE
                this.btnClass['is-loading'] = true;
                axios.post('/my-appointment', this.fields).then(res => {
                    if(res.data.status === 'saved'){
                        this.$buefy.toast.open({
                            message: 'Appointment saved.!',
                            type: 'is-success'
                        });

                        this.fields = {};
                        this.errors = {};
                        this.global_id = 0;
                        this.dentist_fullname = '';
                        this.modalBookNow = false;

                        this.loadAsyncData();
                    }
                    this.btnClass['is-loading'] = false;
                }).catch(err=>{
                    this.btnClass['is-loading'] = false;
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                });
            }
        },





    },

    mounted() {
        //this.initData();
        this.loadAsyncData();
    }

}
</script>

<style scoped>
    .approve{
        font-weight: bold;
        color: green;
        font-size: .8em;
    }
    .cancel{
        font-weight: bold;
        color: red;
        font-size: .8em;
    }
    .pending{
        font-weight: bold;
        color: rgb(15, 66, 193);
        font-size: .8em;
    }


    /* .modal .animation-content .modal-card { */
        /* overflow: visible !important; */
    /* } */

    /* .modal-card-body { */
        /* overflow: visible !important; */
    /* } */
</style>
