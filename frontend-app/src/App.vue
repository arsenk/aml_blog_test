<template>
  <nav>
    <router-link to="/">Home</router-link> |
    <router-link to="/blog">Blog List</router-link> |
    <template v-if="isLoggedIn">
      <router-link to="/createPost">Create Post</router-link> |
      <button @click="logout" class="logout-btn">Logout</button>
    </template>

    <template v-else>
      <router-link to="/register">Register</router-link> |
      <router-link to="/login">Login</router-link>
    </template>
  </nav>
  <router-view />
</template>

<script>
import axios from "axios";

export default {
  name: "App",
  data() {
    return {
      isLoggedIn: localStorage.getItem("token") !== null,
    };
  },
  methods: {
    async logout() {
      try {
        await axios.post(
          "/logout",
          {},
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          }
        );

        localStorage.removeItem("token");
        localStorage.removeItem("user");
        this.isLoggedIn = false;

        this.$router.push("/login");
      } catch (error) {
        console.error("Logout failed:", error);
      }
    },
    watch: {
      $route() {
        this.isLoggedIn = localStorage.getItem("token") !== null;
      },
    },
    methods: {
      updateLoginStatus(status) {
        this.isLoggedIn = status;
      },
    },
  },
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}

.logout-btn {
  background-color: #ff4d4f;
  color: white;
  border: none;
  padding: 10px 20px;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
  margin-left: 20px;
}

.logout-btn:hover {
  background-color: #ff3333;
}

.logout-btn:focus {
  outline: none;
  border: 2px solid #ff3333;
}
</style>
