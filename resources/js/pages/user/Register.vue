<template>
    <div class="flex min-h-full flex-1 flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <h-2-label class="mt-10">Create and account</h-2-label>
        </div>

        <Alert v-if="errors" :text="errors" bgColor="bg-red-100" 
        borderColor="border border-red-400" textColor="text-red-700" class="w-92 m-4" />

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="space-y-6">
                <div>
                    <default-label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</default-label>
                    <div class="mt-2">
                        <input v-model="name" id="name" name="name" type="text" required class="block w-full 
                        rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400
                        focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        <span class="text-red-600" v-if="validates?.name">{{ validates.name[0] }}</span>
                    </div>
                </div>

                <div>
                    <default-label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</default-label>
                    <div class="mt-2">
                        <input v-model="email" id="email" name="email" type="email" required class="block w-full 
                        rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400
                        focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        <span class="text-red-600" v-if="validates?.email">{{ validates.email[0] }}</span>
                    </div>
                </div>

                <div>
                    <default-label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</default-label>
                    <div class="mt-2">
                        <input v-model="password" id="password" name="password" type="password" required class="block w-full 
                        rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400
                        focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        <span class="text-red-600" v-if="validates?.password">{{ validates.password[0] }}</span>
                    </div>
                </div>

                <div>
                    <default-label for="confirm-password" class="block text-sm font-medium leading-6 text-gray-900">Confirm Password</default-label>
                    <div class="mt-2">
                        <input v-model="confirm_password" id="confirm-password" name="confirm_password" type="password" required class="block w-full 
                        rounded-md border-0 px-4 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400
                        focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        <span class="text-red-600" v-if="validates?.confirm_password">{{ validates.confirm_password[0] }}</span>
                    </div>
                </div>

                <div>
                    <button class="flex w-full justify-center rounded-md bg-gray-600 px-3 py-1.5 text-sm
                    font-semibold leading-6 text-white shadow-sm hover:bg-gray-500 focus-visible:outline focus-visible:outline-2
                    focus-visible:outline-offset-2 focus-visible:outline-gray-600"
                    @click="submitRegister">Create an account</button>
                </div>
            </div>

        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import H2Label from '../../components/label/H2Label.vue';
import DefaultLabel from '../../components/label/DefaultLabel.vue';
import Alert from '../../components/alert/Alert.vue';

let name = ref("");
let email = ref("");
let password = ref("");
let confirm_password = ref("");
let errors = ref("");
let validates = ref("");

async function submitRegister() {
    axios.post('http://127.0.0.1:8000/api/register', {
        name: name.value,
        email: email.value,
        password: password.value,
        confirm_password: confirm_password.value
    })
    .then(response => {
        if (response.data.status == true) {
                window.location.href = "/login"
        } else {
            errors.value = response.data.message
        }
    })
    .catch(error => {
        if (error.response.status === 422) {

            validates.value = error.response.data.errors;
        }
    });
} 
</script>