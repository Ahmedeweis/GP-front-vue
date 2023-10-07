<!-- eslint-disable vuejs-accessibility/click-events-have-key-events -->
<!-- eslint-disable vue/no-parsing-error -->
<!-- eslint-disable vuejs-accessibility/alt-text -->
<!-- eslint-disable vuejs-accessibility/form-control-has-label -->
<!-- eslint-disable vuejs-accessibility/anchor-has-content -->
<!-- eslint-disable max-len -->
<template>
  <body class="AdminHomeBody">
    <headNav />
    <header class="header-II">
      <div class="container">
        <ul class="second-nav">
          <div class="tap">
            <li class="active"><a href="">Authors</a></li>
          </div>
          <div class="sear">
            <form class="search">
              <button><img src="../assets/search.png"></button>
              <input type="search" placeholder="Search" v-model="searchQuery"/>
            </form>
          </div>
        </ul>
      </div>
    </header>
    <section class="posts work-steps">
      <div class="container">
        <div class="info">
          <!-- post -->
          <div v-if="filteredAuthors.length > 0">
            <div class="post" v-for="author in filteredAuthors" :key="author.id">
              <div class="personal-info">
                <span class="auth-id">{{author.id}}</span>
                <a href="" @click.prevent="clickAuthor(author.id)"><img src="../assets/writer.png" alt="" /></a>
                <h2>{{author.name}}</h2>
              </div>
              <div class="articles-numbers">
                <h2>Articles : <span>{{author.numberOfArticles}}</span></h2>
              </div>
              <div class="box-buttons">
              </div>
            </div>
          </div>
          <div v-else-if="searchQuery && filteredAuthors.length === 0">
            <p>No authors found.</p>
          </div>
          <div v-else>
          <div class="post" v-for="author in authors" :key="author.id">
            <div class="personal-info">
              <span class="auth-id">{{author.id}}</span>
              <a href=""  @click.prevent="clickAuthor(author.id)"><img src="../assets/writer.png" alt="" /></a>
              <h2>{{author.name}}</h2>
            </div>
            <div class="articles-numbers">
              <h2>Articles : <span>{{author.numberOfArticles}}</span></h2>
            </div>
            <div class="box-buttons">
            </div>
          </div>
          </div>
        </div>
      </div>
    </section>
  </body>
</template>

<style src="../css/AdminHome.css"></style>

<style src="../css/normalize.css"></style>
<script>
import headNav from '@/components/header.vue';

import axios from 'axios';
import swal from 'sweetalert';

export default {
  name: 'HomeAdmin',
  data() {
    return {
      name: '',
      authors: [],
      searchQuery: '',
    };
  },

  mounted() {
    const userLog = localStorage.getItem('user-info');
    if (!userLog) {
      this.$router.push({ name: 'Login' });
      return;
    }
    this.getAuthors();
  },
  methods: {
    async getAuthors() {
      const usr = localStorage.getItem('user-info');
      // eslint-disable-next-line prefer-destructuring
      const id = JSON.parse(usr).id;
      const result = await axios.get(`http://localhost:8888/author/viewAllAuthors?currentUserId=${id}`);
      if (result.status === 200) {
        this.authors = result.data.body;
        localStorage.setItem('authors-data', JSON.stringify(result.data.body));
      }
    },
    async deleteAuthor(authorId) {
      const usr = localStorage.getItem('user-info');
      // eslint-disable-next-line prefer-destructuring
      const id = JSON.parse(usr).id;
      const result = await axios.delete(`http://localhost:8888/author/deleteAuthor?authorId=${authorId}&currentUserId=${id}`);
      if (result.status === 200) {
        this.getAuthors();
      }
    },
    async addAuthor() {
      if (!this.name) {
        console.log('Please fill in all fields.');
        swal('Sign Up', 'Please fill you correct info', 'warning');
        return;
      }
      const usr = localStorage.getItem('user-info');
      // eslint-disable-next-line prefer-destructuring
      const id = JSON.parse(usr).id;
      const user = {
        name: this.name,
      };
      try {
        const response = await axios.post(`http://localhost:8888/author/addAuthor?currentUserId=${id}`, user);
        console.log('User registered successfully!', response);
        if (response.status === 201) {
          this.getAuthors();
        }
      } catch (error) {
        swal('Sign Up fail', '', 'error');
      }
    },
    clickAuthor(idAuthor) {
      this.$router.push({ name: 'authorProfileUser', params: { id: idAuthor } });
    },
  },
  computed: {
    filteredAuthors() {
      const searchQuery = this.searchQuery.toLowerCase();
      return this.authors.filter((author) => author.name.toLowerCase().includes(searchQuery));
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
