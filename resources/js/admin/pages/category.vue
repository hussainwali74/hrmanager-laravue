<template>
    <div>
        <div class="content">
            <div class="container">

                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Category
                          <Button type="default" @click="addModel=true"><Icon type="ios-add" /> Add category</Button>


                    </p>

                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Id</th>
                                <th>Category</th>
                                <th>Icon</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->


                            <!-- ITEMS -->
                            <tr  v-for="(category,i) in categories" :key="i" v-if="categories.length">
                                <td>{{category.id}}</td>

                                <td>{{category.categoryName}}</td>

                                <td><img style="width:20%" class="img-fluid img-thumbnail" :src="`/img/${category.iconImage}`" ></td>
                                <td>{{category.created_at}}</td>
                                <td>

                                    <Button type="info" @click="showEditModel(category,i)" size="small">Edit</Button>
                                    <Button type="error" size="small" @click="showDeleteModel(category,i)" :loading="category.isDeleting">Delete</Button>
                                </td>
                            </tr>
                            <!-- ITEMS -->

                            <!-- ITEMS -->

                            <!-- ITEMS -->


                        </table>
                    </div>
                </div>
                <Modal
                    v-model="addModel"
                    title="Create Category"
                    :mask-closable = "false"
                    :closable = "false"
                >
                    <Input v-model="data.categoryName" placeholder="Add Category Name" />

                    <div class="mt-2">
                        <Upload
                            :headers = "{'x-csrf-token': token,'X-Requested-With':'XMLHttpRequest'}"
                            :show-upload-list="false"
                            :on-success="handleSuccess"
                            :on-error="handleError"
                            :format="['jpg','jpeg','png']"
                            :max-size="2048"
                            :on-format-error="handleFormatError"
                            :on-exceeded-size="handleMaxSize"
                            type="drag"
                            action="/app/upload">
                            <div style="padding: 20px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                <p>Click or drag files here to upload</p>
                            </div>
                        </Upload>
                    </div>
                    <div class="demo-upload-list" v-if="data.iconImage">
                        <img :src="`/img/${data.iconImage}`" >
                        <div class="demo-upload-list-cover">
                            <Icon type="ios-trash-outline" @click="deleteImage()"></Icon>
                        </div>
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="addModel=false">Cancel</Button>
                        <Button type="primary" @click="addCategory()" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding..' : 'Add Category'}}</Button>

                    </div>
                </Modal>

<!--                Edit model-->
                <Modal
                    v-model="editModel"
                    title="Edit Tag"
                    :mask-closable = "false"
                    :closable = "false"
                >
                    <Input v-model="editdata.categoryName" placeholder="Edit Category Name" />
                    <div class="mt-2">
                        <Upload
                            :headers = "{'x-csrf-token': token,'X-Requested-With':'XMLHttpRequest'}"
                            :show-upload-list="false"
                            :on-success="handleEditSuccess"
                            :on-error="handleError"
                            :format="['jpg','jpeg','png']"
                            :max-size="2048"
                            :on-format-error="handleFormatError"
                            :on-exceeded-size="handleMaxSize"
                            type="drag"
                            action="/app/upload">
                            <div style="padding: 20px 0">
                                <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                <p>Click or drag files here to upload</p>
                            </div>
                        </Upload>
                    </div>
                    <div class="demo-upload-list" v-if="editdata.iconImage">
                        <img :src="`/img/${editdata.iconImage}`" >
                        <div class="demo-upload-list-cover">
                            <Icon type="ios-trash-outline" @click="deleteEditImage()"></Icon>
                        </div>
                    </div>

                    <div slot="footer">
                        <Button type="default" @click="editModel=false">Cancel</Button>
                        <Button type="primary" @click="editCategory()" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Editing..' : 'Edit tag'}}</Button>

                    </div>
                </Modal>

<!--                   delete alert model-->

                <Modal v-model="deleteModel" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Are you sure you want to delete tag.</p>

                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteCategory()">Delete</Button>
                    </div>
                </Modal>

            </div>
        </div>
    </div>


<!--    Add tag model-->



