<template>
  <div>
    <h1>Create Blog Post</h1>

    <div v-if="message" :class="['alert', message.type]">
      {{ message.text }}
    </div>

    <form @submit.prevent="createBlogPost">
      <div>
        <label for="title">Title</label>
        <input type="text" id="title" v-model="title" required />
        <div v-if="errors.title" class="error">{{ errors.title[0] }}</div>
      </div>

      <div>
        <label for="content">Content</label>
        <textarea id="content" v-model="content" required></textarea>
        <div v-if="errors.content" class="error">{{ errors.content[0] }}</div>
      </div>

      <div>
        <label for="image">Upload Image</label>
        <input type="file" @change="handleFileChange" />
        <span v-if="imageError" style="color: red">Image is required</span>
      </div>

      <button type="submit" :disabled="loading">
        <span v-if="loading">Submitting...</span>
        <span v-else>Create Blog Post</span>
      </button>
    </form>
  </div>
</template>

<script>
import axios from "@/axios";

export default {
  data() {
    return {
      title: "",
      content: "",
      image: null,
      imageError: false,
      errors: {},
      message: null,
      loading: false,
    };
  },
  methods: {
    handleFileChange(event) {
      this.image = event.target.files[0];
      this.imageError = false;
    },
    async createBlogPost() {
      if (!this.image) {
        this.imageError = true;
        return;
      }

      const formData = new FormData();
      formData.append("title", this.title);
      formData.append("content", this.content);
      formData.append("image", this.image);

      try {
        this.loading = true;

        const token = localStorage.getItem("token");
        await axios.post("/api/blogs", formData, {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "multipart/form-data",
          },
        });

        this.message = {
          type: "success",
          text: "Blog post created successfully!",
        };
        this.title = "";
        this.content = "";
        this.image_url = "";

        this.$router.push("/blog");
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.errors = error.response.data.errors;
        } else {
          this.message = {
            type: "error",
            text:
              error.response.data.message ||
              "An error occurred while creating the blog post.",
          };
        }
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style>
form {
  max-width: 400px;
  margin: 0 auto;
}
label {
  display: block;
  margin-bottom: 5px;
}
input,
textarea {
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
}
button {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
}
button:disabled {
  background-color: #ccc;
}
.error {
  color: red;
  font-size: 12px;
}
</style>
