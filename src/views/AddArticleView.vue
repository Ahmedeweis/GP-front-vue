<!-- eslint-disable vuejs-accessibility/alt-text -->
<!-- eslint-disable max-len -->
<!-- eslint-disable vuejs-accessibility/form-control-has-label -->
<template>
  <headNavv />
  <body class="write-article-body" >
    <section style="    background: linear-gradient(90deg, rgba(18, 22, 29, 1) 0%, rgba(9, 42, 85, 1) 84%); padding:50px 0px 0px 0px  ">
        <div class="container">
    <head>
        <div class="first-line">
            <img src="../assets/logo.png" alt="logo">
            <div class="site-name">Author Identifcation</div>
        </div>
        <div class="second-line">
            <h1 >TEll us what is in your mind</h1>
        </div>
        <div class="third-line" >
            <h3>Identify million of Authors within minutes. View profiles, ratings,
                 portfolios and write comment to them.
                 all that in one site
            </h3>
        </div>
    </head>
    <!-- -->
    <div class="infoe">
        <!-- poste -->
        <div class="poste">
            <div class="personal-infoo">
                <input placeholder="Choose a name for article" v-model="title" >
            </div>
            <div class="text">
              <h2>write the Article here</h2>
              <p><textarea id="try" name="description"
                placeholder="Describe your Idea here..." class="multiline-input" v-model="conetnt"  ></textarea>
              </p>
            </div>
        </div>
        <!-- poste -->
        <button class="publish-art-btn" @click.prevent="addArticle" >Publish</button>
        </div>
    <!-- -->
        </div>
    </section>
</body>
</template>

<script>
import headNavv from '@/components/headerAdmin.vue';
import axios from 'axios';
import swal from 'sweetalert';

export default {
  name: 'addArticle',
  data() {
    return {
      title: '',
      conetnt: '',
      authorId: '',
      currentId: '',
    };
  },
  mounted() {
    const userLog = localStorage.getItem('user-info');
    if (!userLog) {
      this.$router.push({ name: 'Login' });
      return;
    }
    this.authorId = this.$route.params.id;
    this.currentId = JSON.parse(userLog).id;
  },
  methods: {
    async addArticle() {
      const all = `${this.title} \n${this.conetnt} `;
      try {
        const article = {
          author_id: this.authorId,
          content: all,
        };
        const result = await axios.post(`http://localhost:8888/article/addArticle?currentUserId=${this.currentId}`, article);
        if (result.status === 201) {
          swal('Added Successfuly', '', 'success');
          this.$router.push({ name: 'authorProfile', params: { id: this.authorId } });
        }
      } catch (error) {
        swal(`${error.response.data.message}`, '', 'error');
      }
    },
  },
  components: {
    headNavv,
  },
};
</script>

<style scoped>
/* 0 Global Rules */

* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}

  :root {
  --xxfont: 32px;
  --xfont: 24px;
  --lfont: 20px;
  --mfont: 18px;
  --sfont: 14px;
}

html {
  scroll-behavior: smooth;
}

body {
  font-family: 'Poppins', sans-serif;
}

a {
  text-decoration: none;
  font-weight: bold;
}

button {
  text-transform: capitalize;
}

ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

.container {
  padding-left: 15px;
  padding-right: 15px;
  margin-left: auto;
  margin-right: auto;
}

/* Small */
@media (min-width: 768px) {
  .container {
    width: 750px;
  }
}
/* Medium */
@media (min-width: 992px) {
  .container {
    width: 970px;
  }
}
/* Large */
@media (min-width: 1200px) {
  .container {
    width: 1170px;
  }
}

/* 0 Header */
.write-article-body {
  min-height: 150vh;
  position: relative;
}

.write-article-body::after {
  content: '';
  width: 100%;
  position: absolute;
  right: 0;
  top: 0;
  background: rgb(18, 22, 29);
  background: linear-gradient(90deg, rgba(18, 22, 29, 1) 0%, rgba(9, 42, 85, 1) 84%);
  height: 40%;
  z-index: -1;
}

.write-article-body section {
  padding-top: 150px;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.write-article-body section .container head {
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
}

.first-line {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  line-height: 1.7;
}

.site-name {
  margin-left: 10px;
  color: white;
  font-size: var(--lfont);
}

.first-line img {
  width: 64px;
}

.second-line h1 {
  color: white;
  font-size: var(--xxfont);
  line-height: 1.7;
}

.third-line h3 {
  color: white;
  font-size: var(--sfont);
  line-height: 1.7;
}

/* write poste */
.infoe {
  margin-top: 30px;
  background-color: white;
  padding: 24px;
}

.poste {
  margin-bottom: 30px;
  width: 100%;
}

.personal-infoo {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  align-self: flex-start;
  margin-bottom: 20px;
  width: inherit;
  position: relative;
  border-bottom:solid #1772EB 2px;
}
.personal-infoo input {
  width: inherit;
  border-top: none;
  border-left: none;
  border-right: none;
  border-bottom:none;
  padding-bottom: 10px;
  font-size: var(--lfont);
}

.personal-infoo input:focus::placeholder {
  color: #5C6F8C;
}

.personal-infoo input:focus {
  outline: transparent;
}

.personal-infoo input:focus::placeholder {
  color: #9DA9BA;
}
.infoe  {
  border: 2px solid rgba(221,221,221,1);
  border-bottom:none;
}

.multiline-input {
  resize: vertical;
  border: 1px solid #BCC5D3;
  padding: 10px;
  background: none;
  width: 100%;
  font-weight: bold;
  font-size: 25px;
  height:300px;
}

.multiline-input:hover{
  border: 1px solid #589AF0;
}
.multiline-input:focus{
  border: 1px solid #589AF0;
}

.publish-art-btn {
  color:white;
  background-color: #E60278;
  padding:15px;
  border:none;
  border-radius:6px;
  cursor: pointer;
  font-weight:bold;
}

/* End Work Steps */
/* 1 postes */
/*write poste*/
</style>
