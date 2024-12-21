<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="login" class="login-form">
      <div class="form-group">
        <label for="email">Email</label>
        <input
          type="email"
          v-model="email"
          id="email"
          required
          class="form-input"
        />
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input
          type="password"
          v-model="password"
          id="password"
          required
          class="form-input"
        />
      </div>

      <button type="submit" class="submit-btn">Login</button>

      <p v-if="emailVerificationMessage" style="color: blue">
        {{ emailVerificationMessage }}
      </p>

      <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
    </form>
  </div>
</template>

<script>
import axios from "@/axios";

export default {
  name: "LoginComponent",
  data() {
    return {
      email: "",
      password: "",
      errorMessage: null,
      emailVerificationMessage: null,
    };
  },
  created() {
    if (this.$route.query.emailVerificationRequired) {
      this.emailVerificationMessage =
        "Please check your email to verify your account before logging in.";
    }
  },
  methods: {
    async login() {
      try {
        const response = await axios.post(`/api/login`, {
          email: this.email,
          password: this.password,
        });

        localStorage.setItem("token", response.data.token);
        localStorage.setItem("user", JSON.stringify(response.data.user));

        this.$emit("updateLoginStatus", true);
        this.$router.push("/blog");
      } catch (error) {
        if (error.response) {
          if (error.response.status === 422) {
            const firstError =
              error.response.data.errors[
                Object.keys(error.response.data.errors)[0]
              ][0];
            this.errorMessage = firstError;
          } else {
            this.errorMessage =
              error.response.data.message || "Something went wrong!";
          }
        } else {
          this.errorMessage = "An error occurred. Please try again later.";
        }
      }
    },
  },
};
</script>

<style scoped>
.login-container {
  width: 400px;
  margin: auto;
  background-color: #fff;
  padding: 30px;
  border-radius: 8px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

h2 {
  text-align: center;
  color: #333;
  margin-bottom: 20px;
}

.login-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

label {
  font-weight: bold;
  color: #444;
  margin-bottom: 5px;
}

.form-input {
  padding: 10px;
  font-size: 16px;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-bottom: 10px;
  outline: none;
}

.form-input:focus {
  border-color: #007bff;
}

.submit-btn {
  background-color: #007bff;
  color: white;
  padding: 12px;
  font-size: 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.submit-btn:hover {
  background-color: #0056b3;
}

.error-message {
  color: red;
  font-size: 14px;
  text-align: center;
}
</style>
