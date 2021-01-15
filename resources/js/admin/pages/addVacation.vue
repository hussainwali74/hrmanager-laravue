<template>
    <div>
        <div class="content">
            <div class="container">
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <div class="container">

                        <p class="_title0">Vacation Form</p>
                        <div class="space">
                            <Input v-model="data.name" disabled placeholder="Name" />
                        </div>
                        <div class="space">
                            <Input v-model="data.email" disabled  type="email" placeholder="Email" />
                        </div>
                        <div class="space">
                            <Input v-model="data.description" type="textarea" :autosize="{minRows: 2,maxRows: 5}" placeholder="Description..."/>
                        </div>
                        <div class="space">
                            <Select class="space" placeholder="type" style="width:100%" v-model="data.type" id="type">
                                <Option v-for="item in typeOptions" :value="item.value" :key="item.value">{{ item.label }}</Option>
                            </Select>
                        </div>
                        <div class="space">
                            <DatePicker type="date" v-model="data.startDate"

                            format="dd/MM/yyyy"    placeholder="Select start date" style="width: 100%"></DatePicker>
                            <!-- <DatePicker type="date" v-model="data.startDate"
                            :options="options3"
                            format="dd/MM/yyyy" min  placeholder="Select start date" style="width: 100%"></DatePicker> -->
                        </div>
                        <div class="space" v-if="data.type=='Full Day'">
                            <!-- <DatePicker type="date" v-model="data.endDate"
                            :options="options3"
                            format="dd/MM/yyyy" min
                             placeholder="Select end date" style="width: 100%"></DatePicker> -->
                            <DatePicker type="date" v-model="data.endDate"

                            format="dd/MM/yyyy"
                             placeholder="Select end date" style="width: 100%"></DatePicker>
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
    </div>
</template>

<script>
    export default {
        data(){
            return {
                 options3: {
                    disabledDate (date) {
                        return date && date.valueOf() < Date.now() - 86400000;
                    }
                },
                typeOptions:[
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
                    name: this.$store.state.user.fullName,
                    email:this.$store.state.user.email,
                    description : "",
                    subject : "",
                    startDate : new Date(),
                    endDate :new Date(),
                    type:"Half Day"
                },
                isSubmitting:false
            }
        },

        methods:{
            getDate(date){
                let x = new Date(date)
                let month = ((x.getMonth()+1)/10)<1?`0${(x.getMonth()+1)}`:(x.getMonth()+1);
                let day = x.getDate();
                let year = x.getFullYear();
                date = `${day}/${month}/${year}`;
                return date;
            },

            getDateAlt(date){
                let x = new Date(date);
                let day = x.getDate();
                var monthx = new Array();
                monthx[0] = "Jan";
                monthx[1] = "Feb";
                monthx[2] = "Mar";
                monthx[3] = "Apr";
                monthx[4] = "May";
                monthx[5] = "Ju";
                monthx[6] = "Jul";
                monthx[7] = "Aug";
                monthx[8] = "Sep";
                monthx[9] = "Oct";
                monthx[10] = "Nov";
                monthx[11] = "Dec";
                let month = monthx[x.getMonth()];
                 return `${day}-${month}-${x.getFullYear()}`;
            },

            async  addVacation(){
                if(this.data.name.trim()=='') return this.e('Name is required')
                if(this.data.email.trim()=='') return this.e('Email is required')

                if(Date.parse(this.data.endDate) < Date.parse(this.data.startDate)) return this.e('Dates are invalid')

                if(this.data.description.trim()=='') return this.e('Description is required')
                let finalData = {};
                finalData['name'] = this.data.name;
                finalData['email'] = this.data.email;
                finalData['description'] = this.data.description;
                finalData['type'] = this.data.type;
                finalData['subject'] = this.data.type=='Full Day' ? `${this.data.name} : ${this.getDateAlt(this.data.startDate)} - ${this.getDateAlt(this.data.endDate)} `:`${this.data.name} : ${this.getDateAlt(this.data.startDate)}  `;
                finalData['startDate'] = this.getDate(this.data.startDate);
                if(finalData) finalData['endDate'] = this.getDate(this.data.endDate);
                // if(this.data.startDate.trim()=='') return this.e('Start Date is required')
                // if(this.data.endDate.trim()=='') return this.e('End Date is required')
                // const  res = await this.callApi('post','https://webto.salesforce.com/servlet/servlet.WebToCase?encoding=UTF-8',{"00N6F00000Ykwb1": this.data.startDate,"00N6F00000Ykwb6":this.data.endDate,"name":this.data.name,"email":this.data.email,"description":this.data.description,
                // "recordType":this.data.recordType,"orgid":this.data.orgid,"retURL":this.data.retURL,"subject":this.data.subject})

                this.isSubmitting=true
                this.$Progress.start()
                const res = await this.callApi('post','/app/addVacation',finalData)
                if(res.status===200){
                    this.s('Request added successfully!')
                    this.data.description=''
                    this.startDate =new Date(),
                    this.endDate = new Date(),
                    this.type= "Half Day"
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
