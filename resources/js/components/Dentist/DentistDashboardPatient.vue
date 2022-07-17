<template>
    <div>

        <div class="section">
            <div class="columns is-centered">
                <div class="column is-8">
                    <div class="box">
                        <div class="w-title">
                            PATIENT DASHBOARD
                        </div>

                        <div class="w-body">
                            <div class="w-row">
                                <div>NAME:</div>
                                <div> {{ admit.lname }}, {{ admit.fname }}</div>
                            </div>

                        </div>


                    </div>

                    <div class="box">
                        <div class="w-title">
                            DENTAL CHART
                        </div>

                        <div class="w-body">
                            <div class="w-row">
                                <div>
                                    <div class="dental-chart">
                                        <dental-chart :prop-admit-id=admit.admit_id></dental-chart>
                                    </div>
                                </div>
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
        propData: {
            type: String,
            default: '',
        }
    },

    data(){
        return{
            admit: {},

        }
    },

    methods: {

        initData: function(){
            this.admit = JSON.parse(this.propData);
        },

    },

    mounted(){
        this.initData();
    }
}
</script>

<style scoped>

    .w-title{
        font-weight: bold;
        font-size: 1.3em;
    }

    .w-body{
        padding: 15px;
    }

    .w-row{
        display: flex;
        justify-content: center;
    }

    .dental-chart{
        position: relative;
    }
</style>
