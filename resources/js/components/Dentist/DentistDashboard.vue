<template>
    <div>
        <div class="section">
            <div class="columns is-centered">
                <div class="column is-4">
                    <div class="box">
                        <div class="w-title">
                            NO. OF APPOINTMENT
                        </div>
                        <div class="w-content">
                            {{ info.appointment }}
                        </div>
                    </div>
                </div>

                <div class="column is-4">
                    <div class="box">
                        <div class="w-title">
                            NO. OF PATIENT
                        </div>
                        <div class="w-content">
                            {{ info.admit }}
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</template>

<script>
export default {
    data(){
        return{
            info: {},
        }
    },
    methods: {
        getInfo(){
            axios.get('/dentist/get-dashboard-info').then(res=>{
                this.info = res.data;
            })
        }
    },

    mounted(){
        this.getInfo();
    }
}
</script>

<style scoped>
    .w-title{
        font-weight: bold;
        font-size: 1.6em;
    }
    .w-content{
        text-align: center;
        font-weight: bold;
        font-size: 3em;
    }
</style>
