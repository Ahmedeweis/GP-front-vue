<template>
  <body class="sign-up-body">
    <section id="elzero-app" class="box">
      <form>
        <div class="icon">
          <img src="../assets/web.png" alt="" />
        </div>
        <h2>Get Started today</h2>
        <p>Every novel has a writer .. There is no cheating in novels anymore</p>
        <div class="input-box">
          <label for="age">
            <input type="number" name="" v-model="age" id="age" required min="18" max="60" />
            <span>Age</span>
            <i></i>
          </label>
        </div>
        <div class="input-box">
          <label for="name">
            <input type="text" name="" v-model="name" id="name" required />
            <span>Name</span>
            <i></i>
          </label>
        </div>
        <div class="input-box">
          <label for="email">
            <input type="email" name="" v-model="email" id="email" required />
            <span>E-mail</span>
            <i></i>
          </label>
        </div>
        <div class="input-box">
          <label for="password">
            <input type="password" name="" v-model="password" id="password" required />
            <span>Password</span>
            <i></i>
          </label>
        </div>
        <input @click.prevent="signUp" type="submit" value="Register" required />
        <div class="transfare"><router-link to="/">Login page</router-link></div>
      </form>
    </section>
  </body>
</template>

<script>
import axios from 'axios';
import swal from 'sweetalert';

export default {
  name: 'SignUpView',
  data() {
    return {
      name: '',
      email: '',
      password: '',
      age: '',
    };
  },
  mounted() {
    const userLog = localStorage.getItem('user-info');
    if (userLog) {
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
    async signUp() {
      if (!this.name || !this.email || !this.password || !this.age) {
        console.log('Please fill in all fields.');
        swal('Sign Up', 'Please fill you correct info', 'warning');
        return;
      }
      const user = {
        name: this.name,
        email: this.email,
        password: this.password,
        age: this.age,
      };
      try {
        const response = await axios.post('http://localhost:8888/user/addUser', user);
        console.log('User registered successfully!', response);
        if (response.status === 201) {
          swal('Sign Up Succesful', '', 'success');
          this.$router.push({ name: 'Login' });
        }
      } catch (error) {
        console.log(error);
        swal(`${error.response.data.message}`, '', 'error');
      }
    },
  },
};
</script>

<style src="../css/normalize.css"></style>
<style src="../css/main.css"></style>
