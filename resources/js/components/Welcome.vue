<template>
    <div>

        <!-- <div class="section">
            <h1 class="title has-text-centered">
                TRAINING INFORMATION CENTER MANAGEMENT SYSTEM (TICMS)
            </h1>
            <p class="subtitle has-text-centered">Online Reservation of DICT Training Center</p>
        </div> -->

        <section class="hero is-info">
            <div class="hero-body">
                <img src="/img/hero_banner.png" class="my-bg"/>
            </div>
        </section>

        <set-appointment-component v-if="isAuth === 1"></set-appointment-component>


        <footer-component></footer-component>

    </div>
</template>

<script>
import FooterComponent from './FooterComponent.vue'
export default {
    props: ['propIsAuth'],
    data() {
        FooterComponent
        return {}
    },
    methods: {},
    mounted() {

    },

    computed: {
        isAuth(){
            return parseInt(this.propIsAuth)
        }
    }
}
</script>
<style scoped>
    .my-bg{
        background-repeat: no-repeat, repeat;
        background-size: cover; /* Resize the background image to cover the entire container */
        
    }
</style>
