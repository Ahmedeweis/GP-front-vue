<!-- eslint-disable vuejs-accessibility/click-events-have-key-events -->
<!-- eslint-disable vuejs-accessibility/form-control-has-label -->
<!-- eslint-disable max-len -->
<!-- eslint-disable vuejs-accessibility/alt-text -->
<!-- eslint-disable vuejs-accessibility/anchor-has-content -->
<template>
<body class="AdminHomeBody">
  <headNav />
  <header class="header-II">
      <div class="container">
          <ul class="second-nav">
            <div class="tap">
              <router-link to="/home_admin"> <li  ><a href="">Authors</a></li></router-link>
              <router-link to="/admin_users"><li style="background-color:black;"><a  class="active" href="">users</a></li> </router-link>
            </div>
            <div class="sear">
              <form class="search">
                <button><img src="../assets/search.png"></button>
                <input type="search" placeholder="Search" v-model="searchQuery" />
              </form>
            </div>
          </ul>
      </div>
  </header>
  <section class="posts work-steps">
      <div class="container">
          <div class="info">
            <router-link to="/adduser"><button class="add-btn"><img src="../assets/add.png"> Add User</button></router-link>
              <!-- post -->
              <div v-if="filteredUsers.length > 0">
                <div class="post" v-for="user in filteredUsers" :key="user.id" >
                  <div class="personal-info">
                      <span class="auth-id">{{user.id}}</span>
                      <a href="" ><img src="../assets/user.png" alt="" /></a>
                      <div>
                          <h2>{{user.name}}</h2>
                          <h2>{{user.age}}</h2>
                          <h2>{{user.email}}</h2>
                      </div>
                  </div>
                  <div class="box-buttons">
                      <button class="update-btn" @click.prevent="sendUser(user.id)" >Update</button>
                      <button class="delete-btn" @click="deleteUser(user.id)">delete</button>
                  </div>
              </div>
              </div>
              <div v-else-if="searchQuery && filteredUsers.length === 0">
                <p>No authors found.</p>
              </div>
              <div v-else>
              <div class="post" v-for="user in users" :key="user.id" >
                  <div class="personal-info">
                      <span class="auth-id">{{user.id}}</span>
                      <a href=""><img src="../assets/user.png" alt="" /></a>
                      <div>
                          <h2>{{user.name}}</h2>
                          <h2>{{user.age}}</h2>
                          <h2>{{user.email}}</h2>
                      </div>
                  </div>
                  <div class="box-buttons">
                      <button class="update-btn" @click="sendUser(user.id)">Update</button>
                      <button class="delete-btn" @click.prevent="deleteUser(user.id)">delete</button>
                  </div>
              </div>
            </div>
              <!-- post -->
          </div>
      </div>
  </section>
</body>
</template>
<style src="../css/AdminHomeUsers.css"></style>
<script>
import headNav from '@/components/headerAdmin.vue';
import axios from 'axios';

export default {
  name: 'SignUpView',
  data() {
    return {
      name: '',
      users: [],
      searchQuery: '',
      currentId: '',
    };
  },
  mounted() {
    const usrLog = localStorage.getItem('user-info');
    if (!usrLog) {
      this.$router.push({ name: 'Login' });
      return;
    }
    this.getUsers();
  },
  methods: {
    async getUsers() {
      const usr = localStorage.getItem('user-info');
      // eslint-disable-next-line prefer-destructuring
      const id = JSON.parse(usr).id;
      this.currentId = id;
      const result = await axios.get(`http://localhost:8888/user/getAllUsers?currentUserId=${id}`);
      if (result.status === 200) {
        this.users = result.data.body;
      }
    },
    async deleteUser(userId) {
      const usr = localStorage.getItem('user-info');
      // eslint-disable-next-line prefer-destructuring
      const id = JSON.parse(usr).id;
      const result = await axios.delete(`http://localhost:8888/user/deleteUser?currentUserId=${id}&userId=${userId}`);
      if (result.status === 200) {
        this.getUsers();
      }
    },
    sendUser(userId) {
      const idd = parseInt(userId, 10);
      this.$router.push({ name: 'EditUser', params: { id: idd } });
    },
    // async getId(userId) {
    //   const usr = localStorage.getItem('user-info');
    //   // eslint-disable-next-line prefer-destructuring
    //   const id = JSON.parse(usr).id;
    //   const result = await axios.get(`http://localhost:8888/user/viewProfile?currentUserId=${id}&id=${userId}`);
    //   if (result.status === 200) {
    //     localStorage.setItem('user-id', JSON.stringify(result.data.body));
    //     // this.$router.push({ name: 'adminUpdateUser' });
    //   }
    // },
  },
  computed: {
    filteredUsers() {
      const searchQuery = this.searchQuery.toLowerCase();
      return this.users.filter((user) => user.name.toLowerCase().includes(searchQuery));
    },
  },
  components: {
    headNav,
  },
};
</script>
<style scoped>
.search {
  position:relative;
}
.search button {
  padding:3px;
  margin-left:9px;
  position:absolute;
  top:7px;
  border:none;
  background-color:transparent;
}
.search button img {
  width:20px;
}
.search input {
  padding:10px 10px;
  border: 1px solid #ccc;
  border-radius:5px;
  margin-left: 5px;
  padding-left: 30px;
  width: 400px;
  transition: width 0.3s;
  color: black;
}

</style>
