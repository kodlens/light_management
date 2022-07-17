<template>
    <div>
        <b-navbar>
            <template #brand>
                <img class ="logo"
                     src="/img/dict-banner.png" style="height: 100px;">

            </template>

            <template #start>
            </template>

            <template #end>
                <b-navbar-item href="/">
                    Home
                </b-navbar-item>

                <b-navbar-item tag="div">
                    <div class="buttons" v-if="isAuth > 0">
                        <a class="button is-link" href="/dashboard-user">
                            DASHBOARD
                        </a>
                    </div>
                    <div class="buttons" v-else>
                        <a class="button is-link" href="/sign-up">
                            SIGN UP
                        </a>
                        <a class="button is-success is-outlined" href="/login">
                            LOGIN
                        </a>
                    </div>
                </b-navbar-item>
            </template>
        </b-navbar>
    </div>
</template>

<script>
export default {
    props: ['propIsAuth'],

    data() {
        return {
            user: null,
        }
    },
    methods: {

        initData: function(){
            if(this.propUser){
                this.user = JSON.parse(this.propUser);
            }
        }

    },
    mounted() {
        if(this.isAuth){
            this.initData();
        }
    },

    computed: {
        isAuth(){
            return parseInt(this.propIsAuth);
        },

        showName(){
            if(this.user){
                return this.user.fname.toUpperCase();
            }
            return '';
        },
        currentLogin(){
            if(this.user){
                return true;
            }
            return false;
        }
    }
}
</script>
<style scoped>

</style>
