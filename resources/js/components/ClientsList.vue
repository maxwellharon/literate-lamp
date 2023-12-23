<template>
	<div class="flex flex-col h-screen">
	  <!-- Search bar -->
	  <div class="py-3 mb-4 rounded-lg shadow-md">
	    <input type="text" v-model="keyword" placeholder="Search Clients" class="w-full px-6 py-6 rounded-lg border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-black">
	  </div>

	  <!-- List of books -->
	  <div class="flex-grow overflow-auto">
	    <ul class="px-4 py-2">
	      <li v-for="client in clients" class="flex justify-between items-center px-4 py-3 mb-4 rounded-lg shadow-md" :class="{ 'bg-red-200': client.status == 0 }">
	        <div class="flex-1 mr-4">
	          <h2 class="text-lg font-medium">{{ client.name }}</h2>
	          <p class="text-gray-500">{{ client.card_id }}</p>
	        </div>
	      </li>
	    </ul>
	  </div>
	</div>
</template>


<script>
export default {
	data() {
		return {
			clients: [],
			keyword: null,
		};
	},
	mounted() {
		this.clientsList();
	},
	watch: {
		keyword(after, before) {
			this.clientsSearch();
		}
	},
	methods: {
		clientsList() {
			var self = this;

			axios.get('/clients')
				.then(function(response) {
					self.clients = response.data;
				})
		},
		clientsSearch() {
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