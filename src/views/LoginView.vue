<template>
  <body class="sign-up-body">
    <div class="box">
      <form>
        <div class="icon">
          <img src="../assets/web.png" alt="" />
        </div>
        <h2>Get Started today</h2>
        <p>Every novel has a writer .. There is no cheating in novels anymore</p>
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
        <input @click.prevent="UserSignIn" type="submit" value="Log in" required />
        <div class="transfare"><router-link to="/signup">Sign-up page</router-link></div>
      </form>
      <div show></div>
    </div>
  </body>
</template>

<script>
import axios from 'axios';
import swal from 'sweetalert';

export default {
  name: 'App',
  data() {
    return {
      email: '',
      password: '',
      role: '',
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
    async UserSignIn() {
      const UserSignIn = {
        email: this.email,
        password: this.password,
      };
      try {
        const result = await axios.post('http://localhost:8888/auth/login', UserSignIn);
        console.log(result.status);
        if (result.status === 200) {
          localStorage.setItem('user-info', JSON.stringify(result.data.body));
          const usr = localStorage.getItem('user-info');
          // eslint-disable-next-line prefer-destructuring
          const name = JSON.parse(usr).name;
          if ((JSON.parse(usr).roles[0])) {
          // eslint-disable-next-line prefer-destructuring
            if (JSON.parse(usr).roles[0].id === 157) {
              this.$router.push({ name: 'homeAdmin' });
              return;
            }
          }
          // eslint-disable-next-line quotes
          swal('Login Succesful', `Hello ${name}`, 'success', { button: true });
          this.$router.push({ name: 'Dashboard' });
        }
      } catch (error) {
        swal('Login Failed', 'Email or password is\'t correct ', 'error');
        console.log(error);
      }
    },
  },
};
</script>

<style src="../css/normalize.css"></style>
<style src="../css/main.css"></style>
