<template>
    <div>
        <div class="content">
            <div class="container">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <div class="container">
                        <p class="_title0">My Vacations:  <span class="pl-2 text-warning">
                             {{my_vacations}} / {{$store.state.user.total_vacations}}
                            </span>
                             </p>
                        <Table stripe  :columns="columns1" :data="data1"></Table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

export default{
    name:'vacationsList',
     data(){
        return {
            my_vacations:0,
            columns1: [
                 {
                    type: 'index',
                    width: 60,
                    align: 'center'
                },
                {
                    title: 'Description',
                    key: 'description'
                },
                {
                    title: 'Type',
                    key: 'type'
                },
                {
                    title: 'Start Date',
                    key: 'startDate'
                },
                {
                    title: 'End Date',
                    key: 'endDate'
                },
                {
                    title: 'Status',
                    key: 'status'
                },
            ],
            data1: []
        }
    },
    methods:{
        },
    async created(){
        this.$Progress.start()
        const res = await this.callApi('get','/app/getEmployeeVacations');
        if(res.status===200){
            this.my_vacations = res.data.length;
            res.data.forEach(element => {
                let temp_vac = {
                    "description":element.description,
                    "type":element.type,
                    "startDate":element.startDate,
                    "endDate":element.endDate,
                    "status":element.status,
                }
                this.data1.push(temp_vac);
            });
            this.$Progress.finish()
            console.log(this.data1);
        }else if(res.status===422){
            for(let i in res.data.errors){
                this.e(res.data.errors[i][0])
            }
            this.$Progress.fail()
        }else{
            this.swr()
            this.$Progress.fail()
        }
    }
}
</script>
