<template>
    <breadcrumb-default :items="breadcrumbs" class="mt-10 mx-4 md:mb-6" />
    <div
        class="w-full mt-10 mx-4 lg:w-1/2 h-auto overflow-hidden border border-1 border-primary-100 dark:bg-secondary-dark lg:rounded-xl rounded">
        <!-- card header start -->
        <div class="bg-blue-50 dark:bg-primary-900 py-2.5 ps-4">
            <h6-label>Edit Item</h6-label>
        </div>
        <!-- card header end -->

        <!-- card body start -->
        <div class="px-4 mt-6">
            <div>
                <div class="grid w-full gap-6">
                    <div>
                        <default-label for="name">Title<span class="text-red-600">*</span></default-label>
                        <input-ui id="name" ref="name" type="text" v-model:value="form.title" />
                    </div>

                    <div>
                        <default-label for="price">Price<span class="text-red-600">*</span></default-label>
                        <input-ui id="price" ref="price" type="text" v-model:value="form.price" />
                    </div>

                    <div>
                        <default-label for="price">Description</default-label>
                        <text-area-ui id="description" ref="description" v-model:value="form.description" />
                    </div>

                    <div>
                        <default-label for="category">Category Name<span class="text-red-600">*</span></default-label>
                        <input-ui id="category" ref="category" type="text" v-model:value="form.category" />
                    </div>

                    <div>
                        <input type="file" @change="uploadPhoto" name="photo"
                            class="block w-full text-sm text-primary-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" />
                        <img v-if="form.photo" :src="getPhoto()" class="w-46 h-32 rounded-md mt-4" />
                    </div>

                    <div class="flex justify-end mb-4 space-x-2">
                        <button-ui bgColor="bg-gray-50 dark:bg-primary-dark"
                            textColor="text-gray-900">Cancel</button-ui>
                        <button-loading @click="updateItem" bgColor="bg-gray-500">Save</button-loading>
                    </div>
                </div>
            </div>
        </div>
        <!-- card body end -->

    </div>
</template>
<script setup>
import { ref, computed, onMounted, reactive } from 'vue';
import { useRoute } from 'vue-router'
import DefaultLabel from '../../components/label/DefaultLabel.vue';
import InputUi from '../../components/input/InputUi.vue';
import ButtonLoading from '../../components/button/ButtonLoading.vue';
import ButtonUi from '../../components/button/ButtonUi.vue';
import H6Label from '../../components/label/H6Label.vue';
import TextAreaUi from '../../components/textarea/TextAreaUi.vue';
import BreadcrumbDefault from '../../components/breadcrumb/BreadcrumbDefault.vue';

const route = useRoute()
const breadcrumbs = computed(() => {
    return [
        {
            label: "Items",
            url: "/items",
        },
        {
            label: "Edit Item",
            color: "text-gray-400"
        }
    ]
})

let form = reactive({
    title: '',
    description: '',
    price: '',
    category: '',
    photo: ''
})

let errors = ref("");

onMounted(() => {
    showEditData();
})

function showEditData() {
    axios.get(`http://127.0.0.1:8000/api/items/edit/${route.params.id}`)
        .then(response => {
            if (response.data.status == 200) {
                form.title = response.data.item.title;
                form.description = response.data.item.description;
                form.price = response.data.item.price;
                form.category = response.data.item.category;
                form.photo = response.data.item.photo;
            }
        })
        .catch(function (error) {
            console.log(error);
        });
}

function updateItem() {
    axios.post(`http://127.0.0.1:8000/api/items/update/${route.params.id}`, {
        title: form.title,
        description: form.description,
        category: form.category,
        price: form.price,
        photo: form.photo,
    })
        .then(response => {
            if (response.data.status == 200) {
                window.location.href = "/items"
            } else {
                errors.value = response.data.message
            }
        })
        .catch(error => {
            console.log(error);
        });
}

const uploadPhoto = (e) => {
    let file = e.target.files[0];
    let reader = new FileReader();

    if (file['size'] < 2111775) {
        reader.onloadend = () => {
            form.photo = reader.result;
        }
        reader.readAsDataURL(file);
    } else {
        alert('File size can not be bigger than 2 MB');
    }
};

//For getting Instant Uploaded Photo
const getPhoto = () => {
    if (form.photo != null) {
        let photo = (form.photo.length > 100) ? form.photo : "/img/upload/" + form.photo;
        return photo;
    }
}       
</script>