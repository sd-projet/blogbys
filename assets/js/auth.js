const { createApp } = Vue;

const authApp = document.getElementById("auth-app");

createApp({
    data() {
        return {
            mode: authApp.dataset.mode || "login"
        };
    }
}).mount("#auth-app");