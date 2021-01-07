export default {
    data(){
        return {

        }
    },

    methods:{

       async callApi(method,url,dataObj){
            try{

              return await axios({
                    method: method,
                    url: url,
                    data: dataObj,

                });

            }catch(e){

                return e.response

            }

        },
        i (title="Hey",desc) {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        s (title="Great!",desc) {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        w (title="OOPS!",desc) {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        e (title="OOPS!",desc) {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },
        swr (title="OOPS!",desc="Something went wrong!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        }

    }
}

