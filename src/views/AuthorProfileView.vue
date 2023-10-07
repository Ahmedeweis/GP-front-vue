<!-- eslint-disable vue/valid-v-on -->
<!-- eslint-disable vue/require-v-for-key -->
<!-- eslint-disable vuejs-accessibility/alt-text -->
<!-- eslint-disable vuejs-accessibility/form-control-has-label -->
<!-- eslint-disable vuejs-accessibility/heading-has-content -->
<!-- eslint-disable vuejs-accessibility/anchor-has-content -->
<!-- eslint-disable max-len -->
<template>
<body class="write-article-body">
  <headNav />
  <section>
    <div class="container">
        <head>
            <div class="first-line">
                <img src="../assets/logo.png">
                <div class="site-name">Author Identifcation</div>
            </div>
            <div class="second-line">
                <h1>The name of auther is {{authorName}}</h1>
            </div>
            <div class="third-line">
                <button class="add-comment" style="background-color: white; color: black; margin-left:0px;" @click.prevent="addArticle()">Add-article</button>
            </div>
        </head>
    </div>
</section>
<section style="padding-top:10px;">
    <div class="container">
        <!-- 0 article -->
        <div class="info" v-for=" article in articles" :key="article.id">
            <!-- 0 post -->
            <div class="post" style="width:100%;flex-direction:column; background-color:white; border:none;" >
                <div class="personal-info2" style=" width:100%;">
                    <div class="personal-info2-child" style="justify-content:space-between;">
                        <!-- <a href=""><img style="width:100px" src="../assets/user.png" alt="" /></a> -->
                        <h1>{{authorName}}</h1>
                        &nbsp;
                        <h2 class="company name"></h2>
                    </div>
                    <div style="justfy-self:flex-end;">
                      <button class="add-comment" @click.prevent="enableInputs()" >Edit article</button>
                      <button class="add-comment" @click.prevent="updateArticle(article.id , article.content)">Sumbit</button>
                      <button class="add-comment" @click.prevent="deleteArticle(article.id)" >Delete</button>
                  </div>
                </div>
                <div class="text" style="width:100%">
                  <textarea name="description" style="min-height: 300px;
                   width: 100%;" placeholder="Describe your Idea here..."
                   class="multiline-input" v-model="article.content" :disabled="isDisabled">
                </textarea>
                </div>
            </div>
            <!-- 1 post -->
            <!-- 0 write Comment -->
            <div class="text">
                <p class="comment-flex"><textarea id="try" name="description" placeholder="write comment"
                        class="multiline-input" v-model="commentContent[article.id]" ></textarea>
                    <button class="add-comment" @click.prevent="addComment(article.id,commentContent[article.id])">comment</button>
                </p>
            </div>
            <!-- 1 write Comment -->
            <!-- 0 content Comment -->
            <div class="comment" v-for="comment in article.comments" :key="comment.id">
                <div class="personal-info2-child" style="justify-content: space-between;">
                <h2></h2>
                 <button  class="add-comment" @click.prevent ="deleteComment(comment.id)" >Delete</button>
                </div>
                <div class="text">
                    <p class="comment-txt">{{comment.content}}</p>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</template>

<script>
import headNav from '@/components/headerAdmin.vue';
import axios from 'axios';
import swal from 'sweetalert';

