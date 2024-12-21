<template>
  <div class="register-container">
    <h2>Create an Account</h2>
    <form @submit.prevent="registerUser" class="register-form">
      <div class="form-group">
        <label for="email">Email</label>
        <input
          type="email"
          id="email"
          v-model="form.email"
          required
          placeholder="Enter your email"
          class="form-input"
        />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input
          type="password"
          id="password"
          v-model="form.password"
          required
          placeholder="Enter your password"
          class="form-input"
        />
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input
          type="password"
          id="password_confirmation"
          v-model="form.password_confirmation"
          required
          placeholder="Confirm your password"
          class="form-input"
        />
      </div>
      <button type="submit" class="submit-btn">Register</button>
    </form>
    <p v-if="errorMessage" class="error-message">{{ errorMessage }}</p>
  </div>
</template>

<script>
import axios from "@/axios";

export default {
  name: "RegisterComponent",
  data() {
    return {
      form: {
        email: "",
        password: "",
        password_confirmation: "",
      },
      errorMessage: "",
    };
  },
  methods: {
    async registerUser() {
      try {
        await axios.post(`/api/register`, this.form);

        this.$router.push({
          name: "login",
          query: { emailVerificationRequired: true },
        });
      } catch (error) {
        if (error.response && error.response.data) {
          this.errorMessage =
            error.response.data.message || "Something went wrong";
        }
      }
    },
  },
};
</script>

<style scoped>
.register-container {
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

.register-form {
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
