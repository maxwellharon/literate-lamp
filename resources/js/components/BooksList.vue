<template>
	<div class="flex flex-col h-screen">
	  <!-- Search bar -->
	  <div class="py-3 mb-4 rounded-lg shadow-md">
	    <input type="text" v-model="keyword" placeholder="Search books & authors" class="w-full px-6 py-6 rounded-lg border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-black">
	  </div>

	  <!-- List of books -->
	  <div class="flex-grow overflow-auto">
	    <ul class="px-4 py-2">
	      <li v-for="book in books" class="flex justify-between items-center px-4 py-3 mb-4 rounded-lg shadow-md" :class="{ 'bg-red-200': isOverdue(book.due_date) }">
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
export default {
	data() {
		return {
			books: [],
			keyword: null,
		};
	},
	mounted() {
		this.booksList();
	},
	watch: {
		keyword(after, before) {
			this.booksSearch();
		}
	},
	methods: {
		isOverdue(dueDate) {
      return new Date(dueDate) < new Date();
    },
		booksList() {
			var self = this;

			axios.get('/books')
				.then(function(response) {
					self.books = response.data;
				})
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