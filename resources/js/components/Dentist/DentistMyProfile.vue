<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="column is-6">

                    <form @submit.prevent="submit">
                        <div class="box">
                            <h1 class="title is-4">MY PROFILE</h1>

                            <div class="container">

                                <div class="buttons is-right">
                                    <b-button @click="openModalChangePassword" icon-left="lock">Change Password</b-button>
                                </div>


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


            <!--modal reset password-->
            <b-modal v-model="modalChangePassword" has-modal-card
                     trap-focus
                     :width="640"
                     aria-role="dialog"
                     aria-label="Modal"
                     aria-modal>

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
                                        <b-field label="Old Password" label-position="on-border"
                                                 :type="this.errors.old_password ? 'is-danger':''"
                                                 :message="this.errors.old_password ? this.errors.old_password[0] : ''">
                                            <b-input type="password" v-model="fields.old_password" password-reveal
                                                     placeholder="Password" required>
                                            </b-input>
                                        </b-field>
                                        <b-field label="Password" label-position="on-border"
                                                 :type="this.errors.password ? 'is-danger':''"
                                                 :message="this.errors.password ? this.errors.password[0] : ''">
                                            <b-input type="password" v-model="fields.password" password-reveal
                                                     placeholder="Password" required>
                                            </b-input>
                                        </b-field>
                                        <b-field label="Confirm Password" label-position="on-border"
                                                 :type="this.errors.password_confirmation ? 'is-danger':''"
                                                 :message="this.errors.password_confirmation ? this.errors.password_confirmation[0] : ''">
                                            <b-input type="password" v-model="fields.password_confirmation"
                                                     password-reveal
                                                     placeholder="Confirm Password" required>
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
            <!--close modal-->


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

            modalChangePassword: false,

            provinces: [],
            cities: [],
            barangays: [],


            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },
        }

    },

    methods:{

        /*
        * Load async data
        */
        loadAsyncData() {
            axios.get(`/dentist/get-my-profile`)
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

            axios.put('/dentist/my-profile/' + this.global_id, this.fields).then(res=>{
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



        openModalChangePassword(){
            this.modalChangePassword = true;
            this.fields.password = null;
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

    mounted(){
        this.loadProvince();
        this.loadAsyncData();
    }


}
</script>
