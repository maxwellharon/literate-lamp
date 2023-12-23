<template>
  <div class="flex flex-col h-screen">

    <alert v-if="alert.show" :message="alert.message" :success="alert.success" :error="alert.error" class="absolute top-10 right-0 m-4"></alert>

    <div class="grid grid-cols-2 gap-4">
      <div class="p-4 bg-gray-200">
        <h3 class="text-2xl font-bold">{{ client.name }}</h3>
        <div class="mt-4">
          <p><span class="font-semibold">Email:</span> {{ client.email }}</p>
          <p><span class="font-semibold">Card ID:</span> {{ client.card_id }}</p>
          <p><span class="font-semibold">Address:</span> {{ client.address }}</p>
          <p><span class="font-semibold">Phone Number:</span> {{ client.phone_number }}</p>
          <p>
            <span class="font-semibold">Status: </span>
            <span class="uppercase font-bold" :class="{ 'text-green-500': client.status, 'text-red-500': !client.status }">
              {{ client.status ? 'active' : 'inactive' }}
            </span>
          </p>
        </div>
      </div>


      <div class="p-4 bg-gray-200">
        <h3 class="text-2xl font-bold">Books:</h3>
        <div class="mt-4" v-if="Array.isArray(borrowedBooks) && borrowedBooks.length">
          <ul>
            <li v-for="book in borrowedBooks" :key="book.id" class="mb-2">
              <div class="flex items-center">
                <p class="mr-4">{{ book.title }}</p>
                <button class="px-4 py-2 text-white bg-blue-500 font-bold rounded hover:bg-blue-600" :class="{ 'bg-red-500': isOverdue(book.due_date) }" @click="bookReturned(book.id, book.title)">Returned</button>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>


    <div class="grid grid-cols-2 gap-4">
      <div>

        <!-- Search bar -->
        <div class="py-3 mb-4 rounded-lg shadow-md">
          <input type="text" v-model="keywordClient" placeholder="Search clients" class="w-full px-6 py-6 rounded-lg border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-black">
        </div>

        <!-- List of clients -->
        <div class="flex-grow overflow-auto">
          <ul class="px-4 py-2">
            <li v-for="client in clients" @click="selectedClient(client.id, client.name, client.email, client.card_id, client.address, client.phone_number, client.status)" class="flex justify-between items-center px-4 py-3 mb-4 rounded-lg shadow-md">
              <div class="flex-1 mr-4">
                <h2 class="text-lg font-medium">{{ client.name }}</h2>
                <p class="text-gray-500">{{ client.card_id }}</p>
              </div>
            </li>
          </ul>
        </div>

      </div>
      <div>

        <!-- Search bar -->
        <div class="py-3 mb-4 rounded-lg shadow-md">
          <input type="text" v-model="keywordBook" placeholder="Search books & authors" class="w-full px-6 py-6 rounded-lg border-2 border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-black">
        </div>

        <!-- List of books -->
        <div class="flex-grow overflow-auto">
          <ul class="px-4 py-2">
            <li v-for="book in books" class="flex justify-between items-center px-4 py-3 mb-4 rounded-lg shadow-md">
              <div class="flex-1 mr-4">
                <h2 class="text-lg font-medium">{{ book.title }}</h2>
                <p class="text-gray-500">{{ book.author }}</p>
              </div>
              <div class="flex items-right">
                <button class="px-4 py-2 text-white bg-blue-500 font-bold rounded hover:bg-blue-600" @click="bookBorrowed(book.id)">Borrow</button>
              </div>
            </li>
          </ul>
        </div>
      </div>
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
      books: [],
      borrowedBooks: [],
      book: {
        id: null,
        title: null,
        author: null,
        published_date: null,
        client_id: null,
        due_date: null,
      },
      keywordBook: null,
      clients: [],
      client: {
        id: null,
        name: null,
        email: null,
        card_id: null,
        address: null,
        phone_number: null,
        status: null,
      },
      keywordClient: null,
    }
  },
  watch: {
    keywordBook(after, before) {
      this.booksSearch();
    },
    keywordClient(after, before) {
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
    selectedClient(id, name, email, card_id, address, phone_number, status) {
      this.showClient(id, name, email, card_id, address, phone_number, status)
      this.showClientBooks();
    },
    showClient(id, name, email, card_id, address, phone_number, status) {
      this.client.id = id;
      this.client.name = name;
      this.client.email = email;
      this.client.card_id = card_id;
      this.client.address = address;
      this.client.phone_number = phone_number;
      this.client.status = status;
    },
    showClientBooks() {
      var self = this;

      axios.get(`/clients/${self.client.id}`)
        .then(function(response) {
            self.borrowedBooks = response.data;
        });
    },
    isOverdue(dueDate) {
      return new Date(dueDate) < new Date();
    },
    booksSearch() {
      var self = this;
      const data = { keyword: self.keywordBook }

      axios.post('/books/checkout', data)
        .then(function(response) {
            self.books = response.data;
        });
    },
    bookReturned(id) {
      var self = this;

      axios.put(`/books/${id}/returned`)
        .then(function(response) {
          self.showAlert(response.data);
          self.showClientBooks();
        })
        .catch(function (error) {
          self.showAlert(error.response.data.message);
        });
    },
    bookBorrowed(id) {
      var self = this;

      axios.put(`/books/${id}/${self.client.id}/borrowed`)
        .then(function(response) {
          self.showAlert(response.data);
          self.showClientBooks();
          self.books = [];
        })
        .catch(function (error) {
          self.showAlert(error.response.data.message);
        });
    },
    clientSearch() {
      var self = this;
      const data = { keyword: self.keywordClient }

      axios.post('/clients/checkout', data)
        .then(function(response) {
            self.clients = response.data;
        });
    },
  }
}
</script>