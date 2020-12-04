<template>
    <div>
        <h1>Hooks page</h1>
    </div>
</template>

<script>
    export default {
        name: "hooks",
        data(){
            return {
                myname : 'waqas'
            }

        },

        beforeCreate(){
            alert('before everything')
        },

        created() {
            alert('create before html')
        },

        mounted(){

            alert('mounted after html')

        }
    }
</script>


<style scoped>

</style>
