<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-6">
                    <div class="box">
                        <div>
                            PATIENT: {{ user.lname }}, {{user.fname}} {{ user.mname }}
                        </div>
                        <div>
                            ADDRESS: {{ user.barangay }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="columns is-centered">
                <div class="column is-6">
                    <div class="box">
                        <div>
                            <div class="service-title">
                                SERVICE(S):
                            </div>
                            <div class="service-body">
                                <ul>
                                    <li class="service-row" v-for="(item, index) in appointmentServices" :key="index">
                                        {{ item.service }} - {{ item.price }}
                                        <span><b-button type="is-info" tag="a" :href="`services-log-inv?serviceid=${ item.service_id }&appid=${propAppId}&appserviceid=${item.appointment_service_id}`" class="is-small is-outlined is-rounded">Inv</b-button></span>
                                        <span><b-button type="is-danger" class="is-small is-outlined is-rounded" @click="deleteService(item)">x</b-button></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="buttons is-right">
                                <b-button type="is-primary" @click="openModal">NEW SERVICE</b-button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div> <!--section -->


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
                        <p class="modal-card-title">Add Services</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false"/>
                    </header>

                    <section class="modal-card-body">
                        <div class="">

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Service"
                                        :type="this.errors.service ? 'is-danger':''"
                                        :message="this.errors.service ? this.errors.service[0] : ''">
                                        <b-select v-model="fields.service" placeholder="Service">
                                            <option v-for="(item, index) in services" :key="index" :value="item.service_id">{{ item.service }}</option>
                                        </b-select>
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


        
    </div>
</template>

<script>
export default {
    props: {
        propPatientId:{
            type: [String, Number],
            default: 0
        },
        propAppId:{
            type: [String, Number],
            default: 0
        },
       
    },
    data(){
        return{
            
            fields: {},
            errors: {},

            btnClass: {
                'is-success' : true,
                'button': true,
                
            },
            isModalCreate: false,
            user: {},

            appointmentServices: {},
            services: {},

        }
    },

    methods: {

        getUser(){
            axios.get('/get-user/' + this.propPatientId).then(res=>{
                this.user = res.data;
            });
        },

        getAppointmentServices(){
            axios.get('/dentist/get-services-log?appid='+this.propAppId).then(res=>{
                this.appointmentServices = res.data;
            });
        },

        getAllServices(){
            axios.get('/get-all-services').then(res=>{
                this.services = res.data;
                console.log(this.services)
            });
        },

        openModal(){
            this.isModalCreate = true;
        },

        submit: function(){
            this.fields.appointment_id = this.propAppId;

            axios.post('/dentist/appointment-services', this.fields).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: 'SAVED!',
                        message: 'Successfully saved!',
                        type: 'is-success',
                        onConfirm: ()=> {
                            this.getAppointmentServices();
                            this.isModalCreate = false;
                        }
                    });
                }
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
            })
        },

        deleteService: function(row){
            axios.delete('/dentist/appointment-services/' + row.appointment_service_id).then(res=>{
                if(res.data.status === 'deleted'){
                    this.$buefy.dialog.alert({
                        title: 'DELETED!',
                        message: 'Successfully deleted!',
                        type: 'is-success',
                        onConfirm: ()=> {
                            this.getAppointmentServices();
                        }
                    });
                }
            })
        }
        


    },

    mounted(){
        this.getUser();
        this.getAppointmentServices();
        this.getAllServices();
    }
}
</script>

<style scoped>

.service-body{
    margin: 15px;
}


</style>