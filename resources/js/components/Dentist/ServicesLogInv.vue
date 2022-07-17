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
                                    <li class="service-row" v-for="(item, index) in services" :key="index">
                                        {{ item.service }} - {{ item.price }}
                                        <span><b-button type="is-info" tag="a" :href="`services-log-inv?serviceid=${ item.service_id }`" class="is-small is-outlined is-rounded">Inv</b-button></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="buttons is-right">
                                <b-button type="is-primary">NEW SERVICE</b-button>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>

        </div>
        
    </div>
</template>

<script>
export default {
    props: {
        propServiceId:{
            type: [String, Number],
            default: 0
        },
       
       
    },
    data(){
        return{
            
            user: {},
            services: {},

        }
    },

    methods: {
        getUser(){
            axios.get('/get-user/' + this.propPatientId).then(res=>{
                this.user = res.data;
            });
        },

        getServices(){
            axios.get('/dentist/get-services-log?appid='+this.propAppId).then(res=>{
                this.services = res.data;
            });
        }
    },

    mounted(){
        this.getUser();
        this.getServices();
    }
}
</script>

<style scoped>

.service-body{
    margin: 15px;
}


</style>