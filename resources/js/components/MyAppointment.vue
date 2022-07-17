<template>
    <div>
        <div class="section">

            <div class="columns">
                <div class="column">
                    <div class="box">
                        <div class="img-avatar-container">
                            <img src="/img/avatar/avatar.png">
                        </div>

                        <b-field label="Lastname" label-position="on-border">
                            <b-input readonly v-model="user.lname"></b-input>
                        </b-field>
                        <b-field label="Firstname" label-position="on-border">
                            <b-input readonly v-model="user.fname"></b-input>
                        </b-field>
                        <b-field label="Middlename" label-position="on-border">
                            <b-input readonly v-model="user.mname"></b-input>
                        </b-field>
                        <b-field label="Sex" label-position="on-border">
                            <b-input readonly v-model="user.sex"></b-input>
                        </b-field>
                        <b-field label="Contact No." label-position="on-border">
                            <b-input readonly v-model="user.contact_no"></b-input>
                        </b-field>

                        <div class="buttons">
                            <b-button type="is-info" label="Change Password" @click="openModalChangePassword" icon-left="lock"></b-button>
                        </div>
                    </div>
                </div>

                <div class="column is-8">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">MY APPOINTMENTS</div>

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

                            <b-table-column field="appointment_id" label="ID" v-slot="props">
                                {{ props.row.appointment_id }}
                            </b-table-column>

                            <b-table-column field="name" label="Dentist Name" v-slot="props">
                                {{ props.row.dentist_lname }}, {{ props.row.dentist_fname }} {{ props.row.dentist_mname }}
                            </b-table-column>

                            <b-table-column field="service" label="Service" v-slot="props">
                                {{ props.row.service }} (&#8369;{{ props.row.price}})
                            </b-table-column>

                            <b-table-column field="dateTime" label="Appointment DateTime" v-slot="props">
                                {{ props.row.appoint_date }} {{ props.row.appoint_time | formatTime }}
                            </b-table-column>

                            <b-table-column field="contact_no" label="Contact No." v-slot="props">
                                {{ props.row.dentist_contact_no }}
                            </b-table-column>

                            <b-table-column field="appoint_status" centered label="Status" v-slot="props">
                                <span class="pending" v-if="props.row.appoint_status == 0">PENDING</span>
                                <span class="approve" v-else-if="props.row.appoint_status == 1">APPORVED</span>
                                <span class="cancel" v-else>CANCELLED</span>
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning" v-if="props.row.appoint_status == 0">
                                        <b-button class="button is-small mr-1" tag="a" icon-right="pencil" @click="getData(props.row.appointment_id)"></b-button>
                                    </b-tooltip>

                                    <b-tooltip label="Cancel appointment" type="is-danger" v-if="props.row.appoint_status == 0">
                                        <b-button class="button is-small mr-1" icon-right="minus-circle" @click="cancelAppointment(props.row)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column>

                        </b-table>

                        <div class="buttons mt-3">
                            <b-button @click="bookNow" icon-right="account-arrow-up-outline" class="is-success">NEW</b-button>
                        </div>

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
                                        <b-datetimepicker editable v-model="fields.appointment_date"
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





        <b-modal v-model="modalChangePassword" :width="640"
            has-modal-card
            trap-focus
            aria-role="dialog"
            aria-label="Modal"
            aria-modal
            type = "is-link">

            <form @submit.prevent="changePassword">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Change Password</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalChangePassword = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">
                                     <b-field label="Old Password">
                                        <b-input type="password" required placeholder="Password" v-model="fields.old_password"> 
                                        </b-input>
                                    </b-field>
                                    <b-field label="New Password">
                                        <b-input type="password" required placeholder="Password" v-model="fields.password"> 
                                        </b-input>
                                    </b-field>
                                    <b-field label="Retype Password">
                                        <b-input type="password" required placeholder="Password" v-model="fields.password_confirmation"> 
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="modalChangePassword=false"/>
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
    props: ['propServices', 'propUser'],

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

            user: {},


            global_id : 0,

            search: {
                lname: '',
            },

            modalBookNow: false,
            modalChangePassword: false,


            dentist_fullname: '',

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
            axios.get(`/get-my-appointments?${params}`)
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

        //update code here
        getData: function(data_id){
            this.clearFields();
            this.global_id = data_id;
            this.modalBookNow = true;

            axios.get('/my-appointment/' + data_id).then(res=>{
                this.fields = res.data;
                let ndateTime = new Date(res.data.appoint_date + " " + res.data.appoint_time);
                ndateTime = new Date(ndateTime);

                this.fields.appointment_date = ndateTime;
                this.dentist_fullname = res.data.dentist_lname + ", " + res.data.dentist_fname + " " + res.data.dentist_mname;
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


        bookNow(){
            this.modalBookNow = true;
            this.fields = {};
            this.errors = {};
        },


        emitBrowseDentist: function(data){
            this.fields.dentist_id = data.user_id; //user id to dentist id
            this.fields.lname = data.lname;
            this.fields.fname = data.fname;
            this.fields.mname = data.mname;
            this.fields.suffix = data.suffix;
            this.dentist_fullname = data.lname + ', ' + data.fname + ' ' + data.mname;
            this.fields.sex = data.sex;
        },

        initData(){
            this.services = JSON.parse(this.propServices);
            this.user = JSON.parse(this.propUser);
        },

        //CHANGE PASSWORD
        openModalChangePassword(){
            this.modalChangePassword = true;
            this.fields = {};
            this.errors = {};
        },

        changePassword(){
            axios.post('/change-password', this.fields).then(res=>{
                if(res.data.status === 'changed'){
                    this.$buefy.dialog.alert({
                        title: 'PASSWORD CHANGED?',
                        type: 'is-success',
                        message: 'Password successfully changed.',
                        confirmText: 'Ok',
                        onConfirm: ()=> {
                            this.modalChangePassword = false;
                        }
                    });
                }
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
                if(err.response.status === 406){
                    alert('Invalid password');
                }
            })
        }


    },

    mounted() {
        this.initData();
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

    .img-avatar-container{
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }

    .img-avatar-container img{
        height: 200px;
        margin: auto;
    }


    .modal .animation-content .modal-card {
        /* overflow: visible !important; */
    }

    .modal-card-body {
        /* overflow: visible !important; */
    }
</style>
