<template>
    <div>
        <div class="content">
            <div class="container">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <div class="container">
                        <p class="_title0">My Vacations:  <span class="pl-2 text-warning">
                             {{my_total_vacations}}
                              <!-- / {{$store.state.user.total_vacations}} -->
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
            salesforcevacations:{},
            my_total_vacations:0,
            email:this.$store.state.user.email,

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
        const result = await this.callApi('get','/app/getSalesForce/'+this.email);
        // const result = await this.callApi('get','/app/getSalesForce/hilbi.azhar@gmail.com');
        if(result.status === 200){
            const tempResult = JSON.parse(result.data);
            tempResult.records.forEach(element => {
                this.my_total_vacations+= element.Number_of_Days__c;
                let temp_vac = {
                    "description":element.Description,
                    "type":'null',
                    "startDate":element.Start_Date__c,
                    "endDate":element.End_Date__c,
                    "status":"Approved",
                }
                this.data1.unshift(temp_vac);
            });
            this.$Progress.finish();
        }
    } //end CREATED
}
</script>
