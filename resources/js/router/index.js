import { createRouter, createWebHistory } from "vue-router";

import BooksList from '../components/BooksList.vue';
import BooksManage from '../components/BooksManage.vue';
import ClientsList from '../components/ClientsList.vue';
import ClientsManage from '../components/ClientsManage.vue';
import CheckInOut from '../components/CheckInOut.vue';


const routes = [
	{
		path: '/dashboard',
		component: CheckInOut
	},
	{
		path: '/books',
		component: BooksList
	},
	{
		path: '/books/manage',
		component: BooksManage
	},
	{
		path: '/clients',
		component: ClientsList
	},
	{
		path: '/clients/manage',
		component: ClientsManage
	},
];


const router = createRouter({
	history: createWebHistory(),
	routes
});


export default router;