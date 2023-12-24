<template>
	<div>
		<h2>Client Management</h2>
		<alert v-if="alert.show" :message="alert.message" :success="alert.success" :error="alert.error" class="absolute top-10 right-0 m-4"></alert>
		 <!-- Search bar -->
		 <div class="py-3 mb-4 rounded-lg shadow-md">
	    <input type="text" v-model="keyword" placeholder="Search Clients" class="w-full px-6 py-6 rounded-lg border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-black">
	  </div>

	  <!-- List of clients -->
	  <div class="flex-grow overflow-auto">
	    <ul class="px-4 py-2">
	      <li v-for="client in clients" @click="selected(client.id, client.name, client.email, client.card_id, client.address, client.phone_number, client.status)" class="flex justify-between items-center px-4 py-3 mb-4 rounded-lg shadow-md" :class="{ 'bg-red-200': client.status == 0 }">
	        <div class="flex-1 mr-4">
	          <h2 class="text-lg font-medium">{{ client.name }}</h2>
	          <p class="text-gray-500">{{ client.card_id }}</p>
	        </div>
	      </li>
	    </ul>
	  </div>
		<form>
      <div class="py-3 mb-4 rounded-lg shadow-md">
        <input v-model="client.name" class="appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" name="name" placeholder="Full Name">
      </div>
      <div class="py-3 mb-4 rounded-lg shadow-md">
        <input v-model="client.email" class="appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline" id="email" type="text" name="email" placeholder="Email">
      </div>
      <div class="py-3 mb-4 rounded-lg shadow-md">
    		<label class="inline-flex items-center w-full">
          <input v-model="client.card_id" type="text" class="appearance-none border rounded text-black leading-tight focus:outline-none focus:shadow-outline w-4/5" placeholder="Card Id">
          <button @click.prevent="generateCardId" class="bg-blue-500 text-white ml-5 py-2 px-4 rounded w-1/5">Generate Card Number</button>
        </label>
      </div>
      <div class="py-3 mb-4 rounded-lg shadow-md">
        <input v-model="client.address" class="appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline" id="address" type="text" name="address" placeholder="Address">
      </div>
      <div class="py-3 mb-4 rounded-lg shadow-md">
        <input v-model="client.phone_number" class="appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline" id="phone" type="text" name="phone" placeholder="Phone Number +254">
      </div>
      <div class="py-3 mb-4 rounded-lg shadow-md">
        <label class="inline-flex items-center px-5">
          <input v-model="client.status" true-value=1 false-value=0 type="checkbox" class="form-checkbox h-5 w-5 text-green-600">
          <span class="ml-2 text-gray-700">User Payment</span>
        </label>
      </div>
      <div class="flex justify-center py-4">
		    <button 
		      class="bg-green-500 text-white hover:bg-green-400 font-bold py-2 px-4 rounded mr-2 w-full"
		      @click.prevent="save"
		    >
		      Save
		    </button>
		    <button 
		      class="bg-blue-500 text-white hover:bg-blue-400 font-bold py-2 px-4 rounded mr-2 w-full"
		      @click.prevent="edit"
		    >
		      Edit
		    </button>
		    <button 
		      class="bg-red-500 text-white hover:bg-red-400 font-bold py-2 px-4 rounded w-full"
		      @click.prevent="destroy"
		    >
		      Delete
		    </button>
		  </div>
    </form>

    <hr class="p-8">

   

	</div>
</template>


<script>
import Alert from './Alert.vue';

export default {
	data() {
		return {
			alert: {
				show: false,
				message: '',
				success: false,
				error: false,
			},
			client: {
				id: null,
				name: null,
				email: null,
				card_id: null,
				address: null,
				phone_number: null,
				status: null,
			},
			clients: [],
			keyword: null,
		};
	},
	mounted() {

	},
	watch: {
		keyword(after, before) {
			this.clientSearch();
		}
	},
	methods: {
		showAlert(message, status) {
			this.alert.show = true;
			this.alert.message = message;
			if (status === true) {
				this.alert.success = true;
			} else {
				this.alert.error = true;
			}

			setTimeout(() => {
				this.alert.show = false;
      	this.alert.message = null;
        this.alert.success = false;
				this.alert.error = false;
      }, 3000);
		},
		clearForm() {
			var self = this;
			self.client.id = null;
			self.client.name = null;
			self.client.email = null;
			self.client.card_id = null;
			self.client.address = null;
			self.client.phone_number = null;
			self.client.status = null;
		},
		generateCardId() {
			const cardId = Array.from({ length: 16 }, () => Math.floor(Math.random() * 10)).join('');
      this.client.card_id = cardId;
		},
		save() {
			var self = this;
			const data = {
				name: self.client.name,
				email: self.client.email,
				card_id: self.client.card_id,
				address: self.client.address,
				phone_number: self.client.phone_number,
				status: self.client.status,
			}

			axios.post('/clients', data)
				.then(function(response) {
					self.showAlert(response.data, true);
					self.clearForm();
				})
				.catch(function (error) {
					self.showAlert(error.response.data.message, false);
			  });
		},
		selected(id, name, email, card_id, address, phone_number, status) {
			this.client.id = id;
			this.client.name = name;
			this.client.email = email;
			this.client.card_id = card_id;
			this.client.address = address;
			this.client.phone_number = phone_number;
			this.client.status = status;
		},
		edit() {
			var self = this;
			const data = { 
				name: self.client.name,
				email: self.client.email,
				card_id: self.client.card_id,
				address: self.client.address,
				phone_number: self.client.phone_number,
				status: self.client.status,
			}

			axios.put(`/clients/${self.client.id}`, data)
				.then(function(response) {
					self.showAlert(response.data, true);
					self.clearForm();
				})
				.catch(function (error) {
					self.showAlert(error.response.data.message, false);
			  });
		},
		destroy() {
			var self = this;
			console.log('Client id to delete: ' + self.client.id);

			axios.delete(`/clients/${self.client.id}`)
				.then(function(response) {
					self.showAlert(response.data, true);
					self.clearForm();
				})
				.catch(function (error) {
					self.showAlert(error.response.data.message, false);
			  });
		},
		clientSearch() {
			var self = this;
			const data = { keyword: self.keyword }

			axios.post('/clients/search', data)
				.then(function(response) {
						self.clients = response.data;
				});
		},
	}
}
</script>