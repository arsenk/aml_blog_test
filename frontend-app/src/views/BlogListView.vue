<template>
  <div class="blog">
    <BlogList />
  </div>
</template>

<script>
import BlogList from "@/components/BlogList.vue";

export default {
  name: "BlogListView",
  components: {
    BlogList,
  },
};
</script>

<style scoped>
.blog {
  max-width: 1000px;
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

.blog-item {
  background-color: white;
  padding: 20px;
  margin-bottom: 25px;
  border-radius: 8px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
}

.blog-item h3 {
  font-size: 2rem;
  color: #333;
  margin-bottom: 15px;
}

.blog-item .id {
  font-size: 1rem;
  color: #aaa;
  margin-bottom: 10px;
}

.blog-item .content {
  font-size: 1.2rem;
  color: #666;
  margin-bottom: 15px;
  line-height: 1.6;
}

.blog-item img {
  max-width: 100%;
  height: auto;
  border-radius: 8px;
  margin-top: 15px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.blog-item .author {
  font-size: 1.1rem;
  color: #333;
  margin-top: 10px;
  font-weight: bold;
}

.view-btn {
  display: inline-block;
  margin-top: 15px;
  padding: 10px 20px;
  background-color: #3498db;
  color: white;
  font-size: 1rem;
  text-align: center;
  text-decoration: none;
  border-radius: 4px;
  transition: background-color 0.3s ease;
}

.view-btn:hover {
  background-color: #2980b9;
}

.delete-btn {
  display: inline-block;
  margin-top: 10px;
  padding: 8px 15px;
  background-color: #e74c3c;
  color: white;
  font-size: 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.delete-btn:hover {
  background-color: #c0392b;
}

.delete-btn:focus {
  outline: none;
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

.loading {
  text-align: center;
  font-size: 1.2rem;
  color: #888;
  margin-top: 50px;
}
</style>