</template>

<script>
    export default {

        data(){
          return {
              data : {
                  categoryName : '',
                  iconImage : ''

              },
              addModel : false,
              editModel : false,
              editdata :{
                  categoryName : '',
                  iconImage : ''

              },

              isAdding :false,
              categories:[],
              index:-1,
              deleteModel:false,
              deleteItem : {

              },
              deleteIndex:-1,
              isDeleting : false,
              token : ''

          }
        },

        methods:{
                     async addCategory(){

                          if(this.data.categoryName.trim()=='') return this.e('Category name is required !')

                          const  res = await this.callApi('post','app/addCategory',this.data)
                          if(res.status===201){
                             this.categories.unshift(res.data)
                             this.s('Category added successfully!');
                             this.addModel=false
                             this.data.categoryName=''
                             this.data.iconImage=''
                          }else{
                             if(res.status==422){
                                 if(res.data.errors.categoryName){
                                       this.e(res.data.errors.categoryName[0])
                                 }
                             }else{
                                 this.swr();

                             }
                         }

                      },

                     async editCategory(){

                if(this.editdata.categoryName.trim()=='') return this.e('Category name is required!')
                         if(this.editdata.iconImage.trim()=='') return this.e('Image is required!')

                const  res = await this.callApi('post','app/editCategory',this.editdata)
                if(res.status===200){
                      // add new category name in categories array
                    this.categories[this.index].categoryName=this.editdata.categoryName
                    this.categories[this.index].iconImage=this.editdata.iconImage

                    this.s('Category updated successfully!')
                    this.editModel=false
                }else{
                    if(res.status==422){
                        if(res.data.errors.categoryName){
                            this.e(res.data.errors.categoryName[0])
                        }
                        if(res.data.errors.iconImage){
                            this.e(res.data.errors.iconImage[0])
                        }
                    }else{
                        this.swr();

                    }
                }

            },

            showEditModel(category,i){

                let obj={
                             id:category.id,
                             categoryName:category.categoryName,
                             iconImage : category.iconImage
                         }

                         this.editdata=obj;
                         this.editModel=true;
                         this.index=i;

                     },
          async  deleteCategory(){
              //   if(!confirm('Are you sure you want to delete this tag !'))  return
              // this.$set(tag,'isDeleting',true)
              this.isDeleting=true
              const res=await this.callApi('post','app/deleteCategory',this.deleteItem)
              if(res.status==200){
                  this.categories.splice(this.deleteIndex,1);
                  this.s('Category deleted successfully! ')
                  this.isDeleting=false
                  this.deleteModel=false

              }else{
                  this.swr();
              }
            },

            showDeleteModel(category,i){
                this.deleteItem=category
                this.deleteIndex=i;
                this.deleteModel=true
            },
            handleSuccess (res, file) {
                    this.data.iconImage = res

            },
            handleEditSuccess(res, file){
                this.editdata.iconImage = res

            },
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

            },
            handleFormatError (file) {
                this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
                });
            },
            handleMaxSize (file) {
                this.$Notice.warning({
                    title: 'Exceeding file size limit',
                    desc: 'File  ' + file.name + ' is too large, no more than 2M.'
                });
            },

            async deleteImage(){
                let img=this.data.iconImage
                this.data.iconImage=''
                const res=await this.callApi('post','/app/deleteImage',{image : img})
                if(res.status!=200){
                    this.data.iconImage=img
                    this.swr()
                }

            },
            async deleteEditImage(){
                let img=this.editdata.iconImage
                this.editdata.iconImage=''
                const res=await this.callApi('post','/app/deleteImage',{image : img})
                if(res.status!=200){
                    this.data.iconImage=img
                    this.swr()
                }

            }
        },
        async created(){
            this.token=window.laravel.csrfToken
            this.$Progress.start()
            const  res = await this.callApi('get','app/getCategory')

            if(res.status===200){

                console.log(res.data)
                this.categories=res.data
                this.$Progress.finish()

            }else{
                this.swr();
                this.$Progress.fail()
            }

        }
    }
</script>

<style scoped>

</style>
