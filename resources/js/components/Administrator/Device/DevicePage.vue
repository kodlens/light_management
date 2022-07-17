<template>
    <div>
        <div class="section">

            <div class="columns is-centered">
                <div class="columns">
                    <div class="box">
                        <div class="is-flex is-justify-content-center mb-2" style="font-size: 20px; font-weight: bold;">LIST OF DEVICES</div>

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
                                                 v-model="search.device" placeholder="Search Device"
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

                            <b-table-column field="device_id" label="ID" v-slot="props">
                                {{ props.row.device_id }}
                            </b-table-column>

                            <b-table-column field="building" label="Building Name" v-slot="props">
                                {{ props.row.room.building_name }}
                            </b-table-column>

                            <b-table-column field="floor" label="Floor Name" v-slot="props">
                                {{ props.row.room.floor_name }}
                            </b-table-column>

                             <b-table-column field="room" label="Room" v-slot="props">
                                {{ props.row.room.room }}
                            </b-table-column>

                            <b-table-column field="device_name" label="Device Name" v-slot="props">
                                {{ props.row.device_name }}
                            </b-table-column>

                            <b-table-column field="device_ip" label="Device IP" v-slot="props">
                                {{ props.row.device_ip }}
                            </b-table-column>

                            <b-table-column field="device_token_on" label="Device Token ON" v-slot="props">
                                {{ props.row.device_token_on | truncate(10) }}
                            </b-table-column>

                            <b-table-column field="device_token_off" label="Device Token OFF" v-slot="props">
                                {{ props.row.device_token_off | truncate(10) }}
                            </b-table-column>

                            <b-table-column label="Action" v-slot="props">
                                <div class="is-flex">
                                    <b-tooltip label="Edit" type="is-warning">
                                        <b-button class="button is-small is-warning mr-1" tag="a" icon-right="pencil" @click="getData(props.row.device_id)"></b-button>
                                    </b-tooltip>
                                    <b-tooltip label="Delete" type="is-danger">
                                        <b-button class="button is-small is-danger mr-1" icon-right="delete" @click="confirmDelete(props.row.device_id)"></b-button>
                                    </b-tooltip>
                                     <b-tooltip label="Access Role" type="is-info">
                                        <b-button class="button is-small is-info mr-1" icon-right="account-key-outline" @click="openModalAccessRole(props.row.device_id)"></b-button>
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
                        <p class="modal-card-title">Office Information</p>
                        <button
                            type="button"
                            class="delete"
                            @click="isModalCreate = false" />
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">

                                    <b-field label="Room" expanded
                                             :type="this.errors.room ? 'is-danger':''"
                                             :message="this.errors.room ? this.errors.room[0] : ''">
                                        <b-select v-model="fields.room" expanded
                                                placeholder="Room" required>
                                                <option v-for="(item, index) in rooms" :key="index" :value="item.room_id">{{ item.room }}</option>
                                        </b-select>
                                    </b-field>

                                    <b-field label="Device Name"
                                             :type="this.errors.device_name ? 'is-danger':''"
                                             :message="this.errors.device_name ? this.errors.device_name[0] : ''">
                                        <b-input v-model="fields.device_name"
                                                 placeholder="Device Name" required>
                                        </b-input>
                                    </b-field>

                                    <b-field label="Device IP"
                                             :type="this.errors.device_ip ? 'is-danger':''"
                                             :message="this.errors.device_ip ? this.errors.device_ip[0] : ''">
                                        <b-input v-model="fields.device_ip"
                                                 placeholder="Device IP" required>
                                        </b-input>
                                    </b-field>

                                    <b-field label="Device Token ON" expanded
                                             :type="this.errors.device_token_on ? 'is-danger':''"
                                             :message="this.errors.device_token_on ? this.errors.device_token_on[0] : ''">
                                        <b-input v-model="fields.device_token_on" expanded
                                                 placeholder="Device Token" required>
                                        </b-input>
                                        <p class="control">
                                            <b-button type="is-info" label="..." @click="makeTokenOn"></b-button>
                                        </p>
                                    </b-field>

                                    <b-field label="Device Token OFF" expanded
                                             :type="this.errors.device_token_off ? 'is-danger':''"
                                             :message="this.errors.device_token_off ? this.errors.device_token_off[0] : ''">
                                        <b-input v-model="fields.device_token_off" expanded
                                                 placeholder="Device Token" required>
                                        </b-input>
                                        <p class="control">
                                            <b-button type="is-info" label="..." @click="makeTokenOff"></b-button>
                                        </p>
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



        <!--modal create-->
        <b-modal v-model="modalAccessRole" has-modal-card
                 trap-focus
                 :width="640"
                 aria-role="dialog"
                 aria-label="Modal"
                 aria-modal
                 type = "is-link">

            <form @submit.prevent="submitAccessRole">
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Set Access Role</p>
                        <button
                            type="button"
                            class="delete"
                            @click="modalAccessRole = false" />
                    </header>

                    <section class="modal-card-body">
                        <div class="">
                            <div class="columns">
                                <div class="column">

                                    <b-field label="Group Role" class="mb-4">
                                        <b-taginput
                                            v-model="accessfields.tags"
                                            :data="filterTags"
                                            autocomplete
                                            field="group_role_name"
                                            icon="label"
                                            placeholder="Add a access role"
                                            type="is-info"
                                            @remove="removeAccessRole"
                                            :open-on-focus="true"
                                            @typing="getFilteredTags">
                                            <template v-slot="props">
                                                <strong>{{props.option.group_role_id}}</strong>: {{props.option.group_role_name}}
                                            </template>
                                            <template #empty>
                                                There are no items
                                            </template>
                                        </b-taginput>
                                    </b-field>

                                </div>
                            </div>
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <b-button
                            label="Close"
                            @click="modalAccessRole=false"/>
                        <button
                            :class="btnClass"
                            type="is-success">SAVE</button>
                    </footer>
                </div>
            </form><!--close form-->
        </b-modal>
        <!--close modal-->



    </div>
