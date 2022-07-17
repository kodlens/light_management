<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-6">

                    <form @submit.prevent="submit">
                        <div class="box">
                            <h1 class="title is-4">MY PROFILE</h1>

                            <div class="container">

<!--                                <div class="columns is-centered">
                                    <div class="column is-6">
                                        <div class="qr-container">
                                            <div>QR CODE: {{ fields.qr_ref }}</div>
                                            <div v-if="fields.qr_ref">
                                                <qrcode  :value="fields.qr_ref" :options="{ width: 200 }"></qrcode>
                                            </div>
                                        </div>
                                    </div>
                                </div>-->

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Username">
                                            <b-input type="text" readonly v-model="fields.username"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Lastname"
                                                 :type="this.errors.lname ? 'is-danger':''"
                                                 :message="this.errors.lname ? this.errors.lname[0] : ''">
                                            <b-input type="text" v-model="fields.lname"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Firstname"
                                                 :type="this.errors.fname ? 'is-danger':''"
                                                 :message="this.errors.fname ? this.errors.fname[0] : ''">
                                            <b-input type="text" v-model="fields.fname"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Middlename">
                                            <b-input type="text" v-model="fields.mname"></b-input>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Suffix">
                                            <b-input type="text" v-model="fields.suffix"></b-input>
                                        </b-field>
                                    </div>
                                </div>

                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Sex" expanded
                                                 :type="this.errors.sex ? 'is-danger':''"
                                                 :message="this.errors.sex ? this.errors.sex[0] : ''">
                                            <b-select v-model="fields.sex" expanded>
                                                <option value="MALE">MALE</option>
                                                <option value="FEMALE">FEMALE</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Contact No.">
                                            <b-input type="text" v-model="fields.contact_no"></b-input>
                                        </b-field>
                                    </div>
                                </div>


                                <hr>
                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Province" expanded
                                                 :type="this.errors.province ? 'is-danger':''"
                                                 :message="this.errors.province ? this.errors.province[0] : ''">
                                            <b-select v-model="fields.province" @input="loadCity" expanded>
                                                <option v-for="(item, index) in provinces" :key="index" :value="item.provCode">{{ item.provDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>

                                    <div class="column">
                                        <b-field label="City" expanded
                                                 :type="this.errors.city ? 'is-danger':''"
                                                 :message="this.errors.city ? this.errors.city[0] : ''">
                                            <b-select v-model="fields.city" @input="loadBarangay" expanded>
                                                <option v-for="(item, index) in cities" :key="index" :value="item.citymunCode">{{ item.citymunDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                </div>


                                <div class="columns">
                                    <div class="column">
                                        <b-field label="Barangay" expanded
                                                 :type="this.errors.barangay ? 'is-danger':''"
                                                 :message="this.errors.barangay ? this.errors.barangay[0] : ''">
                                            <b-select v-model="fields.barangay" expanded>
                                                <option v-for="(item, index) in barangays" :key="index" :value="item.brgyCode">{{ item.brgyDesc }}</option>
                                            </b-select>
                                        </b-field>
                                    </div>
                                    <div class="column">
                                        <b-field label="Street">
                                            <b-input v-model="fields.street"
                                                     placeholder="Street">
                                            </b-input>
                                        </b-field>
                                    </div>
                                </div>


                                <div class="buttons">
                                    <button class="button is-link">UPDATE</button>
                                </div>

                            </div>
                        </div>
                    </form>

                </div> <!--col-->
            </div><!--cols-->

        </div>
    </div>

</template>

<script>
export  default {
    data(){
        return{
            fields: {},
            errors: {},
            global_id: 0,

            provinces: [],
            cities: [],
            barangays: []
        }

    },

    methods:{

        /*
        * Load async data
        */
        loadAsyncData() {
            axios.get(`/get-my-profile`)
                .then(res => {
                    this.fields = res.data;
                    this.global_id = res.data.user_id;

                    let tempData = res.data;
                    //load city first
                    axios.get('/load-cities?prov=' + this.fields.province).then(res=>{
                        //load barangay
                        this.cities = res.data;
                        axios.get('/load-barangays?prov=' + this.fields.province + '&city_code='+this.fields.city).then(res=>{
                            this.barangays = res.data;
                            //this.fields = tempData;
                        });
                    });

                })
                .catch((error) => {
                    throw error
                })
        },

        submit: function(){
            axios.put('/my-profile/' + this.global_id, this.fields).then(res=>{
                if(res.data.status === 'updated'){
                    this.$buefy.dialog.alert({
                        title: 'UPDATED!',
                        message: 'Successfully udpated!',
                        type: 'is-success',
                        onConfirm: ()=>{
                            this.loadAsyncData();
                        }
                    });
                }
            });
        },

        loadProvince: function(){
            axios.get('/load-provinces').then(res=>{
                this.provinces = res.data;
            })
        },

        loadCity: function(){
            axios.get('/load-cities?prov=' + this.fields.province).then(res=>{
                this.cities = res.data;
            })
        },

        loadBarangay: function(){
            axios.get('/load-barangays?prov=' + this.fields.province + '&city_code='+this.fields.city).then(res=>{
                this.barangays = res.data;
            })
        },




    },

    mounted(){
        this.loadProvince();
        this.loadAsyncData();
    }


}
</script>
