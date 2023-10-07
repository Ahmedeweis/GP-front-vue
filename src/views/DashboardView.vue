<!-- eslint-disable vuejs-accessibility/alt-text -->
<!-- eslint-disable vuejs-accessibility/click-events-have-key-events -->
<!-- eslint-disable import/no-unresolved -->
<!-- eslint-disable import/no-unresolved -->
<!-- eslint-disable no-plusplus -->
<!-- eslint-disable no-await-in-loop -->
<!-- eslint-disable no-await-in-loop -->
<!-- eslint-disable max-len -->
<template>
  <body>
    <headNav />
    <section class="page">
      <div class="content">
        <div class="upload">
          <form>
            <div class="in">
              <img src="../assets/pdf.svg" alt="" />
              <h2>choose the file pdf only</h2>
              <button>select Documents</button>
              <span>Or Drag & drop</span>
            </div>
            <label for="file">
              <input type="file" id="uploads" name="uploads" accept=".pdf" v-on:change="handleFileUpload($event.target.files)" />
            </label>
            <button type="submit" class="last-btn" v-on:click.prevent="submitForm">search</button>

          </form>
        </div>
      </div>
    </section>
  </body>
</template>

<script>
import axios from 'axios';
import swal from 'sweetalert';
import headNav from '@/components/header.vue';

export default {
  name: 'DashboardView',
  data() {
    return {
      filePath: '',
      content: '',
      author: '',
    };
  },
  mounted() {
    const userLog = localStorage.getItem('user-info');
    if (!userLog) {
      this.$router.push({ name: 'Login' });
    } else if (userLog) {
      if (JSON.parse(userLog).roles[0]) {
        const x = JSON.parse(userLog).roles[0].name;
        if (x.toLowerCase() === 'admin') {
          this.$router.push({ name: 'homeAdmin' });
        } else {
          this.$router.push({ name: 'Dashboard' });
        }
      }
    }
  },
  methods: {
    async getAuthors() {
      const usr = localStorage.getItem('user-info');
      // eslint-disable-next-line prefer-destructuring
      const id = JSON.parse(usr).id;
      const result = await axios.get(`http://localhost:8888/author/viewAllAuthors?currentUserId=${id}`);
      if (result.status === 200) {
        localStorage.setItem('authors-data', JSON.stringify(result.data.body));
        this.findAuthorName(this.author);
      }
    },
    findAuthorName(authorIdName) {
      const authors = localStorage.getItem('authors-data');
      const author = JSON.parse(authors);
      // eslint-disable-next-line no-plusplus
      for (let i = 0; i < author.length; i++) {
        if (author[i].name === authorIdName) {
          const authorId = author[i].id;
          this.clickAuthor(authorId);
          break; // Exit the loop once the author is found
        }
      }
    },
    clickAuthor(idAuthor) {
      this.$router.push({ name: 'authorProfileUser', params: { id: idAuthor } });
    },
    async UserSignOut() {
      const usr = localStorage.getItem('user-info');
      // eslint-disable-next-line prefer-destructuring
      const id = JSON.parse(usr).id;
      try {
        const result = await axios.get(`http://localhost:8888/auth/logout?currentUserId=${id}`);
        if (result.status === 200) {
          swal('Logout', 'thanks for visting our paltform', 'info');
          localStorage.clear();
          this.$router.push({ name: 'Login' });
        }
      } catch (error) {
        console.log('error');
      }
    },
    handleFileUpload(files) {
      // eslint-disable-next-line prefer-destructuring
      this.path = files[0];
    },
    async submitForm() {
      if (!this.path) {
        // Handle case when no file is selected
      }
      try {
        const formData = new FormData();
        formData.append('file', this.path); // Add the file with key name "file"
        const response = await axios.post('http://localhost:8000/api/getFilePath', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        });
        this.filePath = response.data.path;
        this.identifyAuthor();
      } catch (error) {
        console.log(error);
      }
    },
    async identifyAuthor() {
      try {
        const result = await axios.get(`http://localhost:8888/author/readPdf?filePath=${encodeURIComponent(this.filePath)}`);
        if (result.status === 200) {
          this.content = result.data.body;
          try {
            const response = await axios.get(`http://localhost:8888/author/identifyAuthor?article=${encodeURIComponent(this.content)}`);
            if (response.status === 200) {
              this.author = response.data.author;
              swal(`${this.author}`, 'The author has been found', 'success');
              this.getAuthors();
            }
          } catch (errorr) {
            console.log(errorr);
          }
        }
      } catch (error) {
        console.log(error);
      }
    },
  },
  components: {
    headNav,
  },
};
</script>

<style src="../css/Home.css"></style>
