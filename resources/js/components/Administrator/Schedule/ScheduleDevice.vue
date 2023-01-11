<template>
    <div>
        <div class="section">
            
            
        </div> <!--section-->
   
           
    </div><!--root div-->


</template>

<script>
export default {

    data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'schedule_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',

            locale: undefined, // Browser locale

            global_id : 0,

            search: {
                from_date: '',
                to_date: '',

            },

            isModalCreate: false,

            fields: {},
            errors: {},

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

        }
    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `type=${this.search.appointment_type}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-schedules?${params}`)
                .then(({ data }) => {
                    this.data = [];
                    let currentTotal = data.total
                    if (data.total / this.perPage > 1000) {
                        currentTotal = this.perPage * 1000
                    }

                    this.total = currentTotal
                    data.data.forEach((item) => {
                        //item.release_date = item.release_date ? item.release_date.replace(/-/g, '/') : null
                        this.data.push(item)
                    })
                    this.loading = false
                })
                .catch((error) => {
                    this.data = []
                    this.total = 0
                    this.loading = false
                    throw error
                })
        },
        /*
        * Handle page-change event
        */
        onPageChange(page) {
            this.page = page
            this.loadAsyncData()
        },

        onSort(field, order) {
            this.sortField = field
            this.sortOrder = order
            this.loadAsyncData()
        },

        setPerPage(){
            this.loadAsyncData()
        },


        clearFields(){
            this.fields = {
                appointment_date: null,
                nAppointmentDate: '',
                appointment_type: '',
            };
            this.errors = {};
        },


        //alert box ask for deletion
        confirmDelete(delete_id) {
            this.$buefy.dialog.confirm({
                title: 'DELETE!',
                type: 'is-danger',
                message: 'Are you sure you want to delete this data?',
                cancelText: 'Cancel',
                confirmText: 'Delete',
                onConfirm: () => this.deleteSubmit(delete_id)
            });
        },
        //execute delete after confirming
        deleteSubmit(delete_id) {
            axios.delete('/schedules/' + delete_id).then(res => {
                this.loadAsyncData();
            }).catch(err => {
                if (err.response.status === 422) {
                    this.errors = err.response.data.errors;
                }
            });
        },

        //update code here
        getData: function(data_id){
            this.clearFields();
            this.global_id = data_id;
            this.isModalCreate = true;


            //nested axios for getting the address 1 by 1 or request by request
            axios.get('/schedules/' + data_id).then(res=>{
                // this.fields.training_center = res.data.training_center_id;
                // let dateNTime = res.data.app_date + ' ' + res.data.app_time;
                // this.fields.appointment_date = new Date(dateNTime);
                // this.fields.remarks = res.data.remarks;
                

            });
        },

 

        loadTrainingCenter(){
            axios.get('/get-open-training-centers').then(res=>{
                this.trainingCenters = res.data;
            })
        },

    },

    mounted() {
        this.loadAsyncData();
    }

}
</script>

<style scoped>
    .light-on{
        font-weight: bold;
        color: green;
    }
    .light-off{
        font-weight: bold;
        color: red;
    }

    .pending{
        font-weight: bold;
        color: #1a73bd;
    }
    
</style>
