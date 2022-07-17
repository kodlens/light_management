<template>
    <div>
        <div class="my-hero-container">
            <div class="video">
                <video autoplay muted loop class="my-video">
                    <source src="/vid/banner-video.mp4" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
            </div>

            <div class="main-text-container">
                <p class="main-title">DENTAL CLINIC</p>
                <p class="main-subtitle">Exceptional Care for all ages.</p>
            </div>
        </div>


    </div> <!--root div-->
</template>

<script>
export default {
    props: ['propUser'],
    data(){
        return{
            locale: undefined,
            isModalActive: false,
        }

    },

    methods: {

    },

    mounted() {


    },


}
</script>

<style scoped>

    .my-hero-container{
        display: flex;
        flex-direction: column;
    }
    .main-text-container{
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        margin: 0 25px 0 100px;
        z-index: 0;
        background: black;
        padding: 30px;
        opacity: .6;
    }
    .main-title{
        color: white;
        font-size: 3em;
        font-weight: bold;
        opacity: 1;
    }

    .main-subtitle{
        color: white;
        font-size: 2em;
        font-weight: bold;

    }

    .my-video{
        z-index: -1;
        width: 100%;
        /*display: none;*/
    }

    @media only screen and (max-width: 1024px) {

    }

    @media only screen and (max-width: 768px) {
        .main-text-container{
            top: 230px;
            width: 100%;
            margin: 0;
        }
    }

    @media only screen and (max-width: 480px) {
        .main-text-container{
            padding: 15px;
        }
        .main-title{
            font-size: 1.2em;
        }

        .main-subtitle{
            font-size: .8em;
        }

    }





</style>
