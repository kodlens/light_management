<template>
    <div>
        <div class="mynav">
            <div class="mynav-brand">DENTIST</div>
            <div class="textcenter">
               HI {{ user.fname }}

            </div>
            <div class="burger-button" @click="open = true">
                <div class="burger-div"></div>
                <div class="burger-div"></div>
                <div class="burger-div"></div>
            </div>

        </div>

            <b-sidebar
                type="is-light"
                :fullheight="fullheight"
                :fullwidth="fullwidth"
                :overlay="overlay"
                :expand-on-hover="expandOnHover"
                :reduce="reduce"
                :right="right"
                v-model="open">
                <div class="p-4">
                    <h3 class="title is-4"></h3>
                    <b-menu>

                        <b-menu-list label="DENTIST MENU">

                            <b-menu-item icon="home" label="Home" tag="a" href="/dentist/dashboard"></b-menu-item>

                            <b-menu-item label="Appointment" icon="calendar-blank" tag="a" href="/dentist/appointments"></b-menu-item>

                            <b-menu-item label="My Patients" icon="hospital-box" tag="a" href="/dentist/my-patients"></b-menu-item>

                            <b-menu-item label="My Schedules" icon="hospital-box" tag="a" href="/dentist/dentist-schedule"></b-menu-item>


<!--                            <b-menu-item label="Items" icon="sitemap" tag="a" href="/dentist/dentist-items"></b-menu-item>-->

                            <b-menu-item label="My Profile" icon="face-man-profile" tag="a" href="/dentist/my-profile"></b-menu-item>


                        </b-menu-list>


                        <b-menu-list label="Actions">
                            <b-menu-item @click="logout" label="Logout"></b-menu-item>
                        </b-menu-list>
                    </b-menu>
                </div>
            </b-sidebar>

    </div>


</template>

<script>
export default {
    data(){
        return{
            open: false,
            overlay: false,
            fullheight: true,
            fullwidth: false,
            right: true,
            expandOnHover: true,
            reduce :false,

            user: {},
        }
    },
    methods: {
        logout(){
            axios.post('/logout').then(()=>{
                window.location = '/';
            })
        },

        getUser(){


        },
    },

    mounted(){
        axios.get('/get-user').then(res=>{
            this.user = res.data;
        })
    }


}
</script>

<style scoped>
    .logo{
        padding: 0 30px 0 30px;
        height: 90px;
    }

    .burger-div{
        width: 20px;
        height: 3px;
        background-color: #696969;
        margin: 0 0 3px 0;
        margin-left: auto;
        border-radius: 10px;
    }

    .burger-button{
        display: flex;
        flex-direction: column;
        margin-left: auto;
    }

    .mynav{
        padding: 25px;
        border-bottom: 2px solid rgba(196, 196, 196, 0.53);
        display: flex;
    }

    .mynav-brand{
        font-weight: bold;
        font-size: 1.2em;
    }

  /* .hero{
        background-image: url("/img/bg-hero.jpg");
        background-repeat: no-repeat;
        background-size: cover;
    } */

    .textcenter{
        width: 100%;
        text-align: center;
        font-size: 1em;
        font-weight: bold;
    }

</style>
