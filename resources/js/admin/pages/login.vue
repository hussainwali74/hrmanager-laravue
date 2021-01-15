<template>
    <div>
        <div class="container">
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
                <form v-on:submit.prevent="onSubmit">
                    <div class="login-header"><h1>LOGIN </h1></div>
                    <div class="space">
                         <input type="email" v-model="data.email" class="form-control"   placeholder="Email Address">
                    </div>
                    <div class="space">
                        <input type="password" v-model="data.password" class="form-control"   placeholder="Password">
                    </div>
                    <div class="login-footer">
                             <button class="btn btn-info btn-sm" type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "login",
        data(){
            return {
                data:{
                    email : "",
                    password : ""
                },
                isLogging : false
            }
        },

        methods:{
            // async loginUser(){
            //     if(this.data.email.trim()=='') return this.e('Email is required')
            //     if(this.data.password.trim()=='') return this.e('Password is required')
            //     if(this.data.password.length<6) return this.e('Incorrect Login Details')
            //     this.isLogging = true
            //     const  res = await this.callApi('post','app/login',this.data)
            //     if(res.status===200){
            //         this.s(res.data.msg)
            //         window.location='/'
            //     }else if(res.status===401){
            //         this.i(res.data.msg)
            //     }else if(res.status===422){
            //         for(let i in res.data.errors){
            //             this.e(res.data.errors[i][0])
            //         }
            //     }else{
            //         this.swr()
            //     }
            //     this.isLogging = false
            // },
            async  onSubmit(){
                if(this.data.email.trim()=='') return this.e('Email is required')
                if(this.data.password.trim()=='') return this.e('Password is required')
                if(this.data.password.length<6) return this.e('Incorrect Login Details')
                this.isLogging = true
                const  res = await this.callApi('post','app/login',this.data)
                if(res.status===200){
                    this.s(res.data.msg)
                    window.location='/'
                }else if(res.status===401){
                    this.i(res.data.msg)
                }else if(res.status===422){
                    for(let i in res.data.errors){
                        this.e(res.data.errors[i][0])
                    }
                }else{
                    this.swr()
                }
                this.isLogging = false
            }
        }
    }
</script>

<style scoped>
    ._1adminOverveiw_table_recent {
        margin: 0 auto;
        margin-top: 220px;
    }
    .login-footer{
        text-align: center;
    }
    .login-header{
        text-align: center;
    }

</style>
