<template>
    <div class="content">
        <div class="container">
            <h1>I will show how other comp react to changes</h1>
            <h2>Current state of counter : {{counter}}</h2>
            <div>
                 <comA></comA>
            </div>
            <div>
                <comB></comB>
            </div>
            <div>
                <comC></comC>
            </div>

            <button @click="incrementNumber()">CLick me</button>

        </div>
    </div>
</template>

<script>
    import comA from "./comA";
    import comB from "./comB";
    import comC from "./comC";
    import {mapGetters} from 'vuex';

    export default {

        computed:{
              ...mapGetters({
                  'counter' : 'getCounter'
              })
        },

        methods :{
            incrementNumber(){
               // this.$store.commit('changeTheCounter',1)
                this.$store.dispatch('changeCounterAction',1)
            }
        },


        components :{
            comA,comB,comC
        }
    }

</script>

<style scoped>

</style>
