<template>
    <div>      
        <div class="teeth-container">
            <img src="/img/teeth/1.png" @click="imgFunction" class="img img1">
            <img src="/img/teeth/2.png" @click="imgFunction" class="img img2">
            <img src="/img/teeth/3.png" @click="imgFunction" class="img img3">
            <img src="/img/teeth/4.png" @click="imgFunction" class="img img4">
            <img src="/img/teeth/5.png" @click="imgFunction" class="img img5">
            <img src="/img/teeth/6.png" @click="imgFunction" class="img img6">
            <img src="/img/teeth/7.png" @click="imgFunction" class="img img7">
            <img src="/img/teeth/8.png" @click="imgFunction" class="img img8">
            <img src="/img/teeth/9.png" @click="imgFunction" class="img img9">
            <img src="/img/teeth/10.png" @click="imgFunction" class="img img10">
            <img src="/img/teeth/11.png" @click="imgFunction" class="img img11">
            <img src="/img/teeth/12.png" @click="imgFunction" class="img img12">
            <img src="/img/teeth/13.png" @click="imgFunction" class="img img13">
            <img src="/img/teeth/14.png" @click="imgFunction" class="img img14">
            <img src="/img/teeth/15.png" @click="imgFunction" class="img img15">
            <img src="/img/teeth/16.png" @click="imgFunction" class="img img16">
        </div>

       
    </div><!--root div -->
</template>

<script>
export default {

    data(){
        return{

        }
    },

    methods: {

        imgFunction(evt){
            alert('click');
            console.log(evt);
        }
    },


}
</script>

<style scoped>

    .img{
        border: 1px solid red;
    }

    .teeth-container{
        display: flex;
        flex-wrap: wrap;
    
    }

     /*.img2{
        position: relative;
        top: -40px;
        left: -38px;
    }
    .img3{
        position: relative;
        top: -80px;
        left: -72px;
    }
    .img4{
        position: relative;
        top: -118px;
        left: -100px;
    }
    .img5{
        position: relative;
        top: -148px;
        left: -128px;
    }
    .img6{
        position: relative;
        top: -172px;
        left: -148px;
    }
    .img7{
        position: relative;
        top: -195px;
        left: -158px;
    }
    .img8{
        position: relative;
        top: -205px;
        left: -162px;
    }
    .img9{
        position: relative;
        top: -205px;
        left: -165px;
    }
    .img10{
        position: relative;
        top: -195px;
        left: -175px;
    }
    .img11{
        position: relative;
        top: -175px;
        left: -185px;
    }
    .img12{
        position: relative;
        top: -155px;
        left: -200px;
    }
    .img13{
        position: relative;
        top: -125px;
        left: -225px;
    }
    .img14{
        position: relative;
        top: -80px;
        left: -255px;
    }
    .img15{
        position: relative;
        top: -40px;
        left: -290px;
    }
    .img16{
        position: relative;
        top: 0;
        left: -330px;
    } */

</style>