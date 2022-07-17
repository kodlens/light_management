<template>
    <div>

        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6">
                    <div class="camera">
                        <qrcode-stream :camera="camera" @decode="onDecode" @init="onInit">
                            <div v-if="validationSuccess" class="validation-success">
                                Scanned successfully.
                            </div>

                            <div v-if="validationFailure" class="validation-failure">
                                Not Allowed.
                            </div>

                            <div v-if="validationPending" class="validation-pending">
                                Processing...
                            </div>
                        </qrcode-stream>
                    </div>

                    <p class="decode-result">QR Code: <b>{{ result }}</b></p>

                    <div class="buttons mt-1 is-centered">
                        <b-button @click="turnCameraOn" label="TURN ON"></b-button>
                        <b-button @click="turnCameraOff" label="TURN OFF"></b-button>

                    </div>

                    <div class="select-container">
                        <div class="select-input">
                            <b-field label="Action">
                                <b-select v-model="currentUser.remark">
                                    <option :value="tempRemark">{{ tempRemark }}</option>
                                    <option value="DONE">DONE</option>
                                </b-select>
                            </b-field>
                        </div>

                    </div>

                </div><!--col-->
            </div><!--close div -->


            <!--TABLE-->
            <div class="columns">
                <div class="column is-10 is-offset-1">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">SCANNED APPOINTMENT</div>

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

                            <b-table-column field="appintment_track_id" label="ID" v-slot="props">
                                {{ props.row.appointment_track_id }}
                            </b-table-column>
                            <b-table-column field="app_date" label="Appointment Date" v-slot="props">
                                {{ props.row.app_date }}
                            </b-table-column>

                            <b-table-column field="appointment_type" label="Appointment" v-slot="props">
                                {{ props.row.appointment_type }}
                            </b-table-column>

                            <b-table-column field="appointment_name" label="Student Name" v-slot="props">
                                {{ props.row.lname }}, {{ props.row.fname }}
                            </b-table-column>

                            <b-table-column field="from_to" label="From/To" v-slot="props">
                                {{ props.row.app_time_from }} -   {{ props.row.app_time_to }}
                            </b-table-column>


                        </b-table>



                    </div>
                </div><!--close column-->
            </div> <!--cols-->



        </div>
        <!--section -->


        <!--modal create-->
<!--        <b-modal v-model="isModalValidModal" has-modal-card-->
<!--                 trap-focus-->
<!--                 :width="640"-->
<!--                 aria-role="dialog"-->
<!--                 aria-label="Modal"-->
<!--                 aria-modal>-->


<!--            <div class="modal-card">-->
<!--                <form @submit.prevent="submit">-->
<!--                    <header class="modal-card-head">-->
<!--                        <p class="modal-card-title">SCANNED INFORMATION</p>-->
<!--                        <button-->
<!--                            type="button"-->
<!--                            class="delete"-->
<!--                            @click="isModalValidModal = false"/>-->
<!--                    </header>-->

<!--                    <section class="modal-card-body">-->

<!--                        <div class="">-->
<!--                            <div class="columns">-->
<!--                                <div class="column">-->
<!--                                    <div style="border: 1px solid #cbcbcb;">-->
<!--                                        <img :src="`/storage/imgs/${user.user.img_path}`" class="visitor-img"/>-->
<!--                                    </div>-->
<!--                                </div>-->

<!--                                <div class="column">-->
<!--                                    <p><b>Name:</b> {{ user.user.lname }}, {{ user.user.fname }} {{ user.user.mname }}</p>-->
<!--                                    <p><b>Visit Schedule:</b> {{ user.appointment_date }}, {{ user.meridian }}</p>-->
<!--                                    <p><b>Relationship: </b> {{ user.inmate_relationship }}</p>-->
<!--                                    <p><b>Inmate to visit: </b> {{ user.inmate }}</p>-->

<!--                                    <div class="companion">-->
<!--                                        <h1 class="title is-6">COMPANION(S)</h1>-->
<!--                                        <ul>-->
<!--                                            <li v-for="(item, index) in user.companions" :key="index"> {{ item.fullname }} - {{ item.inmate_relationship }}</li>-->
<!--                                        </ul>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->

