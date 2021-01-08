<template>
    <div>
        <div class="container">
            <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
                <div class="login-header"><h1>Admin Panel</h1></div>
                <div class="space">
                    <Input v-model="data.email" type="email" placeholder="Email Address" />
                </div>
                <div class="space">
                    <Input v-model="data.password"  type="password" placeholder="Password" />
                </div>
                <div class="login-footer">
                    <Button @click="loginUser" type="primary" :disabled="isLogging" :loading="isLogging">{{ isLogging ? 'Logging..' : 'Login'}}</Button>
                </div>
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
            async loginUser(){
                if(this.data.email.trim()=='') return this.e('Email is required')
                if(this.data.password.trim()=='') return this.e('Password is required')
                if(this.data.password.length<6) return this.e('Incorrect Login Details')
                this.isLogging = true
                const  res = await this.callApi('post','app/login',this.data)
                if(res.status===200){
                    this.s(res.data.msg)
                    window.location='/'
                    // this.$router.push('/');
                    // console.log(res)
                    // this.$router.push('/'); //DOESN'T REFRESH THE WINDOW

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
