import app from './app.js'; // import the instance

axios.interceptors.request.use(config => {
    app.$Progress.start(); // for every request start the progress
    return config;
});

axios.interceptors.response.use(response => {
    app.$Progress.finish(); // for every request start the progress
    return response;
});

export function vueLarApi(url, method = 'GET', data = {}, responseType = 'JSON') {
    return new Promise(((resolve, reject) => {
        axios({
            method: method,
            baseURL: baseUrl,
            url: url,
            data: data,
            responseType: responseType
        }).then((response) => {
            resolve(response.data)
        }).catch((error) => {
            reject(error.response)
        })
    }))
}
