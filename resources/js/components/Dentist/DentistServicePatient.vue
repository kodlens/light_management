<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-6">
                    <div class="buttons">
                        <b-button label="BACK" icon-left="arrow-left" @click="goBack()"></b-button>
                        <b-button label="Refresh" icon-left="refresh" @click="getAdmitServices"></b-button>
                    </div>
                    <div class="box">
                        <div>
                            PATIENT: {{ admit.patient_lname }}, {{admit.patient_fname}} {{ admit.patient_mname }}
                        </div>
                        <div>
                            ADDRESS: {{ admit.barangay }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="columns is-centered" v-for="(item, index) in admitServices" :key="index">
                <div class="column is-6">
                    <div class="box">
                        <div>
                            <div class="service-title">
                                <div class="is-flex">
                                    <div>Admitted on: {{ item.created_at | formatTime }}</div>
                                    <div class="ml-auto">
                                        <b-button type="is-danger" @click="removeService(item.admit_service_id)" class="is-small is-rounded is-outlined">X</b-button>
                                    </div>
                                </div>


                                <div>Service: {{ item.services.service }} - &#x20B1; {{ item.services.price }}</div>

                            </div>

                            <hr>

                            <div>INVENTORY</div>
                            <div class="service-body">
                                <ul>
                                     <li class="service-row" v-for="(inv, index) in item.service_inventories" :key="index">
                                         {{ inv.item_id }} - {{ inv.item_name }}, Quantity: {{ inv.use_qty }}, Remarks: <span v-if="inv.remarks">({{ inv.remarks }})</span>
<!--                                        <span><b-button type="is-info" tag="a" class="is-small is-outlined is-rounded" icon-left="pencil"></b-button></span>-->
                                        <span><b-button type="is-danger" class="is-small is-outlined is-rounded" @click="deleteServiceInv(inv.service_inventory_id)">x</b-button></span>
                                    </li>
                                </ul>

                                <div class="buttons is-right">
                                    <b-button type="is-info" class="is-small is-outlined" icon-right="plus" @click="openModalInventory(item.admit_service_id)"></b-button>
                                </div>
                            </div>
                            <div class="service-footer">
                                <div class="buttons">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="columns is-centered">
                <div class="column is-6">
                    <div class="buttons is-right">
                        <b-button type="is-primary" @click="openModal">NEW SERVICE</b-button>
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
                            @click="isModalCreate = false" />
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





        <!--modal create-->
        <b-modal v-model="modalAddInventory" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal
                type = "is-link">

            <form @submit.prevent="submitInventory">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Add Inventory</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalAddInventory = false" />
                    </header>

                    <section class="modal-card-body">
                        <div class="">

                            <div class="columns">
                                <div class="column">
                                    <b-field label="Item Name"
                                        :type="this.errors.item_id ? 'is-danger':''"
                                        :message="this.errors.item_id ? this.errors.item_id[0] : ''">
                                        <modal-item :prop-item="itemname"
                                            @browseItem="browseItem($event)"></modal-item>
                                    </b-field>

                                    <b-field expanded>
                                        <b-numberinput expanded v-model="fields.qty" placeholder="Quantity" />
                                    </b-field>

                                    <b-field>
                                        <b-input type="textarea" v-model="fields.remarks" placeholder="Remarks..." />
                                    </b-field>
                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="modalAddInventory=false"/>
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">SAVE</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->



    </div> <!-- root div -->
</template>

<script>
export default {
    props: {
        propData:{
            type: String,
            default: ''
        },

        propToothId:{
            type: [String, Number],
            default: 0
        },

        propAdmitId:{
            type: [String, Number],
            default: 0
        },

    },
    data(){
        return{

            fields: {
                item_id: 0,
                qty: 0,
                admit_id: 0,
                tooth_id: 0,
                remarks: '',
            },
            errors: {},

            btnClass: {
                'is-success' : true,
                'button': true,
            },

            isModalCreate: false,
            modalAddInventory: false,

            itemname: '',

            admit: {},
            admitServices: [],
            services: {},


        }
    },

    methods: {

        getAdmit(){
            axios.get('/dentist/get-admit/' + this.propAdmitId).then(res=>{
                this.admit = res.data;
            });
        },

        getAdmitServices(){
            //param is admit_id and tooth_id
             axios.get('/dentist/get-admit-services/' + this.propAdmitId + '/' + this.propToothId).then(res=>{
                this.admitServices = res.data;
            });
        },

        getAllServices(){
            axios.get('/get-all-services').then(res=>{
                this.services = res.data;
            });
        },

        openModal(){
            this.isModalCreate = true;
        },

        submit: function(){
            this.fields.admit_id = this.propAdmitId;
            this.fields.tooth_id = this.propToothId;

            axios.post('/dentist/admit-services', this.fields).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: 'SAVED!',
                        message: 'Successfully saved!',
                        type: 'is-success',
                        onConfirm: ()=> {

                            this.isModalCreate = false;
                            this.getAdmitServices();
                        }
                    });
                }
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
            })
        },

        removeService: function(nId){
            axios.delete('/dentist/admit-services/' + nId).then(res=>{
                if(res.data.status === 'deleted'){
                    this.$buefy.dialog.alert({
                        title: 'DELETED!',
                        message: 'Successfully deleted!',
                        type: 'is-success',
                        onConfirm: ()=> {
                            this.getAdmitServices();
                        }
                    });
                }
            })
        },

        browseItem(nData){
            this.itemname = nData.item_name;
            this.fields.item_id = nData.item_id;
            this.fields.qty = 0;
        },

        goBack(){
            history.back();
        },



        //SERVICE INVENTORY
        submitInventory: function(){
            this.fields.admit_id = this.propAdmitId;
            this.fields.tooth_id = this.propToothId;

            axios.post('/dentist/admit-services-inventory', this.fields).then(res=>{
                if(res.data.status === 'saved'){
                    this.$buefy.dialog.alert({
                        title: 'SAVED!',
                        message: 'Successfully saved!',
                        type: 'is-success',
                        onConfirm: ()=> {
                            this.itemname = null;
                            this.fields = {};
                            this.modalAddInventory = false;

                            this.getAdmitServices();

                        }
                    });
                }
            }).catch(err=>{
                if(err.response.status === 422){
                    this.errors = err.response.data.errors;
                }
            })
        },

        openModalInventory(dataId){
            this.modalAddInventory = true;
            this.clearFields();
            this.errors = {};

            this.fields.admit_service_id = dataId;
        },

        //deleting service_inventory
        deleteServiceInv: function(nId){
            axios.delete('/dentist/admit-services-inventory/' + nId).then(res=>{
                if(res.data.status === 'deleted'){
                    this.$buefy.dialog.alert({
                        title: 'DELETED!',
                        message: 'Successfully deleted!',
                        type: 'is-success',
                        onConfirm: ()=> {
                            this.getAdmitServices();
                        }
                    });
                }
            })
        },

        clearFields: function (){
           this.fields = {
                item_id: 0,
                qty: 0,
                admit_id: 0,
                tooth_id: 0,
                remarks: '',
            };
        },

    },

    mounted(){
        this.getAdmit();
        this.getAdmitServices();
        this.getAllServices();

    }
}
</script>

<style scoped>

.service-body{
    margin: 15px;
}

.service-footer{

}


</style>
