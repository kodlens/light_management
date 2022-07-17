<template>
    <div>
        <div class="section">

            <div class="columns">
                <div class="column is-8 is-offset-2">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">OFFICE APPOINTMENT</div>

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
                                            v-model="search.appointment_date" placeholder="Search Appointment Date"
                                            editable
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

                            <b-table-column field="appointment_id" label="ID" v-slot="props">
                                {{ props.row.appointment_id }}
                            </b-table-column>

                            <b-table-column field="appointment_type" label="Appointment" v-slot="props">
                                {{ props.row.appointment_type }}
                            </b-table-column>

                            <b-table-column field="appointment_name" label="Student Name" v-slot="props">
                                {{ props.row.lname }}, {{ props.row.fname }}
                            </b-table-column>

                            <b-table-column field="app_date" label="Date Appoint" v-slot="props">
                                {{ props.row.app_date }}
                            </b-table-column>

                            <b-table-column field="from_to" label="From/To" v-slot="props">
                                {{ props.row.app_time_from | formatTime }} -   {{ props.row.app_time_to | formatTime }}
                            </b-table-column>

                            <b-table-column field="is_approved" label="Is Approved" v-slot="props">
                                <span style="font-weight: bold; color: green;" v-if="props.row.is_approved === 1">APPROVED</span>
                                <span style="font-weight: bold; color: red;" v-else-if="props.row.is_approved === 2">CANCELLED</span>
                                <span style="font-weight: bold; color: blue;" v-else>PENDING</span>
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Change Time" type="is-primary">
                                        <b-button class="button is-small is-primary mr-1" tag="a" icon-right="clock-minus-outline" @click="changeTime(props.row)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Approve Appointment" type="is-warning">
                                        <b-button class="button is-small is-warning mr-1" tag="a" icon-right="thumb-up-outline" @click="approveAppointment(props.row)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Cancel Appointment" type="is-danger">
                                        <b-button class="button is-small is-danger mr-1" icon-right="minus-circle" @click="cancelAppointment(props.row)"></b-button>
                                    </b-tooltip>


                                </div>
                            </b-table-column>

                        </b-table>



                    </div>
                </div><!--close column-->
            </div>


        </div><!--section div-->



        <!--modal create-->
        <b-modal v-model="isModalCreate" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal
                 type = "is-link">

            <form @submit.prevent="submit">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Appointment Type</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">

                            <b-field label="Appointment Type" label-position="on-border"
                                     :type="this.errors.appointment_type ? 'is-danger':''"
                                     :message="this.errors.appointment_type ? this.errors.appointment_type[0] : ''">
                                <b-input v-model="fields.appointment_type"
                                         placeholder="Appointment Type" required>
                                </b-input>
                            </b-field>

                            <b-field label="Allocated Time" label-position="on-border"
                                     :type="this.errors.cc_time ? 'is-danger':''"
                                     :message="this.errors.cc_time ? this.errors.cc_time[0] : ''">
                                <b-numberinput v-model="fields.cc_time" :controls="false"
                                               placeholder="Allocated Time" required>
                                </b-numberinput>
                            </b-field>

                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="isModalCreate=false"/>
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">SAVE</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->






        <!--modal change time-->
        <b-modal v-model="modalChangeTime" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal
                 type = "is-link">

            <form @submit.prevent="submitChangeTime">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Appointment Type</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalChangeTime = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <b-datetimepicker rounded expanded class="mb-2"
                                  v-model="appointment.appointment_date"
                                  placeholder="Type or select a date..."
                                  icon="calendar-today"
                                  :locale="locale"
                                  editable>
                            </b-datetimepicker>

                            <b-notification v-if="this.errors.not_allowed"
                                            type="is-danger is-light"
                                            aria-close-label="Close notification"
                                            role="alert">
                                {{ this.errors.not_allowed[0] }}
                            </b-notification>

                            <b-notification v-if="this.errors.limit"
                                            type="is-danger is-light"
                                            aria-close-label="Close notification"
                                            role="alert">
                                {{ this.errors.limit[0] }}
                            </b-notification>

                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="modalChangeTime=false"/>
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">SAVE</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->


    </div>
