<template>
    <div>
        <div class="section">
            <div class="columns">
                <div class="column">
                    <p class="title has-text-centered">
                        SERVICES HERE
                    </p>
                </div>
            </div>

            <div class="line"></div>

        </div>

        <div class="section">

            <div class="services">

                <div class="service-card" v-for="(item, index) in services" :key="index">
                    <header class="service-card-header">
                        <p class="service-card-header-title">
                            {{ item.service }}
                        </p>
                    </header>
                    <div class="service-card-content">
                        <div class="service-content">
                            {{ item.description }}
                        </div>
                    </div>
                    <div class="service-price">
                        <div class="peso-sign">&#8369;</div>
                        <div class="price">{{ priceRounded(item.price) }}</div>
                    </div>
                    <footer class="card-footer">
                        <a class="card-footer-item" @click="bookNow(item)">BOOK NOW</a>
                    </footer>
                </div>
            </div>
        </div>


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
                                    <b-field label="Appointment Date"
                                             :type="this.errors.appointment_date ? 'is-danger':''"
                                             :message="this.errors.appointment_date ? this.errors.appointment_date[0] : ''">
                                        <b-datetimepicker v-model="fields.appointment_date"
                                            editable
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


    </div><!--root div-->
</template>

<script>
export default {
    data(){
        return{
            errors:{},
            fields: {},

            dentist_fullname: '',

            services: [],

            btnClass: {
                'button' : true,
                'is-primary' : true,
                'is-is-loading' : false,
            },

            modalBookNow: false,

        }
    },
    methods: {
        getServices: function(){
            axios.get('/get-dental-services').then(res=>{
                this.services = res.data;

                console.log(this.services)
            });
        },

        bookNow(item){
            this.fields.service = item;
            this.modalBookNow = true;
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
            this.btnClass['is-loading'] = true;
            axios.post('/book-now', this.fields).then(res => {
                if(res.data.status === 'saved'){
                    this.$buefy.toast.open({
                        message: 'Appointment saved.!',
                        type: 'is-success'
                    });

                    this.fields = {};
                    this.errors = {};
                    this.dentist_fullname = '';
                    this.modalBookNow = false;
                }
                this.btnClass['is-loading'] = false;
            });
        }

    },

    mounted() {
        this.getServices();
    },

    computed: {
        priceRounded(){
            return p => Math.round((parseFloat(p) + Number.EPSILON) * 100) / 100;
        }
    }
}
</script>

<style scoped>
    .services{
        display: flex;
        flex-wrap: wrap;
        justify-content: space-evenly;
    }

    .service-card{
        width: 520px;
        margin: 15px;

        box-shadow: 8px -14px 56px -54px rgba(0,0,0,1);
        -webkit-box-shadow: 8px -14px 56px -54px rgba(0,0,0,1);
        -moz-box-shadow: 8px -14px 56px -54px rgba(0,0,0,1);

        border: 1px solid rgb(226, 226, 226);
        border-top: 4px solid blue;
        border-radius: 10px;
    }
    .service-card-header{
        padding: 25px;

        border-bottom: 1px solid blue;
    }
    .service-card-header-title{
         font-weight: bold;
        font-size: 2em;
    }

    .service-card-content{
        padding: 20px;
        font-size: 1.3em;
    }

    .service-price{
        display: flex;
        padding: 20px;
    }
    .peso-sign{
        margin-left: auto;
        color: red;
        font-weight: bold;
        font-size: 2em;
    }
    .price{
        color: orange;
        font-size: 3.5em;
        font-weight: bold;
    }




    /* .modal .animation-content .modal-card {
        overflow: visible !important;
    }

    .modal-card-body {
        overflow: visible !important;
    } */

</style>