<!--                            <div class="columns">-->
<!--                                <div class="column">-->
<!--                                    <b-field label="Frisk Item(s)">-->
<!--                                        <b-input v-model="fields.frisk_item" type="textarea"></b-input>-->
<!--                                    </b-field>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </section>-->
<!--                    <footer class="modal-card-foot">-->
<!--                        <b-button-->
<!--                            label="Close"-->
<!--                            @click="isModalValidModal=false"/>-->
<!--                        <button-->
<!--                            class="button is-success">SAVE</button>-->
<!--                    </footer>-->
<!--                </form>-->
<!--            </div>-->

<!--        </b-modal>-->
        <!--close modal-->


    </div><!--root-->

</template>



<script>
export default {
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
                appointment_date: new Date()
            },

            user: {
                user: {},

            },

            currentUser: {},
            tempRemark: '',

            isValid: undefined,
            camera: 'off',
            result: null,
            isProcessing: false,

            isModalValidModal: false,

            fields: {},
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
            axios.get(`/office-appointment-tracks?${params}`)
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


        onInit (promise) {
            promise
                .catch(console.error)
                .then(this.resetValidationState)
        },

        resetValidationState () {
            this.isValid = undefined
        },

        async onDecode (content) {
            //console.log(content);
            this.result = content;
            this.turnCameraOff();

            // pretend it's taking really long
            this.isProcessing = true;
            //await this.timeout(3000);

            axios.post('/validate-qr/' + content, {
                remark : this.currentUser.remark
            }).then(res=>{
                this.user = res.data;
                this.isProcessing = false;

                if(res.data === 1){
                    this.isValid = true;
                    this.loadAsyncData();
                    //this.submitTrack();
                }else{
                    this.isProcessing = false;
                    this.isValid = false;
                }
            }).catch(err=>{
                this.isProcessing = false;
            })
            //this.isValid = content.startsWith('http') //this will return boolean value

            // some more delay, so users have time to read the message
            await this.timeout(2000);
            this.turnCameraOn()
        },

        turnCameraOn () {
            this.camera = 'auto';
        },

        turnCameraOff () {
            this.camera = 'off'
        },

        timeout (ms) {
            return new Promise(resolve => {
                window.setTimeout(resolve, ms)
            })
        },

        submitTrack: function(){
            this.fields.appointment_id = '';
            this.fields.office_id = '';
            this.fields.remark = '';

            axios.post('/save-submit-track', this.fields).then(res=>{
                if(res.data.status === 'saved'){
                    this.isModalValidModal = false;
                    this.$buefy.toast.open({
                        message: 'Frist item save successfully.',
                        type: 'is-success'
                    });

                    this.fields = {};
                }
            })
        },

        loadCurrentUser(){
            axios.get('/get-current-user').then(res=>{
                this.currentUser = res.data;
                this.tempRemark = res.data.remark;

            });
        },

    },

    mounted(){
        this.loadCurrentUser();
        this.loadAsyncData();
    },

    computed: {
        validationPending() {
            return this.isProcessing;
        },

        validationSuccess() {

            return this.isValid === true
        },

        validationFailure() {
            return this.isValid === false
        },
    },
}
</script>

<style scoped>
.validation-success,
.validation-failure,
.validation-pending {
    position: absolute;
    width: 100%;
    height: 100%;

    background-color: rgba(255, 255, 255, .8);
    text-align: center;
    font-weight: bold;
    font-size: 1.4rem;
    padding: 10px;

    display: flex;
    flex-flow: column nowrap;
    justify-content: center;
}
.validation-success {
    color: green;
}
.validation-failure {
    color: red;
}

.camera{
    margin: auto;
    width: 240px;
    height: 320px;
    border: 1px solid gray;
}

.decode-result{
    text-align: center;
}

.visitor-img{
    display: block;
    margin-left: auto;
    margin-right: auto;
    width: 50%;

}

.companion{
    margin: 15px 0 10px 25px;
}

.select-container{
    margin: auto;
}
.debug{
    border: 1px solid red;
}

.select-container{
    display: flex;
    justify-content: center;
}


</style>
