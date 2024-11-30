<template>
    <Alert v-if="message" :text="message" bgColor="bg-red-100" borderColor="border border-red-400"
        textColor="text-red-700" class="m-4" />

    <div class="flex mt-10 mx-4 justify-between py-3 pl-2">
        <input-icon v-model:value="searchValue" class="w-72" placeholder="Search Title and Category Name..." />
        <router-link to="/items/add">
            <button-icon iconName="plus" bgColor="bg-gray-600">Add Item</button-icon>
        </router-link>
    </div>

    <div class="mt-10 mx-4 relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3 text-xs font-bold text-left text-gray-500 uppercase">
                        ID
                    </th>

                    <th v-for="(col, index) in columns" :key="index" scope="col" class="px-6 py-3">
                        {{ col.label }}
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(record, index) in filter" :key="index"
                    class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">

                    <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                        <default-label>{{ index + 1 + paginationVal.perPage * (paginationVal.page - 1)
                            }}</default-label>
                    </td>

                    <td v-for="(col, index) in columns" :key="index" class="px-6 py-4">
                        <default-label class="flex items-center space-x-2" v-if="col.field == 'action'">
                            <router-link :to="'/items/edit/' + record['id']" href="#">
                                <icon class="text-green-500 hover:text-green-700" name="edit" />
                            </router-link>
                            <icon class="text-red-500 hover:text-red-700" @click="deleteRecord(record['id'])"
                                name="trash" />
                        </default-label>
                        <div v-else-if="col.field == 'photo'">
                            <img v-if="record[col.field] != ''" :src="'/img/upload/' + record[col.field]" alt="Image"
                                class="w-20 h-20 rounded-md">
                            <img v-else :src="'/img/upload/no_image.png'" alt="Image" class="w-20 h-20 rounded-md">
                        </div>
                        <default-label v-else>{{ record[col.field] }}</default-label>
                    </td>
                </tr>
            </tbody>
        </table>

        <confirm-delete v-show="isConfirmDeleteModalVisible" modalHeadline="Delete Product record?"
            deleteMessage="Are you sure you want to delete this item?" @deleteRecordEvent="deleteItem"
            @close="closeConfirmDeleteModal"></confirm-delete>
    </div>

    <pagination class="w-full" v-show="totalRecords > perPageOptions[0]" @setPage="setPage" :totalRecords="totalRecords"
        :perPageOptions="perPageOptions" />

</template>

<script setup>
import { reactive, ref, computed, onMounted } from 'vue';
import axios from 'axios';
import Icon from '../../components/icon/Icon.vue';
import DefaultLabel from '../../components/label/DefaultLabel.vue';
import ConfirmDelete from '../../components/dialog/ConfirmDeleteDialog.vue';
import InputIcon from '../../components/input/InputIcon.vue';
import ButtonIcon from '../../components/button/ButtonIcon.vue';
import Alert from '../../components/alert/Alert.vue';
import Pagination from '../../components/pagination/Pagination.vue';

const globalSearchFields = ["title", "category"];
let perPageOptions = reactive([10, 25, 50, 100]);
let totalRecords = ref(10);
let paginationVal = reactive({ page: 1, perPage: perPageOptions[0] })
let isConfirmDeleteModalVisible = ref(false);

const columns = reactive([
    {
        label: "Image",
        field: "photo"
    },
    {
        label: "Title",
        field: "title"
    },
    {
        label: "Description",
        field: "description"
    },
    {
        label: "Category",
        field: "category"
    },
    {
        label: "Action",
        field: "action"
    }
]);

let searchValue = ref("");
let allRecords = ref([]);
let message = ref("");

function setPage({ page, perPage }) {
    paginationVal.page = page;
    paginationVal.perPage = perPage;
}

onMounted(() => {
    getItems();
})

function getItems() {
    axios.get('http://127.0.0.1:8000/api/items').then(response => {
        if (response.data.status == true) {
            allRecords.value = response.data.items;
        }
        else {
            message.value = response.data.message

        }

    }).catch(error => {
        console.log(error)
        allRecords = []
    })
}

const filter = computed(() => {
    if (searchValue.value) {
        let data;
        data = allRecords.value.filter((row) => {
            let matched = false;
            for (let i = 0; i < globalSearchFields.length; i++) {
                if (row[globalSearchFields[i]].toLowerCase()
                    .includes(searchValue.value.toLowerCase())) {
                    matched = true;
                    break;
                } else {

                    matched = false;

                }
            }
            if (matched) {
                return true;
            } else {
                return false;
            }
        });
        return data;

    }
    return allRecords.value;

})

let deleteId = ref('');
const showConfirmDeleteModal = (id) => {
    isConfirmDeleteModalVisible.value = true;
    deleteId.value = id;
}

const closeConfirmDeleteModal = () => {
    isConfirmDeleteModalVisible.value = false;
}

const deleteItem = () => {
    axios.delete(`http://127.0.0.1:8000/api/items/delete/${deleteId.value}`)
        .then(response => {
            message.value = response.data.message
        })
        .catch(function (error) {
            console.log(error);
        });
    isConfirmDeleteModalVisible.value = false;
}

const deleteRecord = (id) => {
    showConfirmDeleteModal(id);

}

</script>