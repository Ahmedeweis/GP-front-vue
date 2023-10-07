<!-- eslint-disable no-plusplus -->
<!-- eslint-disable vue/valid-v-else -->
<!-- eslint-disable vue/valid-v-model -->
<!-- eslint-disable vuejs-accessibility/click-events-have-key-events -->
<!-- eslint-disable vuejs-accessibility/form-control-has-label -->
<!-- eslint-disable vuejs-accessibility/anchor-has-content -->
<!-- eslint-disable vuejs-accessibility/alt-text -->
<!-- eslint-disable max-len -->
<template>
  <body>
    <headNav />
    <section class="proff-hiss">
      <div class="container">
        <!-- 0 card of user -->
        <div class="userr-cardd">
          <!-- 0 first line -->
          <div class="picc-cardd">
            <div class="picc">
              <img src="../assets/user-pic.png" class="picc-imagg">
            </div>
            <div class="divv-userr-namee">
              <h2 class="hh-userr-namee">{{name}}</h2>
            </div>
          </div>
          <!-- 1 first line -->
          <!-- 0 second line -->
          <div class="editt-fieldss">
            <h3 class="my-data-titlee">personal info</h3>
            <button class="battonn-editt" @click.prevent="enableInputs">Edit</button>
          </div>
          <!-- 1 second line -->
          <!-- 0 third line -->
          <div class="userr-fieldss">
            <div class="firstt-fieldd">
              <h2 class="hh-userr-data">
                <input type="text" class="userr-dataa" :disabled="isDisabled" placeholder="22" id="ageInput"
                  v-model="age" />
                <span class="spann-dataa">age</span>
              </h2>
            </div>
            <div class="firstt-fieldd">
              <h2 class="hh-userr-data">
                <input type="text" class="userr-dataa" placeholder="Name" :disabled="isDisabled"
                  id="nameInput" v-model="name" />
                <span class="spann-dataa">name</span>
              </h2>
            </div>
            <div class="firstt-fieldd">
              <h2 class="hh-userr-data">
                <input type="email" class="userr-dataa" id="emailInput" placeholder="Eweis@gmail.com"
                  :disabled="isDisabled" v-model="email" />
                <span class="spann-dataa">Email</span>
              </h2>
            </div>
            <div class="firstt-fieldd lastt-fieldd">
              <h2 class="hh-userr-data">
                <input type="password" class="userr-dataa" :disabled="isDisabled" placeholder="0120"
                  id="passwordInput" v-model="password" />
                <span class="spann-dataa">password</span>
              </h2>
            </div>
            <div class="divv-battonn-submitt">
              <button class="battonn-submitt" @click.prevent="Update" :disabled="isDisabled">update</button>
            </div>
          </div>
          <!-- 1 third line -->
          <!-- 0 forth line -->

          <!-- 1 forth line -->
        </div>
        <!-- 1 card of user -->
        <!-- 0  card of history -->
        <div class="historyy-partt">
          <!-- 0 container history -->
          <div class="hitorry-containerr">
            <h2 class="historyy-titlee">History</h2>
            <h2 class="Activityy-titlee">Recent Activity</h2>
            <!-- 0 all activity -->
            <div class="historyy-activities">
              <!-- 0 one activity -->
              <div class="onee-activityy" v-for="histor in History" :key="histor.id">
                <div class="activityy-headd">
                  <img class="rightt-photoo" src="../assets/checkmark.png">
                  <h2 class="activityy-namee" >{{ histor.action }} </h2>
                </div>
                <div class="datee-boxx">
                  <div class="datee-infoo">
                    <h2 class="titt-fieldd">Date</h2>
                    <date class="datee-valuee">{{this.convertTimestampToFormalDate(histor.date)}}</date>
                    <div></div>
                  </div>
                  <div class="datee-infoo">
                    <h2 class="titt-fieldd">Time</h2>
                    <date class="datee-valuee">{{this.Time(histor.date)}}</date>
                    <div></div>
                  </div>
                </div>
                <div class="statee-boxx">
                  <h2 class="statee-fieldd">Status</h2>
                  <span class="statee-valuee">Succeful</span>
                </div>
                <button class="dell-battonn" @click.prevent="deleteAcrivity(histor.id)">Delete Activity</button>
              </div>
              <!-- 1 one activity -->
              <!-- 0 one activity -->
              <!-- 1 one activity -->
            </div>
            <!-- 1 all activity -->
          </div>
          <!-- 1 container history -->
        </div>
        <!-- 1 card of history -->
      </div>
    </section>
  </body>
</template>

<style src="../css/profile.css"></style>

<style src="../css/normalize.css"></style>
<script>
import headNav from '@/components/header.vue';
import axios from 'axios';
import swal from 'sweetalert';

