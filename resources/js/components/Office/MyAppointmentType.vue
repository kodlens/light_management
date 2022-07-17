<template>
    <div>
        <div class="section">

            <div class="columns">
                <div class="column is-8 is-offset-2">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">MY APPOINTMENT TYPE</div>

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
                                            v-model="search.type" placeholder="Search Appointment Type"
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
                                {{ props.row.appointment_type_id }}
                            </b-table-column>

                            <b-table-column field="office_name" label="Office" v-slot="props">
                                {{ props.row.office_name }}
                            </b-table-column>

                            <b-table-column field="appointment_type" label="Appointment" v-slot="props">
                                {{ props.row.appointment_type }}
                            </b-table-column>

                            <b-table-column field="cc_time" label="Time" v-slot="props">
                                {{ props.row.cc_time }}
                            </b-table-column>

                            <b-table-column field="max_multiple" label="Max Multiple" v-slot="props">
                                {{ props.row.max_multiple }}
                            </b-table-column>

                            <b-table-column field="is_active" label="Active" v-slot="props">
                                <span style="font-weight: bold; color: green;" v-if="props.row.is_active === 1">ACTIVE</span>
                                <span style="font-weight: bold; color: blue;" v-else>INACTIVE</span>
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-primary">
                                        <b-button class="button is-small is-primary mr-1" tag="a" icon-right="pencil" @click="update(props.row)"></b-button>
                                    </b-tooltip>

                                    <b-tooltip v-if="props.row.is_active === 0" label="Activate" type="is-link">
                                        <b-button class="button is-small is-link mr-1" icon-right="account-reactivate" @click="confirmActivate(props.row.appointment_type_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip v-else label="Deactivate" type="is-danger">
                                        <b-button class="button is-small is-danger mr-1" icon-right="minus-circle" @click="confirmDeactivate(props.row.appointment_type_id)"></b-button>
                                    </b-tooltip>

                                </div>
                            </b-table-column>

                        </b-table>
                        <div class="buttons mt-3">
                            <b-button @click="openModal(0)" icon-right="account-arrow-up-outline" class="is-success">NEW</b-button>
                        </div>


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

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Appointment Type"
                                             :type="this.errors.appointment_type ? 'is-danger':''"
                                             :message="this.errors.appointment_type ? this.errors.appointment_type[0] : ''">
                                        <b-input v-model="fields.appointment_type"
                                                 placeholder="Appointment Type" required>
                                        </b-input>
                                    </b-field>
                                </div>
                            </div>

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Allocated Time(Minute(s))"
                                             :type="this.errors.cc_time ? 'is-danger':''"
                                             :message="this.errors.cc_time ? this.errors.cc_time[0] : ''">
                                        <b-numberinput v-model="fields.cc_time" :controls="false"
                                                       placeholder="" required>
                                        </b-numberinput>
                                    </b-field>
                                </div>

                                <div class="column">
                                    <b-field label="No of multiple"
                                             :type="this.errors.max_multiple ? 'is-danger':''"
                                             :message="this.errors.max_multiple ? this.errors.max_multiple[0] : ''">
                                        <b-numberinput v-model="fields.max_multiple" max="100" :controls="false" placeholder="No of multiple" required>
                                        </b-numberinput>
                                    </b-field>
                                </div>
                            </div>
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




    </div> <!--root div -->
</template>

<script>
export default {
    data() {
        return {
            data: [],
            total: 0,
            loading: false,
            sortField: 'appointment_type_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',

            search: {
                type: '',
            },

            isModalCreate: false,
            fields: {},
            errors: {},

            global_id: 0,

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
                `type=${this.search.type}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-my-appointment-type-list?${params}`)
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



        update(row){
            this.fields = {};
            this.global_id = row.appointment_type_id;
            this.isModalCreate = true;
            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/get-my-appointment-type/'+ this.global_id).then(res=>{
                this.fields = res.data;
            });
        },

        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/my-appointment-type/'+this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                this.loadAsyncData();
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
                axios.post('/my-appointment-type', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.isModalCreate = false;
                                this.loadAsyncData();
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

        //alert box ask for deletion
        confirmDeactivate(dataId) {
            this.$buefy.dialog.confirm({
                title: 'Deactivate?',
                type: 'is-danger',
                message: 'Are you sure you want to deactivate this appointment type?',
                cancelText: 'Cancel',
                confirmText: 'Deactivate',
                onConfirm: () => this.confirmSubmit(dataId)
            });
        },
        //execute delete after confirming
        confirmSubmit(dataId) {
            axios.post('/my-appointment-type-deactivate/' + dataId).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        //ACTIVATE
        confirmActivate(dataId) {
            this.$buefy.dialog.confirm({
                title: 'Activate?',
                type: 'is-link',
                message: 'Are you sure you want to activate this appointment type?',
                cancelText: 'Cancel',
                confirmText: 'Activate',
                onConfirm: () => this.confirmSubmitActivate(dataId)
            });
        },
        //execute delete after confirming
        confirmSubmitActivate(dataId) {
            axios.post('/my-appointment-type-activate/' + dataId).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },


    },
    mounted() {
        this.loadAsyncData();

    }
}
</script>
<style scoped>

</style>
