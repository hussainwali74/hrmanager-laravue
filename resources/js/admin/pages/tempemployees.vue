<template>
    <div>
        <div class="content">
            <div class="container">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <!-- <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20"> -->
                    <Card :theme="theme3">
                    <p class="_title0">
                            <Select @input="onChangeUserType($event)"
                              class="space" style="40%" v-model="type" id="type">
                                <Option v-for="item in typeOptions" :value="item.value" :key="item.value">{{ item.label }}</Option>
                            </Select>
                        <!-- Employee -->
                         &nbsp;
                        <Button type="default" @click="addModel=true"><Icon type="ios-add" /> Add Employee</Button>
                    </p>
                     <div class="_overflow _table_div">
                         <Table :theme="theme3" stripe :columns="columns1" :data="userType">

                             <template slot-scope="{row,index}" slot="action">
                                    <Button type="info" @click="showEditModel(row,index)" size="small">Edit</Button>
                                    <Button type="error" size="small"
                                        @click="showDeleteModel(row,index)" :loading="row.isDeleting">Delete</Button>

                             </template>
                         </Table>
                        <!-- <table class="_table">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Job Title</th>
                                <th>Action</th>
                            </tr>
                            <tr  v-for="(employee,i) in userType" :key="i" v-if="userType.length" >
                                <td>{{employee.id}}</td>
                                <td>{{employee.fullName}}</td>
                                <td>{{employee.email}}</td>
                                <td>{{employee.contact}}</td>
                                <td>{{employee.job_title}}</td>
                                <td>
                                    <Button type="info" @click="showEditModel(employee,i)" size="small">Edit</Button>
                                    <Button type="error" size="small"
                                    @click="showDeleteModel(employee,i)" :loading="employee.isDeleting">Delete</Button>
                                </td>
                            </tr>
                        </table> -->
                    <!-- </div> -->
                    </div>
                </Card>
                <!--~~~~~~~ Create Employee ~~~~~~~~~-->
                <Modal
                    v-model="addModel"
                    title="Create Employee"
                    :mask-closable = "false"
                    :closable = "false"
                >
                    <div class="space">
                        <Input v-model="data.fullName" placeholder="Full Name" />
                    </div>
                    <div class="space">
                        <Input v-model="data.email" type="email" placeholder="Email" />
                    </div>
                    <div class="space">
                        <Input v-model="data.password" type="password" placeholder="Password" />
                    </div>
                    <div class="space">
                        <Input v-model="data.contact"  placeholder="Contact" />
                    </div>
                    <div class="space">
                        <Input v-model="data.job_title" placeholder="Job Title" />
                    </div>
                    <div class="space">
                      <Select class="space"  v-model="data.type" id="type">
                            <Option v-for="item in typeOptions2" :value="item.value" :key="item.value">{{ item.label }}</Option>
                        </Select>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="addModel=false">Cancel</Button>
                        <Button type="primary" @click="addEmployee()" :disabled="isAdding" :loading="isAdding">
                            {{ isAdding ? 'Adding..' : 'Add Employee'}}
                        </Button>
                    </div>
                </Modal>
                <!--~~~~~~~ Edit Employee ~~~~~~~~~-->
                <Modal
                    v-model="editModel"
                    title="Update Employee"
                    :mask-closable = "true"
                    :closable = "true"
                >
                    <div class="space" style="display:none;">
                        <Input v-model="editdata.id" />
                    </div>
                    <div class="space">
                        <Input v-model="editdata.fullName" placeholder="Full Name" />
                    </div>
                    <div class="space">
                        <Input v-model="editdata.email" type="email" placeholder="Email" />
                    </div>
                    <div class="space">
                        <Input v-model="editdata.password" type="password" placeholder="Password" />
                    </div>
                    <div class="space">
                        <Input v-model="editdata.contact"  placeholder="Contact" />
                    </div>
                    <div class="space">
                        <Input v-model="editdata.job_title" placeholder="Job Title" />
                    </div>
                    <div class="space">
                      <Select class="space" v-model="editdata.type" id="type2">
                            <Option v-for="item in typeOptions2" :value="item.value" :key="item.value">{{ item.label }}</Option>
                        </Select>
                    </div>
                    <div slot="footer">
                        <Button type="default" @click="editModel=false">Cancel</Button>
                        <Button type="primary" @click="editEmployee()" :disabled="isAdding" :loading="isAdding">
                            {{ isAdding ? 'Editing..' : 'Edit Employee'}}
                        </Button>
                    </div>
                </Modal>

                <!--~~~~~~~ Delete modal ~~~~~~~~~-->
                <Modal v-model="deleteModel" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Are you sure you want to delete tag.</p>
                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteEmployee()">
                            Delete
                        </Button>
                    </div>
                </Modal>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
          return {
                theme3: 'dark',
                columns1: [
                    {
                        type: 'index',
                        width: 60,
                        align: 'center'
                    },
                    {
                        title: 'Name',
                        key: 'fullName'
                    },
                    {
                        title: 'Email',
                        key: 'email'
                    },
                    {
                        title: 'Contact',
                        key: 'contact'
                    },
                    {
                        title: 'Job Title',
                        key: 'job_title'
                    },
                    {

                        title: 'Action',
                        slot: 'action',
                        width: 150,
                        align: 'center'

                    },
                ],
                data1: [],
              typeOptions:[
                { value: 'employee', label:'Employees'},
                { value: 'admin', label:'Admins'},
              ],
              typeOptions2:[
                  { value: 'admin', label:'Admin'},
                { value: 'employee', label:'Employee'},
              ],
              data : {
                fullName : '',
                email : '',
                password : '',
                contact:'',
                job_title:'',
                type:'employee',
              },
              type:'employee',
              addModel : false,
              editModel : false,
              editdata :{
                id:'',
                fullName : '',
                email : '',
                password : '',
                contact:'',
                job_title:'',
                type:'',
              },
              isAdding :false,
              userType:[],
              allEmployees:[],
              index:-1,
              deleteModel:false,
              deleteItem : {
              },
              deleteIndex:-1,
              isDeleting : false,
              token : ''
          }
        }, //end DATA

        methods:{
            async addEmployee(){
                if(this.data.fullName.trim()=='') return this.e('Full name is required')
                if(this.data.email.trim()=='') return this.e('Email is required')
                if(this.data.password.trim()=='') return this.e('Password is required')
                // if(this.data.contact.trim()=='') return this.e('Contact is required')
                // if(!this.data.job_title) return this.e('Job Title  is required')

                this.isAdding=true
                const  res = await this.callApi('post','app/addEmployee',this.data)
                if(res.status===201){
                    this.allEmployees.unshift(res.data)
                    this.s('Employee added successfully!');
                    this.addModel=false
                    this.data.fullName=''
                    this.data.email=''
                    this.data.type=''
                    this.data.password=''
                    this.data.contact=''
                    this.data.job_title=''
                }else{
                    if(res.status==422){
                        for(let i in res.data.errors){
                            this.e(res.data.errors[i][0])
                        }
                    }else{
                        this.swr();
                    }
                }
                this.isAdding=false
            }, //end ASYNC ADDMPLOYEE

            async editEmployee(){
                if(this.editdata.fullName.trim()=='') return this.e('Full name is required')
                if(this.editdata.email.trim()=='') return this.e('Email is required')
                // if(this.editdata.contact.trim()=='') return this.e('Contact is required')
                // if(!this.editdata.job_title) return this.e('Job Title  is required')
                const  res = await this.callApi('post','app/editEmployee',this.editdata)
                if(res.status===200){
                    this.setData(res);
                    this.s('Category updated successfully!')
                    this.editModel=false
                }else{
                    if(res.status==422){
                        for(let i in res.data.errors){
                            this.e(res.data.errors[i][0])
                        }
                    }else{
                        this.swr();
                    }
                }
            }, //end ASYNC EDITEMPLOYEE

            showEditModel(employee,i){
                let obj={
                    fullName:employee.fullName,
                    email : employee.email,
                    password : '******',
                    contact : employee.contact,
                    job_title : employee.job_title,
                    id : employee.id,
                    type:'admin'
                }
                console.log(obj)
                this.editdata=obj;
                this.editModel=true;
                this.index=i;
            }, //end SHOWEDITMODEL

            async  deleteEmployee(){
                //   if(!confirm('Are you sure you want to delete this tag !'))  return
                // this.$set(tag,'isDeleting',true)
                this.isDeleting=true
                const res=await this.callApi('post','app/deleteEmployee',this.deleteItem)
                if(res.status==200){
                    this.employees.splice(this.deleteIndex,1);
                    this.s('Employee deleted successfully! ')
                    this.isDeleting=false
                    this.deleteModel=false
                }else{
                    this.swr();
                }
            }, //end async DELETEEMPLOYEE

            showDeleteModel(employee,i){
                this.deleteItem=employee
                this.deleteIndex=i;
                this.deleteModel=true
            }, //end showDeleteModel

            handleSuccess (res, file) {
                this.data.iconImage = res
            }, //end HANDLESUCCESS

            handleEditSuccess(res, file){
                this.editdata.iconImage = res
            }, //end HANDLEEDITSUCCESS

            handleError(res,file){
                let description='';
                if(file.errors.file.length>0){
                    description=file.errors.file[0]
                }else{
                    description='Something went wrong!'
                }
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc:  description
                });
            }, //end HANDLEERROR

            handleFormatError (file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
            }, //end HANDLEFORMATERROR

            handleMaxSize (file) {
                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File  ' + file.name + ' is too large, no more than 2M.'
                });
            }, //end HANDLEMAXSIZE

            async deleteImage(){
                let img=this.data.iconImage
                this.data.iconImage=''
                const res=await this.callApi('post','/app/deleteImage',{image : img})
                if(res.status!=200){
                    this.data.iconImage=img
                    this.swr()
                }
            }, //end DELETEIMAGE

            async deleteEditImage(){
                let img=this.editdata.iconImage
                this.editdata.iconImage=''
                const res=await this.callApi('post','/app/deleteImage',{image : img})
                if(res.status!=200){
                    this.data.iconImage=img
                    this.swr()
                }
            }, //end DELETEEDITIMAGE

            onChangeUserType:function(event){
                this.data.type=event;
                this.userType= this.allEmployees.filter((x)=>{
                    return x.userType == event;})
            }, //end ONCHANGEUSERTYPE
            setData(res){
                this.allEmployees = res.data;
                this.userType= res.data.filter(x=>x.userType==this.data.type);
            }
        },  //end METHODS

        async created(){
            this.token=window.laravel.csrfToken
            this.$Progress.start()
            const  res = await this.callApi('get','app/getEmployees')
            if(res.status===200){
                this.setData(res);
                this.$Progress.finish()
            }else{
                this.swr();
                this.$Progress.fail()
            }
        }, //end CREATED

//         mounted:{
//             // ()=>{
// //
//                 // this.data.userType =
//             // }
//         }
    }
</script>
<style   scoped>
    ._title0 .ivu-select {
        width: 14%;
    }
</style>
