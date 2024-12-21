<template>
  <div class="blog-list">
    <h1>Blog List</h1>

    <div v-if="blogs.length">
      <div class="blog-grid">
        <div v-for="blog in blogs" :key="blog.id" class="blog-item">
          <div class="blog-item-content">
            <div class="blog-image">
              <img :src="blog.image_url" alt="Blog Image" />
            </div>

            <div class="blog-info">
              <p class="blog-id">Blog ID: {{ blog.id }}</p>
              <h3 class="blog-title">{{ blog.title }}</h3>
              <p class="blog-content">
                {{ blog.content.substring(0, 150) }}...
              </p>
              <p class="blog-author">
                <strong>Author:</strong> {{ blog.user.email }}
              </p>
            </div>
          </div>

          <div class="blog-footer">
            <router-link :to="'/blog/' + blog.id" class="view-btn"
              >View</router-link
            >
            <div v-if="blog.user_id === loggedInUserId">
              <router-link :to="'/edit/' + blog.id" class="edit-btn"
                >Edit</router-link
              >
              &nbsp;
              <button @click="deleteBlog(blog.id)" class="delete-btn">
                Delete
              </button>
            </div>
          </div>
        </div>
      </div>

      <div class="pagination">
        <button :disabled="page === 1" @click="fetchBlogs(page - 1)">
          Previous
        </button>
        <span>Page {{ page }} of {{ totalPages }}</span>
        <button :disabled="page === totalPages" @click="fetchBlogs(page + 1)">
          Next
        </button>
      </div>
    </div>

    <div v-else>
      <p>Loading...</p>
    </div>
  </div>
</template>

<script>
import axios from "@/axios";

export default {
  name: "blogComponent",
  data() {
    return {
      blogs: [],
      page: 1,
      totalPages: 1,
    };
  },
  mounted() {
    this.fetchBlogs();
  },
  created() {
    this.loggedInUserId = this.getLoggedInUserId();
    this.fetchBlogs(this.page);
  },
  methods: {
    getLoggedInUserId() {
      const user = JSON.parse(localStorage.getItem("user"));
      return user ? user.id : null;
    },
    async fetchBlogs(page = 1) {
      try {
        let response = await axios.get(`/api/blogs`, {
          params: { page },
        });
        this.blogs = response.data.data;
        this.page = response.data.current_page;
        this.totalPages = response.data.last_page;
      } catch (error) {
        console.error("Error fetching blogs:", error);
      }
    },
    deleteBlog(blogId) {
      if (confirm("Are you sure you want to delete this blog?")) {
        const token = localStorage.getItem("token");
        axios
          .delete(`/api/blogs/${blogId}`, {
            headers: {
              Authorization: `Bearer ${token}`,
            },
          })
          .then(() => {
            this.fetchBlogs();
          })
          .catch((error) => {
            console.error("Error deleting blog:", error);
            alert("An error occurred while deleting the blog.");
          });
      }
      this.fetchBlogs();
    },
  },
};
</script>

<style scoped>
.blog-list {
  max-width: 1200px;
  margin: 30px auto;
  padding: 20px;
  background-color: #f7f7f7;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  font-size: 2.5rem;
  margin-bottom: 30px;
  color: #333;
}

.blog-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 20px;
}

.blog-item {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
}

.blog-item .blog-image img {
  width: 100%;
  height: auto;
  border-radius: 8px;
  object-fit: cover;
}

.blog-item .blog-info {
  margin-top: 15px;
}

.blog-item .blog-id {
  font-size: 1rem;
  color: #888;
  margin-bottom: 10px;
}

.blog-item .blog-title {
  font-size: 1.8rem;
  color: #333;
  margin-bottom: 10px;
}

.blog-item .blog-content {
  font-size: 1.1rem;
  color: #666;
  margin-bottom: 15px;
  line-height: 1.6;
}

.blog-item .blog-author {
  font-size: 1.1rem;
  color: #333;
  margin-bottom: 10px;
}

.blog-footer {
  display: flex;
  justify-content: space-between;
  margin-top: 15px;
}

.blog-footer .view-btn,
.blog-footer .edit-btn,
.blog-footer .delete-btn {
  padding: 8px 15px;
  border-radius: 4px;
  color: white;
  text-decoration: none;
}

.blog-footer .view-btn,
.blog-footer .edit-btn {
  background-color: #3498db;
}

.blog-footer .view-btn:hover,
.blog-footer .edit-btn:hover {
  background-color: #2980b9;
}

.blog-footer .delete-btn {
  background-color: #e74c3c;
  border: none;
}

.blog-footer .delete-btn:hover {
  background-color: #c0392b;
}

.pagination {
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 15px;
  margin-top: 30px;
}

.pagination button {
  padding: 10px 15px;
  font-size: 1rem;
  background-color: #3498db;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.pagination button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.pagination button:hover:not(:disabled) {
  background-color: #2980b9;
}

.pagination span {
  font-size: 1.2rem;
  color: #333;
}
</style>
