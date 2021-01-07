<template>
    <div>
        <div class="content">
            <div class="container">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Vacation Form</p>
                    <div class="space">
                        <Input v-model="data.name" placeholder="Name" />
                    </div>
                    <div class="space">
                        <Input v-model="data.email"  type="email" placeholder="Email" />
                    </div>
                    <div class="space">
                        <Input v-model="data.description" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Description..."/>
                    </div>
                    <div class="space">
                        <DatePicker type="date" v-model="data.startDate" placeholder="Select start date" style="width: 100%"></DatePicker>
                    </div>
                    <div class="space">
                        <DatePicker type="date" v-model="data.endDate" placeholder="Select end date" style="width: 100%"></DatePicker>
                    </div>
                    <div class="space">
                        <Select class="space" placeholder="type" style="width:100%" v-model="data.type" id="type">
                            <Option v-for="item in typeOptions" :value="item.value" :key="item.value">{{ item.label }}</Option>
                        </Select>
                    </div>

                    <div slot="footer">
                        <Button  type="primary" @click="addVacation()" :disabled="isSubmitting" :loading="isSubmitting">
                            {{ isSubmitting ? 'Processing..' : 'Submit'}}
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                typeOptions:[
                    {
                        value: '',
                        label: '---None--'
                    },
                    {
                        value: 'Half Day',
                        label: 'Half Day'
                    },
                    {
                        value: 'Full Day',
                        label: 'Full Day'
                    },
                ],
                data : {
                    name: "",
                    email:"",
                    description : "",
                    startDate : "",
                    endDate :"",
                    type:""
                },
                isSubmitting:false
            }
        },

        methods:{
            async  addVacation(){
                if(this.data.name.trim()=='') return this.e('Name is required')
                if(this.data.email.trim()=='') return this.e('Email is required')
                if(this.data.description.trim()=='') return this.e('Description is required')
                // if(this.data.startDate.trim()=='') return this.e('Start Date is required')
                // if(this.data.endDate.trim()=='') return this.e('End Date is required')
                // const  res = await this.callApi('post','https://webto.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8',{"00N6F00000Ykwb1": this.data.startDate,"00N6F00000Ykwb6":this.data.endDate,"name":this.data.name,"email":this.data.email,"description":this.data.description,
                //     "recordType":this.data.recordType,"orgid":this.data.orgid,"retURL":this.data.retURL,"subject":this.data.subject})
                this.isSubmitting=true
                this.$Progress.start()
                const res = await this.callApi('post','/app/addVacation',this.data)
                if(res.status===200){
                    this.s('Request added successfully!')
                    this.data.name=''
                    this.data.email=''
                    this.data.description=''
                    this.data.startDate=''
                    this.data.endDate=''
                    this.data.type=''
                    this.$Progress.finish()
                }else if(res.status===422){
                    for(let i in res.data.errors){
                        this.e(res.data.errors[i][0])
                    }
                    this.$Progress.fail()
                }else{
                    this.swr()
                    this.$Progress.fail()
                }
                this.isSubmitting=false
            } //end  ADDVACATION
        }, //end  METHODS

        async created(){

        }, //end  CREATED
    }
</script>
