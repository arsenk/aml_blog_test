import axios from "axios";

const axiosInstance = axios.create({
  baseURL: "http://localhost",
  timeout: 10000,
});

export default axiosInstance;
