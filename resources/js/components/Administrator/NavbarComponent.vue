<template>
    <div>
        <div class="mynav">
            <div class="mynav-brand">{{ userRole }} ({{ fullName }})</div>
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
                :right="right"
                v-model="open">
                <div class="p-4">
                    <h3 class="title is-4">{{ userRole }}</h3>
                    <b-menu>

                        <b-menu-list label="Menu">

                            <b-menu-item icon="information-outline" label="Dashboard" tag="a" href="/cpanel"></b-menu-item>

                            <b-menu-item v-if="user.role === 'ADMINISTRATOR'" label="Building" icon="domain" tag="a" href="/buildings"></b-menu-item>

                            <b-menu-item v-if="user.role === 'ADMINISTRATOR'" label="Floor" icon="floor-plan" tag="a" href="/floors"></b-menu-item>

                            <b-menu-item v-if="user.role === 'ADMINISTRATOR'" label="Room" icon="google-classroom" tag="a" href="/rooms"></b-menu-item>

                            <b-menu-item v-if="user.role === 'ADMINISTRATOR'" label="Group Role" icon="account-group" tag="a" href="/group-roles"></b-menu-item>



                            <b-menu-item v-if="user.role === 'ADMINISTRATOR'" label="Device" icon="cellphone-link" tag="a" href="/devices"></b-menu-item>

                            <!-- <b-menu-item v-if="user.role === 'ADMINISTRATOR'" label="Device Accesses" icon="shield-lock" tag="a" href="/device-accesses"></b-menu-item> -->

                            <b-menu-item label="Schedule" icon="domain" tag="a" href="/schedules"></b-menu-item>
                            <b-menu-item label="Group Schedule" icon="domain" tag="a" href="/group-schedules"></b-menu-item>

                            <b-menu-item label="User" icon="account" tag="a" v-if="user.role === 'ADMINISTRATOR'" href="/users"></b-menu-item>

                        </b-menu-list>

                        <b-menu-list label="Actions">
                            <b-menu-item label="System Logs" v-if="user.role === 'ADMINISTRATOR'" icon="post-outline" tag="a" href="/syslogs"></b-menu-item>
                            <b-menu-item @click="logout" icon="logout" label="Logout"></b-menu-item>
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
            overlay: true,
            fullheight: true,
            fullwidth: false,
            right: true,

            user: {
                role: '',
                lname: '', fname: '', mname: '',
            },
        }
    },
    methods: {
        logout(){
            axios.post('/logout').then(()=>{
                window.location = '/';
            })
        },

        initUser(){
            axios.get('/init-user').then(res=>{
                this.user = res.data;
            })
        }
    },

    mounted(){
        this.initUser();
    },

    computed: {
        userRole(){
            return this.user.role.toUpperCase();
        },

        fullName(){
            return this.user.lname.toUpperCase() + ', ' + this.user.fname.toUpperCase()
        }
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
        border-bottom: 2px solid rgba(22, 69, 28, 0.53);
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

</style>
