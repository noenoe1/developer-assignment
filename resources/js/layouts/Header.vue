<template>
    <nav class="bg-gray-800 mx-auto w-full px-2 sm:px-6 lg:px-8 flex h-16 items-center justify-between">
        <a class="px-3 py-2 text-sm font-medium text-white" href="#">Laravel9 and Vue 3</a>

        <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false"
            aria-label="Toggle navigation"></button>

        <div class="navbar-nav" v-if="isLoggedIn">
            <router-link to="/dashboard" class="px-3 py-2 text-sm font-medium text-white">Dashboard</router-link>
            <router-link to="/items" class="px-3 py-2 text-sm font-medium text-white">Items</router-link>
            <a class="px-3 py-2 text-sm font-medium text-white" style="cursor: pointer;" @click="logout">Logout</a>
        </div>

        <div class="navbar-nav" v-else>
            <router-link to="/" class="px-3 py-2 text-sm font-medium text-white">Home</router-link>
            <router-link to="/login" class="px-3 py-2 text-sm font-medium text-white">Login</router-link>
            <router-link to="/register" class="px-3 py-2 text-sm font-medium text-white">Register</router-link>
        </div>
    </nav>
</template>

<script setup>
import { onMounted, ref } from 'vue';

let isLoggedIn = ref(false);
let token = localStorage.getItem('token');

onMounted(() => {
    if (token != null) {
        isLoggedIn.value = true;
    }
})

function logout() {

    localStorage.removeItem('token');
    localStorage.removeItem('name');
    localStorage.removeItem('email');
    window.location.href = "/login"

}
</script>