import { createRouter, createWebHistory } from 'vue-router';
import LoginView from '@/views/LoginView.vue';
import HomeAdminView from '@/views/HomeAdminView.vue';
import AdminUsersViewVue from '@/views/AdminUsersView.vue';
import SignUpView from '../views/SignUpView.vue';
import DashboardView from '../views/DashboardView.vue';
import ProfileView from '../views/ProfileView.vue';
import authorProfile from '../views/AuthorProfileView.vue';
import addAricle from '../views/AddArticleView.vue';
import AddUser from '../views/AddUserView.vue';
import EditUser from '../views/EditUserView.vue';
import authorProfileUser from '../views/AuthorProfileViewUser.vue';
import AuthorsUserView from '../views/AuthorsUserView.vue';
import ProfileAdminView from '../views/ProfileAdmin.vue';

const routes = [
  {
    path: '/',
    name: 'Login',
    component: LoginView,
  },
  {
    path: '/signup',
    name: 'SignUp',
    component: SignUpView,
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: DashboardView,
  },
  {
    path: '/profile',
    name: 'Profile',
    component: ProfileView,
  },
  {
    path: '/profile-admin',
    name: 'ProfileAdmin',
    component: ProfileAdminView,
  },
  {
    path: '/home_admin',
    name: 'homeAdmin',
    component: HomeAdminView,
  },
  {
    path: '/admin_users',
    name: 'adminUsers',
    component: AdminUsersViewVue,
  },
  {
    path: '/admin-author-profile/:id',
    name: 'authorProfile',
    component: authorProfile,
  },
  {
    path: '/addarticle/:id',
    name: 'addAricle',
    component: addAricle,
  },
  {
    path: '/adduser',
    name: 'AddUser',
    component: AddUser,
  },
  {
    path: '/Edituser/:id',
    name: 'EditUser',
    component: EditUser,
  },
  {
    path: '/admin-author-profile-user/:id',
    name: 'authorProfileUser',
    component: authorProfileUser,
  },
  {
    path: '/AuthorsUserView',
    name: 'AuthorsUserViewr',
    component: AuthorsUserView,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
