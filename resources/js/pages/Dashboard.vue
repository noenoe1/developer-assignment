<template>
    <div class="mt-10 mx-4">
        Welcome, {{ username }}
    </div>
</template>

<script setup>
let username = localStorage.getItem('name');
</script>