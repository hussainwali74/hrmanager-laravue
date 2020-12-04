<template>
    <div>
        <p>Your number is : {{counter}}</p>
        <button v-on:click="incrementNumber()">Increment</button>

    <br>

        <div style="background: grey" v-for="blog in blogs" v-show="blogs">
            <h1>{{blog.title}}</h1>
            <p>{{blog.body}}</p>


        </div>

        <p v-if="flag">div to hide</p>
        <button v-on:click="hideButton()">Hide</button>
        <button v-on:click="showButton()">Show</button>
    </div>









</template>

<script>
    export default {
        name: "methods",

        data(){
            return{
                counter : 0,
                blogs:[],
                flag : true
            }
        },

        methods : {
            incrementNumber(){

                this.counter+=1;

            },
            hideButton(){

                this.flag=false;
            },
            showButton(){

                this.flag=true;
            }
        },

        created() {
           let posts = [
               {'id':1,'title':'title 1','body':'post body 1'},
               {'id':2,'title':'title 2','body':'post body 2'},
               {'id':3,'title':'title 1','body':'post body 3'},
               {'id':4,'title':'title 1','body':'post body 4'},
               {'id':5,'title':'title 1','body':'post body 5'}

           ]

            this.blogs=posts;
        }


    }
</script>

<style scoped>

</style>
