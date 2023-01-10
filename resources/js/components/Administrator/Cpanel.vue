<template>
	<div>

		<div class="section">


			<div class="building-container">
				<div class="building" v-for="(item, index) in buildings" :key="index">
					<div class="box" v-if="item.devices.length > 0">
						<div class="box-head">
							{{ item.building_name }}
						</div>
						
						<div v-for="(i, ix) in item.devices" :key="ix">
							<hr>
							<div>{{ i.floor_name }}</div>
							<b-field :label="i.device_name">
								<b-switch
									@input="invokeSwitch($event, item, i)" :id="`switch${item.building_id}${i.device_id}`" 
									v-model="i.s"
									type="is-success">
									{{ i.room }}
								</b-switch>
							</b-field>
							<div class="offline" :id="`status${item.building_id}${i.device_id}`">OFFLINE</div>
							
						</div>
					</div>
				</div>
			
			</div><!--building-container-->

			
		</div>

	</div>
</template>

<script>
import axios from 'axios'




export default {
	
	data(){
		return{
			mark: 'OFF',
			buildings: [],

			checkBoxes: {},

			checkValue: {},

			switchValue: null,

		}
		
	},
	methods: {
		switch1: function(){
			axios.post('/').then(res=>{
			})
		},
	
		invokeSwitch(evt, building, data){
			let token = '';

			let status = document.getElementById(`status${building.building_id}${data.device_id}`);


			if(evt){
				token = data.device_token_on;
				status.innerHTML = 'ONLINE';
				axios.get('/switch-log?url=' + data.device_ip + '&token=' + token + '&status=ON')
				status.className = 'online';
			}else{
				token = data.device_token_off;
				axios.get('/switch-log?url=' + data.device_ip + '&token=' + token + '&status=OFF')
				status.innerHTML = 'OFFLINE';
				status.className = 'offline';
			}

			fetch(`http://${data.device_ip}/${token}`).then(res=>{
				console.log(res)
			});
			//axios.get('/test-switch')
			
		},

		initData(){
			axios.get('/load-switch-buildings').then(res=>{
				this.buildings = res.data;
			})

		},

		getNotifications(){
			//dere ang codes
			this.buildings.forEach(d => {
				//foreach devices
				d.devices.forEach(el =>{
					let checkboxes = document.getElementById(`switch${d.building_id}${el.device_id}`).querySelector('input[type=checkbox]');
					let status = document.getElementById(`status${d.building_id}${el.device_id}`);

					axios.get(`http://${el.device_ip}`).then(res=>{
						console.log(res.data);
						if(res.data === 'ON'){
							checkboxes.checked = true;
							status.innerHTML = 'ONLINE';
							status.className = 'online';

						}else{
							checkboxes.checked = false;
							status.innerHTML = 'OFFLINE';
							status.className = 'offline';
						}
					})
				});
			});
			
		},

	
	},

	created(){
		

	},

	mounted(){
		this.initData();
		// window.setInterval(() => {
		// 	this.getNotifications()
		// }, 15000);



		//this.test();
		
	}
}
</script>

<style scoped>
	.box-head{
		font-size: 1.5em;
		font-weight: bold;
		margin: 0 0 25px 0;
	}

	.box{
		padding-bottom: 25px;
		margin: 15px;
	}

	.building-container{
		display: flex;
		justify-content: center;
	}

	.building{
		width: 300px;
	}

	@media only screen and (max-width: 600px) {
		.building-container{
			flex-direction: column;
			justify-content: center;
			align-items: center;
		}
	}

	.online{
		font-weight: bold;
		color: green;
	}
	.offline{
		font-weight: bold;
		color: red;
	}
</style>
