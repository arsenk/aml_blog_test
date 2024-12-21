<template>
  <div class="edit-blog">
    <h1>Edit Blog Post</h1>

    <div v-if="loading">
      <p>Loading...</p>
    </div>

    <div v-else>
      <form @submit.prevent="updateBlog" class="blog-form">
        <div class="form-group">
          <label for="title">Title</label>
          <input
            v-model="blog.title"
            type="text"
            id="title"
            class="form-input"
            required
          />
        </div>

        <div class="form-group">
          <label for="content">Content</label>
          <textarea
            v-model="blog.content"
            id="content"
            class="form-textarea"
            required
          ></textarea>
        </div>

        <div class="form-group">
          <label for="image">Upload Image</label>
          <input
            type="file"
            @change="handleFileChange"
            class="form-input"
            accept="image/*"
          />
        </div>

        <div class="form-group">
          <button type="submit" class="submit-btn">Update Blog</button>
          <button type="button" @click="cancelEdit" class="cancel-btn">
            Cancel
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from "@/axios";

export default {
  data() {
    return {
      blog: {
        title: "",
        content: "",
        image_url: "",
      },
      image: null,
      loading: true,
    };
  },
  methods: {
    async fetchBlog() {
      try {
        const response = await axios.get(`/api/blogs/${this.$route.params.id}`);
        this.blog = response.data;
      } catch (error) {
        console.error("Error fetching blog data:", error);
      } finally {
        this.loading = false;
      }
    },

    handleFileChange(event) {
      this.image = event.target.files[0];
    },

    async updateBlog() {
      const formData = new FormData();
      formData.append("title", this.blog.title);
      formData.append("content", this.blog.content);

      if (this.image) {
        formData.append("image", this.image);
      }

      try {
        const token = localStorage.getItem("token");
        await axios.put(`/api/blogs/${this.blog.id}`, formData, {
          headers: {
            Authorization: `Bearer ${token}`,
            "Content-Type": "multipart/form-data",
          },
        });
        this.$router.push({ name: "blog" });
      } catch (error) {
        console.error("Error updating blog:", error);
      }
    },

    cancelEdit() {
      this.$router.push({ name: "blog" });
    },
  },

  mounted() {
    this.fetchBlog();
  },
};
</script>

<style scoped>
.edit-blog {
  width: 100%;
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
}

h1 {
  text-align: center;
  color: #333;
  font-size: 2rem;
  margin-bottom: 30px;
}

.blog-form {
  display: flex;
  flex-direction: column;
}

.form-group {
  margin-bottom: 15px;
}

label {
  font-size: 1rem;
  color: #333;
  margin-bottom: 5px;
}

.form-input,
.form-textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 1rem;
}

.form-textarea {
  height: 200px;
  resize: vertical;
}

.submit-btn,
.cancel-btn {
  background-color: #4caf50;
  color: white;
  padding: 12px 20px;
  font-size: 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
  margin-right: 10px;
}

.submit-btn:hover,
.cancel-btn:hover {
  background-color: #45a049;
}

.cancel-btn {
  background-color: #f44336;
}

.cancel-btn:hover {
  background-color: #e53935;
}

.submit-btn:disabled,
.cancel-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}
</style>
