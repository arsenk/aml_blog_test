<template>
  <div class="blog-detail">
    <div v-if="blog === null">
      <p>Loading...</p>
    </div>

    <div v-else class="blog-content">
      <div class="left-column">
        <img :src="blog.image_url" alt="Blog Image" class="blog-image" />
      </div>

      <div class="right-column">
        <h1>{{ blog.title }}</h1>
        <p class="blog-id"><strong>Blog ID:</strong> {{ blog.id }}</p>
        <p class="blog-content-text">{{ blog.content }}</p>
        <p class="author"><strong>Author:</strong> {{ blog.user.email }}</p>

        <router-link to="/blog" class="back-link"
          >Back to Blog List</router-link
        >
      </div>
    </div>
  </div>
</template>

<script>
import axios from "@/axios";

export default {
  data() {
    return {
      blog: null,
    };
  },
  created() {
    const blogId = this.$route.params.id;
    this.fetchBlogDetails(blogId);
  },
  methods: {
    async fetchBlogDetails(blogId) {
      try {
        const response = await axios.get(`/api/blogs/${blogId}`);
        this.blog = response.data;
      } catch (error) {
        this.blog = null;
      }
    },
  },
};
</script>

<style scoped>
.blog-detail {
  max-width: 900px;
  margin: 30px auto;
  padding: 20px;
  background-color: #f7f7f7;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  font-family: Arial, sans-serif;
}

.blog-detail h1 {
  font-size: 2.5rem;
  color: #333;
  margin-bottom: 20px;
  text-align: center;
}

.blog-content {
  font-size: 1.1rem;
  color: #555;
  line-height: 1.6;
  margin-bottom: 20px;
  white-space: pre-wrap;
}

.blog-image {
  width: 100%;
  height: auto;
  object-fit: cover;
  border-radius: 8px;
  margin-bottom: 20px;
}

.author {
  font-size: 1.1rem;
  color: #333;
  margin-top: 20px;
  text-align: center;
}

.back-link {
  display: block;
  text-align: center;
  margin-top: 30px;
  font-size: 1.1rem;
  color: #3498db;
  text-decoration: none;
  padding: 10px;
  border-radius: 4px;
  border: 1px solid #3498db;
}

.back-link:hover {
  background-color: #3498db;
  color: white;
}
</style>
