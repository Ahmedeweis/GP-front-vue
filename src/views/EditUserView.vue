<!-- eslint-disable no-plusplus -->
<!-- eslint-disable vuejs-accessibility/form-control-has-label -->
<template>
  <body class="sign-up-body">
    <section id="elzero-app" class="box">
      <form>
        <div class="icon">
          <img src="../assets/identification.png" alt="">
        </div>
        <h2>Hello admin {{ currentName }}</h2>
        <p style="font-weight:bold;">Edit the user info from here</p>
        <div class="input-box">
          <label for="name">
          <input type="text" name=""   v-model="name" id="name"  required>
          <span>Name</span>
          <i></i>
          </label>
        </div>
        <div class="input-box">
          <label for="password">
          <input type="password" name="" v-model="password"   id="password"  required>
          <span>Password</span>
          <i></i>
          </label>
        </div>
        <div class="input-box">
          <label for="email">
          <input type="email" name="" v-model="email"    id="email" required>
          <span>E-mail</span>
          <i></i>
          </label>
        </div>
        <div class="input-box">
          <label for="age">
          <input type="number" name="" v-model="age" required min="18" max="60">
          <span>Age</span>
          <i></i>
          </label>
        </div>
        <div class="input-box">
        <!-- 0 fist down list emara  -->
        <div class="dropdown">
          <select class="dropdown-select" v-model="selected_role">
            <option >User</option>
            <option>Admin</option>
          </select>
        </div>
        <!-- 1 fist down list emara  -->
        </div>
        <input type="submit" value="Edit" required @click.prevent="Update(this.selected_role)">
      </form>
    </section>
  </body>
</template>

<script>
import axios from 'axios';
import swal from 'sweetalert';

export default {
  name: 'EditUser',
  data() {
    return {
      users: [],
      currentName: '',
      currentId: '',
      userId: '',
      name: '',
      email: '',
      password: '',
      age: '',
      selected_role: 'User',
    };
  },
  mounted() {
    const userLog = localStorage.getItem('user-info');
    if (!userLog) {
      this.$router.push({ name: 'Login' });
      return;
    }
    this.currentId = JSON.parse(userLog).id;
    this.currentName = JSON.parse(userLog).name;
    this.userId = this.$route.params.id;
    this.getData();
  },
  methods: {
    async getData() {
      try {
        const result = await axios.get(`http://localhost:8888/user/viewProfile?currentUserId=${this.currentId}&id=${this.userId}`);
        if (result.status === 200) {
          const data = result.data.body;
          this.email = data.email;
          this.password = data.password;
          this.name = data.name;
          this.age = data.age;
        }
      } catch (errors) {
        console.log(errors);
      }
    },
    async Update(adminId) {
      if (!this.name || !this.email || !this.password || !this.age) {
        console.log('Please fill in all fields.');
        swal('Sign Up', 'Please fill you correct info', 'warning');
        return;
      }
      const user = {
        age: this.age,
        email: this.email,
        id: this.userId,
        name: this.name,
        password: this.password,
      };
      try {
        const response = await axios.put(`http://localhost:8888/user/updateUser?currentUserId=${this.currentId}`, user);
        if (response.status === 200) {
          if (adminId === 'Admin') {
            await axios.get(`http://localhost:8888/user/addRoleToUser?currentUserId=${this.currentId}&roleId=93&userId=${this.userId}`);
          }
          swal('Succesful', '', 'success');
          this.getData();
        }
      } catch (error) {
        console.log(error);
      }
    },
  },
};
</script>
<style src="../css/normalize.css"></style>
<style src="../css/main.css"></style>
<style>
  .sign-up-body .box form .input-box i {
      width: 97%
}
.sign-up-body .box form input[type="submit"] {
  width: 101%;
}
    .dropdown {
      position: relative;
      display: inline-block;
      font-family: Arial, sans-serif;
      color: #333;
      width: 100%;
    }
    .dropdown-select {
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      cursor: pointer;
      width: 98%;
      margin-top:10pxs;
      background-color:#05D661;
      color:black;
    }
   .dropdown-select option {
    margin:10px;
    background-color:#a0f5c3;
    color:black;
    font-size:20px;
   }
</style>
