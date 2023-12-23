<template>
	<div class="flex">
	  <!-- Navigation -->
	  <div class="bg-gray-800 min-h-screen text-white w-64" style="padding-top: 6em;">
	    <div class="p-6">
	      <a href="#" class="text-white text-3xl font-semibold uppercase">LMS</a>
	      <ul class="mt-6">
	      	<li class="relative px-6 py-4">
	          <a href="#" class="inline-flex items-center w-full text-lg font-semibold">
	            Status
	          </a>
	          <ul class="pl-8 mt-1 ml-3">
	            <li><router-link to="/dashboard" class="text-gray-300 hover:text-white">Check In & Out</router-link></li>
	          </ul>
	        </li>
	        <li class="relative px-6 py-4">
	          <a href="#" class="inline-flex items-center w-full text-lg font-semibold">
	            Books
	          </a>
	          <ul class="pl-8 mt-1 ml-3">
	          	<li><router-link to="/books" class="text-gray-300 hover:text-white">Books</router-link></li>
	            <li><router-link to="/books/manage" class="text-gray-300 hover:text-white">Manage Books</router-link></li>
	          </ul>
	        </li>
	        <li class="relative px-6 py-6">
	          <a href="#" class="inline-flex items-center w-full text-lg font-semibold">
	            Clients
	          </a>
	          <ul class="pl-8 mt-1 ml-3">
	          	<li><router-link to="/clients" class="text-gray-300 hover:text-white">Clients</router-link></li>
	            <li><router-link to="/clients/manage" class="text-gray-300 hover:text-white">Manage Clients</router-link></li>
	          </ul>
	        </li>
	      </ul>
	    </div>
	  </div>

	  <!-- Content -->
	  <div class="flex-1" style="padding-top: 6em;">
	  	<div class="p-6">
	  		<router-view/>
	  	</div>
	  </div>
	</div>
</template>

<!-- <router-view/> -->
