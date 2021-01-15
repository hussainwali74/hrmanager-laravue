<template>
    <div>
        <div v-if="$store.state.user" >
            <!--========== ADMIN SIDE MENU one ========-->
            <div class="_1side_menu"  >
                <div class="_1side_menu_logo">
                    <!-- <h3 style="text-align:center;">Hr</h3> -->
                    <img src="/img/logo.png" style="width: 50px;"/>
                </div>

                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_content" >
                    <div class="_1side_menu_img_name">
                        <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                        <p class="_1side_menu_name">{{$store.state.user.fullName.toUpperCase()}}</p>
                    </div>

                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul">
                            <li v-if="$store.state.user.userType=='admin'">
                                <router-link to="employees"><Icon type="ios-speedometer" /> Employees</router-link></li>
                            <!-- <li v-if="$store.state.user.userType=='employee'">
                                <router-link to="myvacationslist"><Icon type="ios-speedometer" />My Vacations</router-link>
                            </li> -->
                            <li v-if="$store.state.user.userType=='employee'">
                                <router-link to="addvacation"><Icon type="ios-speedometer" /> Add Vacation</router-link>
                            </li>
                            <li>
                                <router-link to="password-reset">
                                    <Icon type="ios-speedometer" />
                                    Password Reset
                                </router-link>
                            </li>
                            <li><a href="/logout"><Icon type="ios-speedometer" /> Logout</a></li>

                        </ul>
                    </div>
                </div>
            </div>
            <!--========== ADMIN SIDE MENU ========-->

            <!--========= HEADER ==========-->
            <!-- <div v-if="$store.state.user.userType=='employee'" class="header">
                <div class="_2menu _box_shadow">
                    <div class="_2menu_logo">
                        <ul class="open_button">
                            <li >
                                <router-link to="/myvacationslist"
                                >
                                <Icon type="ios-list" />
                                </router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div> -->
            <!--========= HEADER ==========-->
        </div>
        <RouterView></RouterView>
        <vue-progress-bar></vue-progress-bar>

    </div>

</template>
<script>
    export default {

        props:['user'],

        data(){
            return {
                isLoggedIn : false,
            }
        },

        created(){
            this.$store.commit('updateUser',this.user)
            // this.$store.commit('theme','dark')
        }
    }
</script>
