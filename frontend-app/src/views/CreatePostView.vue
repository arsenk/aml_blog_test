<template>
  <div class="create-post">
    <BlogPostCreate />
  </div>
</template>

<script>
import BlogPostCreate from "@/components/BlogPostCreate.vue";

export default {
  name: "BlogPostCreateView",
  components: {
    BlogPostCreate,
  },
};
</script>

<style scoped>
.create-post {
  max-width: 600px;
  margin: 30px auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  color: #333;
  font-size: 2rem;
  margin-bottom: 20px;
}

form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

label {
  font-size: 1.1rem;
  font-weight: bold;
  color: #333;
}

input[type="text"],
textarea,
input[type="file"] {
  padding: 10px;
  font-size: 1rem;
  border: 1px solid #ccc;
  border-radius: 4px;
  margin-top: 5px;
  width: 100%;
}

input[type="file"] {
  padding: 5px;
}

.error {
  color: red;
  font-size: 0.9rem;
  margin-top: 5px;
}

.alert {
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 4px;
  font-weight: bold;
}

.alert.success {
  background-color: #d4edda;
  color: #155724;
}

.alert.error {
  background-color: #f8d7da;
  color: #721c24;
}

button {
  background-color: #4caf50;
  color: white;
  font-size: 1.1rem;
  padding: 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

button:hover:not(:disabled) {
  background-color: #45a049;
}

button span {
  display: inline-block;
}

button span[disabled] {
  visibility: hidden;
}
</style>
