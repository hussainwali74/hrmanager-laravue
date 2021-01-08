<template>
    <div>
        <div class="content">
            <div class="container">
                <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                    <p class="_title0">Tags
                        <Button type="default" @click="addModel=true"><Icon type="ios-add" /> Add Tag</Button>
                    </p>
                    <div class="_overflow _table_div">
                        <table class="_table">
                            <!-- TABLE TITLE -->
                            <tr>
                                <th>Id</th>
                                <th>Tag</th>
                                <th>Created at</th>
                                <th>Action</th>
                            </tr>
                            <!-- TABLE TITLE -->

                            <!-- ITEMS -->
                            <tr  v-for="(tag,i) in tags" :key="i" v-if="tags.length">
                                <td>{{tag.id}}</td>
                                <td>{{tag.tagName}}</td>
                                <td>{{tag.created_at}}</td>
                                <td>
                                    <Button type="info" @click="showEditModel(tag,i)" size="small">Edit</Button>
                                    <Button type="error" size="small" @click="showDeleteModel(tag,i)" :loading="tag.isDeleting">Delete</Button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <Modal
                    v-model="addModel"
                    title="Create Tag"
                    :mask-closable = "false"
                    :closable = "false"
                >
                    <Input v-model="data.tagName" placeholder="Add Tag Name" />
                    <div slot="footer">
                        <Button type="default" @click="addModel=false">Cancel</Button>
                        <Button type="primary" @click="addTag()" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Adding..' : 'Add tag'}}</Button>

                    </div>
                </Modal>

                <!--Edit model-->
                <Modal
                    v-model="editModel"
                    title="Edit Tag"
                    :mask-closable = "false"
                    :closable = "false"
                >
                    <Input v-model="editdata.tagName" placeholder="Edit Tag Name" />
                    <div slot="footer">
                        <Button type="default" @click="editModel=false">Cancel</Button>
                        <Button type="primary" @click="editTag()" :disabled="isAdding" :loading="isAdding">{{ isAdding ? 'Editing..' : 'Edit tag'}}</Button>
                    </div>
                </Modal>

                <!--delete alert model-->
                <Modal v-model="deleteModel" width="360">
                    <p slot="header" style="color:#f60;text-align:center">
                        <Icon type="ios-information-circle"></Icon>
                        <span>Delete confirmation</span>
                    </p>
                    <div style="text-align:center">
                        <p>Are you sure you want to delete tag.</p>
                        <p>Will you delete it?</p>
                    </div>
                    <div slot="footer">
                        <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag()">Delete</Button>
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
              data : {
                  tagName : ''
              },
              addModel : false,
              editModel : false,
              editdata :{
                tagName : ''
              },
              isAdding :false,
              tags:[],
              index:-1,
              deleteModel:false,
              deleteItem : {
              },
              deleteIndex:-1,
              isDeleting : false
          }
        },

        methods:{
            async addTag(){
                if(this.data.tagName.trim()=='') return this.e('Tag name is required !')
                const  res = await this.callApi('post','app/addTag',this.data)
                if(res.status===201){
                    this.tags.unshift(res.data)
                    this.s('Tag added successfully!');
                    this.addModel=false
                    this.data.tagName=''
                }else{
                    if(res.status==422){
                        if(res.data.errors.tagName){
                            this.e(res.data.errors.tagName[0])
                        }
                    }else{
                        this.swr();
                    }
                }
            },
            async editTag(){
                if(this.editdata.tagName.trim()=='') return this.e('Tag name is required !')
                const  res = await this.callApi('post','app/editTag',this.editdata)
                if(res.status===201){
                    this.tags[this.index].tagName=this.editdata.tagName
                    this.s('Tag updated successfully!')
                    this.editModel=false
                }else{
                    if(res.status==422){
                        if(res.data.errors.tagName){
                            this.e(res.data.errors.tagName[0])
                        }
                    }else{
                        this.swr();
                    }
                }
            },
            showEditModel(tag,i){
                let obj={
                    id:tag.id,
                    tagName:tag.tagName
                }
                this.editdata=obj;
                this.editModel=true;
                this.index=i;
            },
            async  deleteTag(){
                //   if(!confirm('Are you sure you want to delete this tag !'))  return
                // this.$set(tag,'isDeleting',true)
                this.isDeleting=true
                const res=await this.callApi('post','app/deleteTag',this.deleteItem)
                if(res.status==200){
                    this.tags.splice(this.deleteIndex,1);
                    this.s('Tag deleted successfully! ')
                    this.isDeleting=false
                    this.deleteModel=false
                }else{
                    this.swr();
                }
            },

            showDeleteModel(tag,i){
                this.deleteItem=tag
                this.deleteIndex=i;
                this.deleteModel=true
            }
        },
        async created(){
            this.$Progress.start()
            const  res = await this.callApi('get','app/getTag')
            if(res.status===200){
                this.tags=res.data
                this.$Progress.finish()
            }else{
                this.swr();
            }
        }
    }
</script>
