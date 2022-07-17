<template>
    <div>
        <div class="section">
            <div class="columns">
                <div class="column">
                    <p class="title has-text-centered">
                        APPOINTMENT INFORMATION
                    </p>
                </div>
            </div>

            <div class="columns">
                <div class="column">
                    <b-field label="Select Dentist">
                        <b-select v-model="fields.dentist_id" @input="showSchedule">
                            <option v-for="(item, index) in dentists" :key="index" 
                                :value="item.user_id">
                                {{ item.lname }}, {{ item.fname }} {{ item.mname }}
                            </option>
                        </b-select>
                    </b-field>
                </div>

                <div class="column">
                    <div class="subtitle">Dentist Schedule</div>
                    <div>

                    </div>
                </div>
            </div>


        </div><!--section-->


        <div class="line"></div>

    </div><!--root div-->
</template>

<script>
export default {
    data(){
        return{
            dentists: [],
            schedules: [],
            
            fields: {
                dentist_id: 0,
            },
            errors: {},

        }
    },

    methods: {
        initData(){
            axios.get('/get-open-dentists').then(res=>{
                this.dentists = res.data;
            });
        },

        showSchedule(){
            axios.get('/get-dentist-schedules/' + this.fields.dentist_id).then(res=>{
                this.schedules = res.data;
            });
        }
    },

    mounted() {
        this.initData();
    },

}
</script>
