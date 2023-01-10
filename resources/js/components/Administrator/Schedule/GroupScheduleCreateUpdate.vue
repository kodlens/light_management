<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-6-desktop is-10-tablet">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">Create/Update Group Schedule</div>

                        <form @submit.prevent="submit">
                            <div class="">

                                <b-field label="Schedule Name" label-position="on-border"
                                    :type="this.errors.schedule_name ? 'is-danger':''"
                                    :message="this.errors.schedule_name ? this.errors.schedule_name[0] : ''">
                                    <b-input type="text" v-model="fields.schedule_name" placeholder="Schedule Name"></b-input>
                                </b-field>

                                <b-field label="Enter some tags"
                                    label-position="on-border">
                                    <b-taginput
                                        v-model="fields.devices"
                                        :data="devices"
                                        autocomplete
                                        :allow-new="false"
                                        @remove="removeDevice"
                                        :open-on-focus="false"
                                        field="device_name"
                                        icon="label"
                                        placeholder="Add a device"
                                        @typing="getFilteredTags">
                                    </b-taginput>
                                </b-field>


                                <b-field
                                    label="Please select an option"
                                    label-position="on-border"
                                    expanded>
                                    <b-select
                                        v-model="fields.action_type"
                                        expanded>
                                        <option :value="0">SPECIFIC DATE</option>
                                        <option :value="1">CUSTOM DAYS</option>
                                    </b-select>
                                </b-field>
                                <div v-if="fields.action_type == 0">
                                    <b-field label="Select Date Time" grouped  expanded class="is-centered" label-position="on-border"
                                            :type="this.errors.date_time ? 'is-danger':''"
                                            :message="this.errors.date_time ? this.errors.date_time[0] : ''">
                                        <b-datetimepicker expanded
                                            v-model="fields.date_time"
                                            placeholder="Type or select a date..."
                                            icon="calendar-today"
                                            :locale="locale"
                                            editable>
                                        </b-datetimepicker>
                                    </b-field>

                                    <b-field label="System Action" label-position="on-border" expanded>
                                        <b-select v-model="fields.system_action" expanded>
                                            <option value="ON">ON</option>
                                            <option value="OFF">OFF</option>
                                        </b-select>
                                    </b-field>
                                </div>



                                <!-- <b-field label="Action Type" label-position="on-border" expanded>
                                    <b-select v-model="fields.action_type" expanded>
                                        <option value="REPEAT">REPEAT</option>
                                        <option value="SPECIFIC">SPECIFIC</option>
                                    </b-select>
                                </b-field> -->


                                <div v-if="fields.action_type == 1">
                                    <hr>

                                    <b-field label="Schedule On" grouped  expanded class="is-centered" label-position="on-border"
                                            :type="this.errors.schedule_on ? 'is-danger':''"
                                            :message="this.errors.schedule_on ? this.errors.schedule_on[0] : ''">
                                        <b-timepicker expanded
                                            v-model="fields.schedule_on"
                                            icon="calendar-today"
                                            :locale="locale"
                                            editable>
                                        </b-timepicker>
                                    </b-field>

                                    <b-field label="Schedule Off" grouped  expanded class="is-centered" label-position="on-border"
                                            :type="this.errors.schedule_off ? 'is-danger':''"
                                            :message="this.errors.schedule_off ? this.errors.schedule_off[0] : ''">
                                        <b-timepicker expanded
                                            v-model="fields.schedule_off"
                                            icon="calendar-today"
                                            :locale="locale"
                                            editable>
                                        </b-timepicker>
                                    </b-field>

                                    <div>
                                        <b-field label="Days">
                                            <b-checkbox v-model="fields.mon">Mon</b-checkbox>
                                            <b-checkbox v-model="fields.tue">Tue</b-checkbox>
                                            <b-checkbox v-model="fields.wed">Wed</b-checkbox>
                                            <b-checkbox v-model="fields.thu">Thu</b-checkbox>
                                            <b-checkbox v-model="fields.fri">Fri</b-checkbox>
                                            <b-checkbox v-model="fields.sat">Sat</b-checkbox>
                                            <b-checkbox v-model="fields.sun">Sun</b-checkbox>
                                        </b-field>
                                    </div>
                                </div><!--end v-if-->

                            </div>

                            <div class="buttons mt-4">
                                <button :class="btnClass">SAVE</button>
                            </div>

                        </form>
                    </div>
                </div><!--close column-->
            </div>
        </div><!--section div-->

    </div>
