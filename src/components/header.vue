<!-- eslint-disable max-len -->
<!-- eslint-disable vuejs-accessibility/click-events-have-key-events -->
<!-- eslint-disable vue/multi-word-component-names -->
<!-- eslint-disable vuejs-accessibility/alt-text -->
<!-- eslint-disable vuejs-accessibility/anchor-has-content -->
<template>

<body>
    <header class="nav">
        <nav class="container">
            <ul class="L-link">
                <li style="padding-left:0px;"><a href="" class="Title">Author Identifcation</a></li>
                <router-link to="/dashboard">    <li><a href="">Home</a></li></router-link>
                <router-link to="/AuthorsUserView">   <li><a href="">Authors</a></li></router-link>
            </ul>

            <ul class="R-link">
                <li>
                    <!-- 0 Hover that image container to get list  -->
                    <div class="image-container">
                        <!-- 0 link gog to profile -->
                        <a >
                            <!-- 0 profile icon -->
                            <img src="../assets/user.svg" class="notify-icon">
                        </a>
                        <!-- 0 box apear when hover image container -->
                        <div class="hover-box">
                            <!-- 0 content of box -->
                            <div class="content">
                               <router-link to="/profile"><a href=""><img src="../assets/profile.png" alt="Your Photo"></a>
                                <div class="user-name">Ahmed</div>  </router-link> <!-- 0 name of user -->
                                <!-- 0 button + img of row -->
                                <div class="img-link" @click="UserSignOut()" >
                                    <img style="width:50px;" src="../assets/logout.png">
                                    <a class="two-btn" href="">log out</a>
                                </div>
                                <!-- 1 button + img of row -->
                            </div>
                            <!-- 1 content of box -->
                        </div>
                    <!-- 0 box apear when hover image container -->
                    </div>
                </li>
            </ul>
        </nav>
    </header>
</body>
</template>
<script>
import axios from 'axios';
import swal from 'sweetalert';

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: 'headNav',
  data() {
    return {
      name: '',
    };
  },
  methods: {
    async UserSignOut() {
      const usr = localStorage.getItem('user-info');
      // eslint-disable-next-line prefer-destructuring
      const id = JSON.parse(usr).id;
      try {
        const result = await axios.get(`http://localhost:8888/auth/logout?currentUserId=${id}`);
        if (result.status === 200) {
          localStorage.removeItem('user-info');
          localStorage.clear();
          swal('Logout', 'thanks for visting our paltform', 'info');
          this.$router.push({ name: 'Login' });
          return;
        }
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>

<style>
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
        right:0;
        background-color:white;
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
        cursor: pointer;

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