export default {
  name: 'ProfileView',
  data() {
    return {
      isDisabled: true,
      email: '',
      name: '',
      id: '',
      age: '',
      password: '',
      History: [],
    };
  },
  mounted() {
    const usr = localStorage.getItem('user-info');
    if (!usr) {
      this.$router.push({ name: 'Login' });
      return;
    }
    this.getHestory();
    this.name = JSON.parse(usr).name;
    this.email = JSON.parse(usr).email;
    this.age = JSON.parse(usr).age;
    this.id = JSON.parse(usr).id;
    this.password = JSON.parse(usr).password;
  },
  methods: {
    async Update() {
      if (!this.age || !this.email || !this.id || !this.name || !this.password) {
        swal('Please fill the empty field', '', 'error');
        return;
      }
      const user = {
        age: this.age,
        email: this.email,
        id: this.id,
        name: this.name,
        password: this.password,
      };
      try {
        const response = await axios.put(`http://localhost:8888/user/updateUser?currentUserId=${this.id}`, user);
        if (response.status === 200) {
          swal('Successfuly updated', '', 'success');
          localStorage.removeItem('user-info');
          try {
            const result = await axios.get(`http://localhost:8888/user/viewProfile?currentUserId=${this.id}&id=${this.id}`);
            if (result.status === 200) {
              localStorage.setItem('user-info', JSON.stringify(result.data.body));
            }
          } catch (errors) {
            console.log(errors);
          }
        }
      } catch (error) {
        console.log(error);
        swal('email is not unique', '', 'error');
      }
      this.getHestory();
      this.isDisabled = true;
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
        console.log(error);
      }
    },
    enableInputs() {
      this.isDisabled = false;
    },
    async getHestory() {
      const usr = localStorage.getItem('user-info');
      // eslint-disable-next-line prefer-destructuring
      const id = JSON.parse(usr).id;
      const result = await axios.get(`http://localhost:8888/history/viewHistory?currentUserId=${id}`);
      if (result.status === 200) {
        const hst = result.data.body;
        this.History = hst.filter((item) => item.action !== 'viewHistory');
      }
    },
    Time(timestamp) {
      const dateObject = new Date(timestamp);
      const timeString = dateObject.toLocaleTimeString();
      return timeString;
    },
    convertTimestampToFormalDate(timestamp) {
      const dateObj = new Date(timestamp);
      const optionsDate = {
        year: 'numeric',
        month: '2-digit',
        day: '2-digit',
        timeZone: 'UTC',
      };
      const formattedDate = dateObj.toLocaleDateString('en-US', optionsDate);
      return formattedDate;
    },
    async deleteAcrivity(activityId) {
      const result = await axios.delete(`http://localhost:8888/history/deleteHistory?historyId=${activityId}`);
      if (result.status === 200) {
        this.getHestory();
      }
    },
  },
  components: {
    headNav,
  },
};
</script>
<style >
* {
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
:root {
  --xxxfont: 32px;
  --xxfont: 25px;
  --xfont:  20px ;
  --lfont: 18px;
  --mfont:  14px;
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
.proff-hiss .container {
  display: flex;
  flex-direction: row;
  align-items:flex-start;
  justify-content: flex-start;
  width: 100%;
}
@media (max-width:1100px) {
  .proff-hiss .container {
      flex-direction: column;
      align-items:center;
      justify-content:center;
  }
}
/* 0 start card of user */
.userr-cardd {
  display:flex;
  justify-content: center;
  align-items: center;
  flex-direction:column;
  border-radius:6px;
  flex:1.6;
  height:fit-content;
  padding-bottom:20px;
  border:5px solid black;
  width: 100%;
}

.picc-cardd {
background-color:#007BFF;
display:flex;
justify-content: center;
align-items: center;
flex-direction: column;
width:100%;
padding-top:60px;
}
.picc {
  padding:10px;
  background-color:white;
  border:5px solid #ccc;
}
.picc-imagg {
  width:200px;
}

.hh-userr-namee {
  color:white;
  font-size:var(--xxxfont);
  margin: 20px 0px;
}

.userr-namee {
  border:none;
}

.editt-fieldss {
  width:100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-direction:row;
  font-size:var(--xx);
  margin-top:10px;
}

.my-data-titlee {
  font-weight: bold;
  margin-left:10px;
  font-size:var(--xxfont);
}

.battonn-editt {
  color: white;
  background-color: #28A745;
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  margin-right:10px;
  font-size: var(--xfont);
}

.userr-fieldss {
  display: flex;
  justify-content:center;
  align-items:center;
  flex-direction:column;
  width:100%;
  padding:20px 0px;
}

.firstt-fieldd {
  border-top: 3px solid #EBEBEB;
  border-right: 3px solid #EBEBEB;
  border-left: 3px solid #EBEBEB;
  width:100%;
}

.lastt-fieldd {
  border-bottom:3px solid #EBEBEB;
}
.hh-userr-data {
  display: flex;
  justify-content:center;
  align-items:flex-start;
  flex-direction:column;
  padding:1px 60px;
}

.userr-dataa {
  width: inherit;
  border-top: none;
  border-left: none;
  border-right: none;
  border-bottom:none;
  padding: 3px 0px;
  display: flex;
  justify-content: center;
  align-items: flex-start;
  font-size: var(--xxfont);
  font-weight:bold;
  width:100%;
}

.userr-dataa:focus::placeholder {
  color: #5C6F8C;
}
.userr-dataa::placeholder {
  color:black;
}
.userr-dataa:focus {
  outline: transparent;
  border-bottom:2px #1772EB solid;
}

.spann-dataa {
  color:#959294;
  font-weight:bold;
  margin:10px 0px;
}

.battonn-submitt {
  color: white;
  background-color:#E60278;
  padding: 10px 20px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  margin-top:30px;
  font-size:var(--xfont);
}
/* 1 card of user */
/* 0 card of his */

.historyy-partt {
  display:flex;
  justify-content:flex-start;
  align-items: flex-start;
  flex-direction:column;
  border-radius:6px;
  height:fit-content;
  padding-bottom:20px;
  border:5px solid black;
  flex:2;
  margin-left:30px;
  width: 100%;
}
@media (max-width:1100px) {
  .historyy-partt {
      margin-left:0px;
      margin-top:20px;
  }
}
.hitorry-containerr {
  width:100%;
  padding:15px;
  display:flex;
  flex-direction: column;
  justify-content: center;
  align-items: flex-start;
  overflow: hidden;
  background-color:#F2F2F2;
}

.historyy-titlee {
  border-bottom:2px solid black;
  width: calc(100% - 25px);
  padding-bottom:7px;
  font-size:var(--xxxfont);

}

.Activityy-titlee {
  background-color:#27AE61;
  color:white;
  padding: 5px 0px 5px 10px;
  width: calc(100% - 25px);
  font-size:var(--xxxfont);
  margin:10px 0px;
}

.historyy-activities {
  display: flex;
  justify-content: flex-start;
  align-items: flex-end;
  width:calc(100% - 25px);
  flex-direction:column-reverse;
  padding:30px 0px;
}

.historyy-activities > div:nth-child(even) {
  background-color:#F2F2F2;
}

.historyy-activities > div:nth-child(odd) {
  background-color:white;
}

.onee-activityy {
  display: flex;
  justify-content: flex-start;
  align-items: flex-start;
  flex-direction: column;
  width: 100%;
  overflow: hidden;
  margin: 10px 0px;
  padding:15px 0px;
}

.activityy-headd {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  width: 100%;
  border-bottom:2px solid black;
  margin-left: 6px;
}

.rightt-photoo {
  width:30px;
  margin-right:5px;
}

.activityy-namee {
  width: 100%;
  font-size:var(--xxfont);
  padding-bottom:10px;
}

.hh-timee-detielss {
  padding:0px 8px;
  margin:10px 0px;
  font-size:var(--xxfont);
}

.datee-boxx {
  display: flex;
  justify-content:space-between;
  align-items: flex-start;
  flex-direction: column;
  width: 100%;
}

.datee-infoo {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width:100%;
  padding:0px 8px;
  margin:10px 0px;
}
.titt-fieldd {
  justify-self:flex-start;
  flex: 1;
  margin-top:0px;
  margin-bottom:0px;
  padding:8px 0px;
  color:#78787b;
  font-size:var(--xxfont);
}

.datee-valuee {
  justify-self: center;
  flex: 1;
  font-weight: bold;
  font-size:20px;
  font-size:var(--xfont);
}

.statee-boxx {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width:100%;
  padding:0px 8px;
}

.statee-fieldd {
  justify-self:flex-start;
  flex: 1;
  margin-top:0px;
  margin-bottom:0px;
  padding:8px 0px;
}
.statee-spann {
  color:white;
  background-color:#F59E0B;
  padding:8px 10px;
  padding-left:5px;
  margin-left:-5px;
  border-radius:6px;
  font-size:30px;
}
.statee-valuee {
  justify-self: center;
  flex: 1;
  font-weight: bold;
  font-size:20px;
  font-size:30px;
  color:#F59E0B;
}

.dell-battonn {
  color: white;
  background-color:#d50000;
  padding: 8px 10px;
  margin-left: 4px;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  font-weight: bold;
  margin-top: 20px;
  font-size:var(--lfont);
}
/* 1 card of his */
.ifCond {
  display: none;
}
</style>
