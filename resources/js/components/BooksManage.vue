<template>
	<div>

		<alert v-if="alert.show" :message="alert.message" :success="alert.success" :error="alert.error" class="absolute top-10 right-0 m-4"></alert>

		<form>
      <div class="py-3 mb-4 rounded-lg shadow-md">
        <input v-model="book.title" class="appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline" id="title" type="text" name="title" placeholder="Enter title">
      </div>
      <div class="py-3 mb-4 rounded-lg shadow-md">
        <input v-model="book.author" class="appearance-none border rounded w-full py-2 px-3 text-black leading-tight focus:outline-none focus:shadow-outline" id="author" type="text" name="author" placeholder="Enter author">
      </div>
      <div class="py-3 mb-4 rounded-lg shadow-md">
        <VueDatePicker v-model="book.published_date" utc placeholder="Pick publishing date"></VueDatePicker>
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

    <!-- Search bar -->
	  <div class="py-3 mb-4 rounded-lg shadow-md">
	    <input type="text" v-model="keyword" placeholder="Search books & authors" class="w-full px-6 py-6 rounded-lg border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-black">
	  </div>

	  <!-- List of books -->
	  <div class="flex-grow overflow-auto">
	    <ul class="px-4 py-2">
	      <li v-for="book in books" @click="selected(book.id, book.title, book.author, book.published_date, due_date)" class="flex justify-between items-center px-4 py-3 mb-4 rounded-lg shadow-md" :class="{ 'bg-red-200': isOverdue(book.due_date) }">
	        <div class="flex-1 mr-4">
	          <h2 class="text-lg font-medium">{{ book.title }}</h2>
	          <p class="text-gray-500">{{ book.author }}</p>
	        </div>
	      </li>
	    </ul>
	  </div>

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
			book: {
				id: null,
				title: null,
				author: null,
				published_date: null,
				due_date: null,
			},
			books: [],
			keyword: null,
		};
	},
	mounted() {

	},
	watch: {
		keyword(after, before) {
			this.booksSearch();
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
		isOverdue(dueDate) {
      return new Date(dueDate) < new Date();
    },
    clearForm() {
    	var self = this;
			self.book.id = null;
			self.book.title = null;
			self.book.author = null;
			self.book.published_date = null;
			self.book.due_date = null;
    },
		save() {
			var self = this;
			const data = {
				title: self.book.title,
				author: self.book.author,
				published_date: self.book.published_date,
			}

			axios.post('/books', data)
				.then(function(response) {
					self.showAlert(response.data, true);
					self.clearForm();
				})
				.catch(function (error) {
					self.showAlert(error.response.data.message, false);
			  });
		},
		selected(id, title, author, published_date) {
			this.book.id = id;
			this.book.title = title;
			this.book.author = author;
			this.book.published_date = published_date;
		},
		edit() {
			var self = this;
			const data = { 
				title: self.book.title,
				author: self.book.author,
				published_date: self.book.published_date,
			}

			axios.put(`/books/${self.book.id}`, data)
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

			axios.delete(`/books/${self.book.id}`)
				.then(function(response) {
					self.showAlert(response.data, true);
					self.clearForm();
				})
				.catch(function (error) {
					self.showAlert(error.response.data.message, false);
			  });
		},
		booksSearch() {
			var self = this;
			const data = { keyword: self.keyword }

			axios.post('/books/search', data)
				.then(function(response) {
						self.books = response.data;
				});
		},
	}
}
</script>