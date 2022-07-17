<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-10">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">LIST OF APPOINTMENTS</div>

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

                            <b-table-column field="appointment_id" label="ID" sortable v-slot="props">
                                {{ props.row.appointment_id }}
                            </b-table-column>

                            <b-table-column field="qr_code" label="Ref No." sortable v-slot="props">
                                {{ props.row.qr_code }}
                            </b-table-column>

                            <b-table-column field="dentist_lname" label="Dentist" sortable v-slot="props">
                                {{ props.row.dentist_lname }}, {{ props.row.dentist_fname }} {{ props.row.dentist_mname }}
                            </b-table-column>

                            <b-table-column field="service" label="Service" v-slot="props">
                                {{ props.row.service }} (&#8369;{{ props.row.price }})
                            </b-table-column>

                            <b-table-column field="appoint_datetime" label="Appointment" v-slot="props">
                                {{ props.row.appoint_date }} {{ props.row.appoint_time | formatTime }}
                            </b-table-column>

                            <b-table-column field="patient" label="Patient" v-slot="props">
                                {{ props.row.user_lname }}, {{ props.row.user_fname }} {{ props.row.user_mname }}
                            </b-table-column>

                            <b-table-column field="user_contact_no" label="Patient Contact No." v-slot="props">
                                {{ props.row.user_contact_no }}
                            </b-table-column>

                            <b-table-column field="status" label="Status" v-slot="props">
                                <span class="pending" v-if="props.row.appoint_status === 0">PENDING</span>
                                <span class="approve" v-else-if="props.row.appoint_status === 1">ADMITTED</span>
                                <span class="cancel" v-else>CANCELLED</span>
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <b-dropdown v-if="props.row.appoint_status < 1" aria-role="list">
                                    <template #trigger="{ active }">
                                        <b-button
                                            label="Options"
                                            type="is-primary"
                                            class="is-small"
                                            :icon-right="active ? 'menu-up' : 'menu-down'" />
                                    </template>
                                    <b-dropdown-item aria-role="listitem" @click="openModalUpdate(props.row)">Update</b-dropdown-item>
                                    <b-dropdown-item aria-role="listitem" @click="admitAppointment(props.row)">Admit</b-dropdown-item>
                                    <b-dropdown-item aria-role="listitem" @click="cancelAppointment(props.row)">Cancel</b-dropdown-item>

                                </b-dropdown>
                            </b-table-column>

                        </b-table>

                    </div>
                </div><!--close column-->
            </div>

        </div><!--section div-->


        <b-modal v-model="modalBookNow" :width="640"
            has-modal-card
            trap-focus
            aria-role="dialog"
            aria-label="Modal"
            aria-modal
            type = "is-link">

            <form @submit.prevent="submit">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Book Information</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalBookNow = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                    <b-field label="Service">
                                        <b-select required v-model="fields.service_id">
                                            <option v-for="(item, index) in services" :key="index" :value="item.service_id">{{ item.service }}</option>
                                        </b-select>
                                    </b-field>

                                    <b-field label="Appointment Date"
                                             :type="this.errors.appointment_date ? 'is-danger':''"
                                             :message="this.errors.appointment_date ? this.errors.appointment_date[0] : ''">
                                        <b-datetimepicker v-model="fields.appointment_date"
                                                 placeholder="Appointment Date" required>
                                        </b-datetimepicker>
                                    </b-field>

                                    <modal-browse-dentist
                                        :prop-dentist="dentist_fullname"
                                        @browseDentist="emitBrowseDentist($event)"></modal-browse-dentist>
                                </div>
                            </div>

                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="modalBookNow=false"/>
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">SAVE</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>

    </div>
</template>

<script>
export default {
    props: ['propServices'],
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

            errors: {},
            fields: {},
            dentist_fullname: '',
            services: [],
            modalBookNow: false,
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
            axios.get(`/get-appointments?${params}`)
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


        openModalUpdate(row){
            this.fields.service = row;
            this.modalBookNow = true;
            console.log(row)
            this.fields = row;
            this.fields.appointment_date = new Date(row.appoint_date + " " + row.appoint_time);
            this.dentist_fullname = row.dentist_lname + ", " + row.dentist_fname + " " + row.dentist_mname;

        },

        emitBrowseDentist: function(data){

            this.fields.dentist_id = data.user_id;
            this.fields.lname = data.lname;
            this.fields.fname = data.fname;
            this.fields.mname = data.mname;
            this.fields.suffix = data.suffix;
            this.dentist_fullname = data.lname + ', ' + data.fname + ' ' + data.mname;
            this.fields.sex = data.sex;
        },

        submit: function(){

            if(this.fields.appointment_id){
                axios.put('/appointments/' + this.fields.appointment_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            type: 'is-success',
                            message: 'Successfully updated.',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.fields = {};
                                this.errors = {};
                                this.loadAsyncData();
                                this.modalBookNow = false;
                            }
                        });
                    }
                });
            }
        },

        //approve schedule
        admitAppointment: function(row){
            this.$buefy.dialog.confirm({
                title: 'APPROVE?',
                type: 'is-info',
                message: 'Are you sure you want to admit this appointment?',
                cancelText: 'Close',
                confirmText: 'Approve',
                onConfirm: () => this.admitSubmit(row)
            });
        },
        admitSubmit(row) {
            axios.post('/appointment-admit/' + row.appointment_id).then(res => {
                this.loadAsyncData();
                if(res.data.status === 'admitted'){
                    this.$buefy.toast.open({
                        message: 'Approved successfully.',
                        type: 'is-success'
                    })
                }

            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },




        //alert box ask for deletion
        cancelAppointment(row) {
            this.$buefy.dialog.confirm({
                title: 'CANCEL?',
                type: 'is-warning',
                message: 'Are you sure you want to cancel this data?',
                cancelText: 'Close',
                confirmText: 'Cancel',
                onConfirm: () => this.cancelSubmit(row)
            });
        },
        //execute delete after confirming
        cancelSubmit(row) {
            axios.post('/appointment-cancel/' + row.appointment_id).then(res => {
                this.loadAsyncData();
                if(res.data.status === 'cancelled'){
                    this.$buefy.toast.open({
                        message: 'Cancel successfully.',
                        type: 'is-success'
                    })
                }
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        initData: function(){
            this.services = JSON.parse(this.propServices);
        }


    },

    mounted() {
        this.search.appointment_date = null;
        this.loadAsyncData();
        this.initData();
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
</style>