</template>

<script>

 import MD5 from "crypto-js/md5";

export default {

    components: {
        MD5
    },

    data(){
        return{
            data: [],
            total: 0,
            loading: false,
            sortField: 'device_id',
            sortOrder: 'desc',
            page: 1,
            perPage: 5,
            defaultSortDirection: 'asc',

            global_id : 0,

            search: {
                device: '',
            },

            isModalCreate: false,
            modalAccessRole: false,

            fields: {
                device_name : null,
                device_ip: null,
                device_token_on: null,
                device_token_off: null,
            },
            errors: {},

            accessfields: {
                device_id: 0,
                tags: [],
            },

            btnClass: {
                'is-success': true,
                'button': true,
                'is-loading':false,
            },

      
            rooms: [],

            group_roles: [],

            filterTags: [],
            tags: [],

            device_accesses: [],

        }
    },

    methods: {
        /*
        * Load async data
        */
        loadAsyncData() {
            const params = [
                `sort_by=${this.sortField}.${this.sortOrder}`,
                `device=${this.search.device}`,
                `perpage=${this.perPage}`,
                `page=${this.page}`
            ].join('&')

            this.loading = true
            axios.get(`/get-devices?${params}`)
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
            axios.delete('/devices/' + delete_id).then(res => {
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
            axios.get('/devices/'+data_id).then(res=>{
                this.fields = res.data;
                this.fields.room = res.data.room.room_id;

            });
        },

        clearFields(){
            this.fields = {
                device_name : null,
                device_ip: null,
                device_token_on: null,
                device_token_off: null,

            };
        },


        submit: function(){
            if(this.global_id > 0){
                //update
                axios.put('/devices/'+this.global_id, this.fields).then(res=>{
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
                axios.post('/devices', this.fields).then(res=>{
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


        makeTokenOn: function(){
            let myhash = MD5(new Date().toLocaleDateString() + new Date().toLocaleTimeString());
            this.fields.device_token_on = myhash.toString();
        },

        makeTokenOff: function(){
            let myhash = MD5(new Date().toLocaleDateString() + new Date().toLocaleTimeString());
            this.fields.device_token_off = myhash.toString();
        },

        loadBuildings(){
            axios.get('/load-open-rooms').then(res=>{
                this.rooms = res.data;
            })
        },


        openModalAccessRole(dataId){
            this.modalAccessRole = true;

            this.accessfields = {
                device_id: 0,
                tags: [],
            };


            this.accessfields.device_id = dataId;

            //this.accessfields.tags = {};
            this.getFilteredTags("");
            this.loadAccessRoleIfAny(dataId);
        },

        loadAccessRoleIfAny(dataId){
            this.device_accesses = [];
            axios.get('/load-access-role-if-any/'+ dataId).then(res=>{
                this.device_accesses = res.data;
                this.accessfields.tags = this.device_accesses;
            });
        },

        getFilteredTags(text) {
            this.filterTags = this.group_roles.filter((option) => {
                return option.group_role_name
                    .toString()
                    .toLowerCase()
                    .indexOf(text.toLowerCase()) >= 0
            })
        },

        loadGroupRoles(){
            axios.get('/load-open-group-roles').then(res=>{
                this.group_roles = res.data;
            })
        },

        removeAccessRole(i){
            //console.log(i);
            axios.delete('/device-accesses/' + i.device_access_id).then(res=>{
                this.$buefy.toast.open({
                    message: 'Access role removed.',
                    type: 'is-success'
                })
            })
        },

        submitAccessRole: function(){
            if(this.accessfields.device_access_id > 0){
                //update
                axios.put('/device-accesses/'+this.device_access_id, this.fields).then(res=>{
                    if(res.data.status === 'updated'){
                        this.$buefy.dialog.alert({
                            title: 'UPDATED!',
                            message: 'Successfully updated.',
                            type: 'is-success',
                            onConfirm: () => {
                                this.loadAsyncData();
                                this.clearFields();
                                this.global_id = 0;
                                this.modalAccessRole = false;
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
                axios.post('/device-accesses', this.accessfields).then(res=>{
                    if(res.data.status === 'saved'){
                        this.$buefy.dialog.alert({
                            title: 'SAVED!',
                            message: 'Successfully saved.',
                            type: 'is-success',
                            confirmText: 'OK',
                            onConfirm: () => {
                                this.isModalCreate = false;
                                this.loadAsyncData();
                                this.accessfields = {};
                                this.modalAccessRole = false;
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



    },

    mounted() {

        this.loadAsyncData();
        this.loadBuildings();
        this.loadGroupRoles();
       // this.loadFloors();
    }

}
</script>

<style scoped>

</style>