</template>

<script>
export default {
    name: "AppointmentType",
    data(){
        return{
            locale: undefined,

            data: [],
            total: 0,
            loading: false,
            sortField: 'appointment_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',


            global_id : 0,

            appointment: {},

            search: {
                appointment_type: '',
                appointment_date: new Date(),
            },

            isModalCreate: false,
            modalChangeTime: false,

            fields: {
                appointment_type: '',
            },
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

            this.search.ndate = new Date(this.search.appointment_date).toLocaleDateString();

            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `appdate=${this.search.ndate}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-office-appointments?${params}`)
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

        openModal(){
            this.isModalCreate=true;
            this.fields = {};
            this.errors = {};
        },


        //alert box ask for deletion
        approveAppointment(row) {
            this.$buefy.dialog.confirm({
                title: 'APPROVE?',
                type: 'is-primary',
                message: 'Are you sure you want to approve this appointment?',
                cancelText: 'Cancel',
                confirmText: 'APPROVE',
                onConfirm: () => this.approveSubmit(row.appointment_id)
            });
        },
        //execute delete after confirming
        approveSubmit(dataId) {
            axios.post('/office-appointment-approve/' + dataId).then(res => {
                if(res.data.status === 'approved'){
                    this.$buefy.toast.open({
                        message: 'Appointment approved',
                        type: 'is-success'
                    });
                    this.loadAsyncData();
                }

            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        cancelAppointment(row) {
            this.$buefy.dialog.confirm({
                title: 'CANCEL?',
                type: 'is-danger',
                message: 'Are you sure you want to cancel this appointment?',
                cancelText: 'Close',
                confirmText: 'CANCEL',
                onConfirm: () => this.cancelAppointmentSubmit(row.appointment_id)
            });
        },

        cancelAppointmentSubmit(dataId) {
            axios.post('/office-appointment-cancel/' + dataId).then(res => {
                if(res.data.status === 'cancelled'){
                    this.$buefy.toast.open({
                        message: 'Appointment cancelled',
                        type: 'is-success'
                    });
                    this.loadAsyncData();
                }

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
            axios.get('/appointment-type/'+data_id).then(res=>{
                this.fields = res.data;
            });
        },

        clearFields(){
            this.fields = {
                appointment_type: '',
            };
        },


        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/appointment-type/'+this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                                this.isModalCreate = false;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                })
            }else{
                //INSERT HERE
                axios.post('/appointment-type', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.isModalCreate = false;
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                });
            }
        },



        changeTime(row){
            this.modalChangeTime = true;
            let stringDateTime = row.app_date + " " + row.app_time_from;
            let dateTime = new Date(stringDateTime);
            this.appointment.appointment_date = dateTime;
            this.global_id = row.appointment_id;
            this.appointment.appointment_type_id = row.appointment_type_id;

        },

        submitChangeTime(){
            this.appointment.app_date = new Date(this.appointment.appointment_date).toLocaleDateString();
            this.appointment.app_time = new Date(this.appointment.appointment_date).toLocaleTimeString();

            axios.post('/office-appointment-update-time/'+this.global_id, this.appointment).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.toast.open({
                        message: 'Time changed successfully.',
                        type: 'is-success'
                    });
                    this.modalChangeTime = false;
                    this.loadAsyncData();
                }
                console.log(res.data)
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
            });
        }

    },

    mounted() {
        this.search.appointment_date = null;

        this.loadAsyncData();
    }

}
</script>

<style scoped>
    .modal .animation-content .modal-card {
        overflow: visible !important;
    }

    .modal-card-body {
        overflow: visible !important;
    }
</style>
