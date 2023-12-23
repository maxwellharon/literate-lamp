<template>
	<div>
		<ul>
			<li v-for="book in books">{{ book.title }}</li>
		</ul>
	</div>
</template>


<script>
export default {
	data() {
		return {
			books: [],
		};
	},
	mounted() {
		this.list();
	},
	methods: {
		list() {
			var self = this;

			axios.get('/books')
				.then(function(response) {
					self.books = response.data;
				})
		},
	}
}
</script>