</template>

<script>
export default {

    props: ['propId', 'propData'],

    data(){
        return{

            locale: undefined, // Browser locale

            global_id : 0,

            search: {
                from_date: '',
                to_date: '',
            },

            isModalCreate: false,

            filteredDevices: [],

            fields: {
                action_type: 0,
                devices: [],
                schedule_name: null,
                schedule_on: null,
                schedule_off: null,
                date_from: null,
                date_to: null,
                date_time: new Date(),
                mon: false,
                tue: false,
                wed: false,
                thu: false,
                fri: false,
                sat: false,
                sun: false,
            },
            errors: {},

            btnClass: {
                'is-info': true,
                'button': true,
                'is-loading':false,
            },

            devices: [],

            data: [],

        }
    },

    methods: {

        loadDevices(){
            axios.get('/load-open-devices').then(res=>{
                this.devices = res.data;
            });
        },

        getFilteredTags(text) {
            this.filteredDevices = this.devices.filter((option) => {
                return option.device_name
                    .toString()
                    .toLowerCase()
                    .indexOf(text.toLowerCase()) >= 0
            })
        },

        clearFields(){
            this.fields = {
                action_type: 0,
                devices: [],
                schedule_name: null,
                schedule_on: null,
                schedule_off: null,
                date_from: null,
                date_to: null,
                date_time: new Date(),
                mon: false,
                tue: false,
                wed: false,
                thu: false,
                fri: false,
                sat: false,
                sun: false,
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
        setData: function(){
            this.clearFields();

            //nested axios for getting the address 1 by 1 or request by request

            let nDevices = []
            this.data.group_schedule_devices.forEach(item => {
                nDevices.push({
                    group_schedule_id: item.group_schedule_id,
                    group_schedule_device_id: item.group_schedule_device_id,
                    device_id: item.device_id,
                    device_name: item.device.device_name
                })
            })

            console.log(this.data)
            this.fields.date_time = new Date(this.data.date_time);
            this.fields.devices = nDevices
            this.fields.schedule_name = this.data.schedule_name;

            this.fields.action_type = this.data.action_type;
            this.fields.date_time = new Date(this.data.date_time);
            this.fields.system_action = this.data.system_action;

            this.fields.schedule_on = new Date(new Date().toLocaleDateString() + " " + this.data.schedule_on);
            this.fields.schedule_off = new Date(new Date().toLocaleDateString() + " " + this.data.schedule_off);

            this.fields.mon = this.data.mon === 1 ? true : false;
            this.fields.tue = this.data.tue === 1 ? true : false;
            this.fields.wed = this.data.wed === 1 ? true : false;
            this.fields.thu = this.data.thu === 1 ? true : false;
            this.fields.fri = this.data.fri === 1 ? true : false;
            this.fields.sat = this.data.sat === 1 ? true : false;
            this.fields.sun = this.data.sun === 1 ? true : false;
        },

        submit: function(){

            //this.fields.app_date = new Date(this.fields.appointment_date).toLocaleDateString();
            //this.fields.app_time = new Date(this.fields.appointment_date).toLocaleTimeString();

            if(this.global_id > 0){
                //UPDATE
                axios.put('/group-schedules/'+this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                window.location = '/group-schedules';
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
                axios.post('/group-schedules', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                window.location = '/group-schedules';
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

        removeDevice(data){
            console.log(data)
            axios.post('/group-schedule-remove-device/' + data.group_schedule_device_id).then(()=>{
                this.$buefy.toast.open({
                    message: 'Successfully deleted.',
                    type: 'is-success'
                })
            })
        },
        initData(){
            this.global_id = parseInt(this.propId);

            if(this.global_id > 0){
                //this.getData();
                this.data = JSON.parse(this.propData)
                this.setData()
            }
        },

    },

    mounted() {
        this.loadDevices();
        this.initData();
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


