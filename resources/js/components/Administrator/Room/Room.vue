<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="columns">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">LIST OF ROOMS</div>

                        <div class="level">
                            <div class="level-left">
                                <b-field label="Page">
                                    <b-select v-model="perPage" @input="setPerPage">
                                        <option value="5">5 per page</option>
                                        <option value="10">10 per page</option>
                                        <option value="15">15 per page</option>
                                        <option value="20">20 per page</option>
                                    </b-select>
                                    <b-select v-model="sortOrder" @input="loadAsyncData">
                                        <option value="asc">ASC</option>
                                        <option value="desc">DESC</option>

                                    </b-select>
                                </b-field>
                            </div>

                            <div class="level-right">
                                <div class="level-item">
                                    <b-field label="Search">
                                        <b-input type="text"
                                                 v-model="search.room" placeholder="Search Room"
                                                 @keyup.native.enter="loadAsyncData"/>
                                        <p class="control">
                                             <b-tooltip label="Search" type="is-success">
                                            <b-button type="is-primary" icon-right="account-filter" @click="loadAsyncData"/>
                                             </b-tooltip>
                                        </p>
                                    </b-field>
                                </div>
                            </div>
                        </div>


                        <b-table
                            :data="data"
                            :loading="loading"
                            paginated
                            backend-pagination
                            :total="total"
                            :per-page="perPage"
                            @page-change="onPageChange"
                            aria-next-label="Next page"
                            aria-previous-label="Previous page"
                            aria-page-label="Page"
                            aria-current-label="Current page"
                            backend-sorting
                            :default-sort-direction="defaultSortDirection"
                            @sort="onSort">

                            <b-table-column field="floor_id" label="ID" v-slot="props">
                                {{ props.row.floor_id }}
                            </b-table-column>

                            <b-table-column field="building" label="Building Name" v-slot="props">
                                {{ props.row.building.building_name }}
                            </b-table-column>

                            <b-table-column field="floor_name" label="Floor Name" v-slot="props">
                                {{ props.row.floor.floor_name }}
                            </b-table-column>

                            <b-table-column field="room" label="Room" v-slot="props">
                                {{ props.row.room }}
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small is-warning mr-1" tag="a" icon-right="pencil" @click="getData(props.row.room_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small is-danger mr-1" icon-right="delete" @click="confirmDelete(props.row.room_id)"></b-button>
                                    </b-tooltip>
                                </div>
                            </b-table-column>

                        </b-table>

                        <div class="buttons mt-3">
                            <b-button @click="openModal" icon-right="account-arrow-up-outline" class="is-success">NEW</b-button>
                        </div>

                    </div>
                </div><!--close column-->
            </div>


        </div><!--section div-->



        <!--modal create-->
        <b-modal v-model="isModalCreate" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal
                 type = "is-link">

            <form @submit.prevent="submit">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Room Information</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false" />
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">

                                    <b-field label="Building" expanded
                                             :type="this.errors.building ? 'is-danger':''"
                                             :message="this.errors.building ? this.errors.building[0] : ''">
                                        <b-select v-model="fields.building" placeholder="Building" required expanded>
                                            <option v-for="(item, index) in buildings" :key="index" :value="item.building_id">{{ item.building_name }}</option>
                                        </b-select>
                                    </b-field>

                                    <b-field label="Floor" expanded
                                             :type="this.errors.floor ? 'is-danger':''"
                                             :message="this.errors.floor ? this.errors.floor[0] : ''">
                                        <b-select v-model="fields.floor" placeholder="Building" required expanded>
                                            <option v-for="(item, index) in floors" :key="index" :value="item.floor_id">{{ item.floor_name }}</option>
                                        </b-select>
                                    </b-field>


                                    <b-field label="Room"
                                             :type="this.errors.room ? 'is-danger':''"
                                             :message="this.errors.room ? this.errors.room[0] : ''">
                                        <b-input v-model="fields.room"
                                                 placeholder="Room" required>
                                        </b-input>
                                    </b-field>

                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="isModalCreate=false"/>
                        <button
                            :class="btnClass"
                            label="Save"
                            type="is-success">SAVE</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->


    </div>
</template>

<script>


export default {


    data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'room_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',

            global_id : 0,

            search: {
                room: '',
            },

            isModalCreate: false,

            fields: {
                floor_name : null
            },
            errors: {},

            buildings: [],
            floors: [],

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
                `room=${this.search.room}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-rooms?${params}`)
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

        openModal(){
            this.isModalCreate=true;
            this.clearFields();
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
            axios.delete('/rooms/' + delete_id).then(res => {
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

            axios.get('/rooms/'+data_id).then(res=>{
                this.fields = res.data;
                
                this.fields.building = res.data.building.building_id;
                this.fields.floor = res.data.floor.floor_id;

            });
        },

        clearFields(){
            this.fields = {
                floor_name : null,
            };
        },


        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/rooms/'+this.global_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                                this.isModalCreate = false;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                })
            }else{
                //INSERT HERE
                axios.post('/rooms', this.fields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.isModalCreate = false;
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                            }
                        })
                    }
                }).catch(err=>{
                    if(err.response.status === 422){
                        this.errors = err.response.data.errors;
                    }
                });
            }
        },

        loadOpenBuildings(){
            axios.get('/load-buildings').then(res=>{
                this.buildings = res.data;
            })
        },
        loadOpenFloors(){
             axios.get('/load-floors').then(res=>{
                this.floors = res.data;
            })
        }


      

    },

    mounted() {
        this.loadAsyncData();
        this.loadOpenBuildings();
        this.loadOpenFloors();

    }

}
</script>

<style scoped>

</style>
