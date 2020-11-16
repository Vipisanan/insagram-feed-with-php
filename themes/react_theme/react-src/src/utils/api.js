import axios from 'axios';

const API = axios.create();
// Add a request interceptor
API.interceptors.request.use(
  config => {

    return config;
  },
  error => Promise.reject(error)
);

export default API;


// // // Add a response interceptor
//     API.interceptors.response.use(function (response) {
//         // Do something with response data
//         return response;
//     }, function (error) {
//         // Do something with response error
//         Promise.reject(error);
//         return error.toJSON()
//     });
