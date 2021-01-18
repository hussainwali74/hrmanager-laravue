<template>
    <div>
        <div class="content">
            <div class="container">
                <div class=" _box_shadow _border_radious _mar_b30 _p20">
                    <form v-on:submit.prevent="resetPassword">
                        <div class="login-header"><h1>Reset Password</h1></div>
                        <div class="space">
                            <!-- <Input v-model="data.oldPassword"  type="password" placeholder="Old Password" /> -->
                            <input type="password" v-model="data.oldPassword" class="form-control"   placeholder="Old Password">
                        </div>
                        <hr>
                        <div class="space">
                            <input type="password" v-model="data.password" class="form-control"   placeholder="Password">
                            <!-- <Input v-model="data.password"  type="password" placeholder="New Password" /> -->
                        </div>

                        <div class="space">
                            <!-- <Input v-model="data.confirmPassword"  type="password" placeholder="Confirm New Password" /> -->
                            <input type="password" v-model="data.confirmPassword" class="form-control"   placeholder="Confirm New Password">
                        </div>
                        <div class="login-footer">
                            <!-- <Button @click="resetPassword" type="primary" :disabled="updating" :loading="updating">{{ updating ? 'Updating..' : 'Update'}}</Button> -->
                        <button class="btn btn-info btn-sm" type="submit" :disabled="updating" :loading="updating">{{ updating ? 'Updating..' : 'Update'}}</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "passwordReset",

        data(){
            return {
                data:{
                    email: this.$store.state.user.email,
                    oldPassword : "",
                    password : "",
                    confirmPassword : ""
                },
                updating : false
            }
        },

        methods:{
            async resetPassword(){
                if(this.data.oldPassword.trim()=='') return this.e('Old Password is required')
                if(this.data.password.trim()=='') return this.e('Password is required')
                if(this.data.confirmPassword.trim()=='') return this.e('Confirm Password is required')
                if(this.data.password.length<6) return this.e('Password must be greater than 6 characters')
                if(this.data.password !== this.data.confirmPassword) return this.e('New password and confirm password must match')
                 this.updating = true
                const  res = await this.callApi('post','app/resetPassword',this.data)
                if(res.status===200){
                    console.log(res)
                    this.s(res.data.msg);
                     window.location='/';
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
                this.updating = false
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
