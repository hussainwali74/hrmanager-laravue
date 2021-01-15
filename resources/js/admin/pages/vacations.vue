<template>
    <div>
        <div class="content">
            <div class="container">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <Menu mode="horizontal"  active-name="1">
                        <MenuItem name="1">
                            <router-link to="/vacations/my-vacations-list">
                                <Icon type="ios-list" />
                                My Vacations
                            </router-link>
                        </MenuItem>
                        <MenuItem name="2">
                            <router-link to="/vacations/add-vacation">
                                <Icon type="ios-add" />
                                Add Vacation
                            </router-link>
                        </MenuItem>
                    </Menu>
                    <div class="container ">
                        <!-- <router-view /> -->
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                // theme1: $store.theme
            }
        }
    }
</script>