export default {
  name: 'authorProfile',
  data() {
    return {
      authorName: '',
      articles: [],
      content: '',
      id: '',
      commentContent: [],
      isDisabled: true,
      authorId: '',
    };
  },
  mounted() {
    const userLog = localStorage.getItem('user-info');
    if (!userLog) {
      this.$router.push({ name: 'Login' });
      return;
    }
    this.authorId = this.$route.params.id;
    this.getArticles();
    this.findAuthorName(parseInt(this.authorId, 10));
  },
  methods: {
    async getArticles() {
      const usr = localStorage.getItem('user-info');
      // const author = localStorage.getItem('author-data');
      // eslint-disable-next-line prefer-destructuring
      const id = JSON.parse(usr).id;
      this.id = id;
      // this.authorId = JSON.parse(author).id;
      try {
        const result = await axios.get(`http://localhost:8888/article/viewAllArticlesForAuthor?authorId=${this.authorId}&currentUserId=${id}`);
        if (result.status === 200) {
          this.articles = result.data.body;
        }
      } catch (error) {
        console.log(error);
      }
    },
    async addComment(idArticle, contentComment) {
      const comment = {
        article_id: idArticle,
        content: contentComment,
      };
      const result = await axios.post(`http://localhost:8888/comment/addComment?currentUserId=${this.id}`, comment);
      if (result.status === 201) {
        this.getArticles();
      }
    },
    async deleteComment(idComment) {
      const result = await axios.delete(`http://localhost:8888/comment/deleteComment?commentId=${idComment}&currentUserId=${this.id}`);
      if (result.status === 200) {
        swal('Deleted Successfuly', '', 'success');
        this.getArticles();
      }
    },
    async deleteArticle(idArticle) {
      const result = await axios.delete(`http://localhost:8888/article/deleteArticle?articleId=${idArticle}&currentUserId=${this.id}`);
      if (result.status === 200) {
        swal('Deleted Successfuly', '', 'success');
        this.getArticles();
      }
    },
    async updateArticle(idArticle, contentArticle) {
      const article = {
        author_id: this.authorId,
        content: contentArticle,
        id: idArticle,
      };
      try {
        const response = await axios.put(`http://localhost:8888/article/updateArticle?currentUserId=${this.id}`, article);
        if (response.status === 200) {
          swal('Successfuly updated', '', 'success');
          this.isDisabled = true;
          this.getArticles();
        }
      } catch (error) {
        console.log(error);
      }
    },
    enableInputs() {
      this.isDisabled = false;
      swal('can you type Now', '', 'info');
    },
    addArticle() {
      this.$router.push({ name: 'addAricle', params: { id: this.authorId } });
    },
    findAuthorName(authorIdName) {
      const authors = localStorage.getItem('authors-data');
      const author = JSON.parse(authors);
      // eslint-disable-next-line no-plusplus
      for (let i = 0; i < author.length; i++) {
        if (author[i].id === authorIdName) {
          this.authorName = author[i].name;
          break; // Exit the loop once the author is found
        }
      }
    },
  },
  components: {
    headNav,
  },

};

</script>

<Style>
  .nav {
      background-color: white;
  }

  .prof img {
      width: 200px;
  }

  nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-direction: row;
      padding: 20px 1px;
  }

  ul {
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex: 1;
  }

  ul li {
      padding: 1px 10px;
  }

  nav li a {
      color: black;
      transition: 0.5s;
  }

  nav li a:hover {
      color: black;
  }

  .L-link {
      display: flex;
      justify-content: flex-start;
      align-items: center;
  }

  .R-link {
      display: flex;
      justify-content: flex-end;
      align-items: center;
  }

  .Title {
      font-size: 30px;
  }

  .icon-profile {
      display: flex;
      justify-content: center;
      align-items: center;
  }

  .icon-profile img {
      width: 50px;
      margin-right: 10px;
  }

  /* 1 header */
  .user-icon,
  .notify-icon {
      width: 32px;
  }

  .notify-icon {
      width: 32px;
  }

  .image-container {
      position: relative;
      display: inline-block;
  }

  .hover-box {
      position: absolute;
      right: 0;
      background-color: white;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.3s ease, visibility 0.3s ease;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      z-index: 999;
      width: 150px;
      border: 2px solid black;
  }

  .img-link {
      display: flex;
      justify-content: space-between;
      margin-top: 15px;

  }

  .image-container:hover .hover-box {
      opacity: 1;
      visibility: visible;
  }

  .content {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: space-between;
      height: 100%;
      padding: 10px;
  }

  .content img {
      width: 40px;
  }

  .content a,
  .two-btn {
      align-items: center;
      display: flex;
      padding: 3px 3px;
      color: black;
      text-decoration: none;
      border-radius: 4px;
      text-align: center;
  }

  .content a:hover,
  .two-btn {
      color: black;
  }
</style>
<style src="../css/ShowAutherProfile.css"></style>
