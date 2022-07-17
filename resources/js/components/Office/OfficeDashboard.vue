<template>
    <div>
        <div class="columns is-centered">
            <div class="column is-6 mt-4">
                <div class="box">
                    <div style="font-weight: bold; font-size: 1.5em;">No. of request as of {{ dateNow }}</div>
                    <div class="no-request">{{ noRequest }}</div>
                </div>
            </div>
        </div>

    </div>
</template>


<script>
export default {
    data(){
        return {
            noRequest: 0,

        }
    },

    methods: {
        getNoRequest(){
            axios.get('/get-no-request').then(res=>{
                this.noRequest = res.data;
            })
        }
    },

    mounted() {
        this.getNoRequest()
    },

    computed: {
        dateNow(){
            let d = new Date();
            const month = d.toLocaleString('default', { month: 'long' });
            return month + ' ' + d.getDate() + ' ' + d.getFullYear()
        }
    }
}
</script>

<style scoped>

    .no-request{
        font-weight: bold;
        font-size: 3em;
        text-align: center;
    }

</style>
