<template>
    <div class="flex justify-end">
        <ul class="flex pagination bg-white p-2 shadow-sm rounded">
            <!-- previous icon -->
            <li class="pagination-item" @click="changePage('prev')">
                <button class="rounded-l border border-gray-100 px-3 py-2 mr-2 no-underline text-gray-600"
                    :class="page == 1 ? 'cursor-not-allowed' : ''">&laquo;</button>
            </li>

            <li v-for="n in pages" :key="n" class="pagination-item">
                <button type="button" @click="changePage(n)" v-if="n <= 3" class="rounded-l border border-gray-100 px-4 py-2.5 no-underline mr-2
                    text-sm" :class="n == page ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100 hover:text-gray-600'">
                    {{ n }}
                </button>

                <span v-if="n < pages && n == page + 5" class="inline-flex
                    items-center
                    py-2
                    px-4
                    bg-white
                    text-sm
                    font-medium
                    text-gray-700">...</span>

                <button type="button" @click="changePage(n)" v-if="page >= 4 && n == page" class="rounded-l border border-gray-100 px-3 py-2 no-underline mr-2
                    text-sm" :class="n == page ? 'bg-indigo-500 text-white' : 'hover:bg-gray-100 hover:text-gray-600'">
                    {{ n }}
                </button>
               
            </li>

            <!-- next icon -->
            <li class="pagination-item" @click="changePage('next')">
                <button class="rounded-l border border-gray-100 px-3 py-2 hover:bg-gray-100 text-gray-600 no-underline"
                :class="page == pages ? 'cursor-not-allowed':  ''">
                    &raquo;
                </button>
            </li>
        </ul>
    </div>
</template>

<script lang="js">
import { defineComponent, computed, ref } from 'vue'

export default defineComponent({
    name: 'Pagination',
    props: {
        totalRecords: {
            required: true,
            type: Number
        },
        perPageOptions: {
            required: true,
            type: Array
        }
    },
    setup(props,{emit}) {
        let page = ref(1);
        let perPage = ref();
        perPage.value = props.perPageOptions[0];
        
        const pages = computed(()=> {
            const reminder = props.totalRecords % perPage.value;

            if(reminder > 0) {
                return Math.floor(props.totalRecords / perPage.value) + 1;
            } else {
                return props.totalRecords / perPage.value;
            }
        })

        function changePage(val) {
            if( val === 'prev' ) {
                this.page = this.page > 1 ? this.page - 1: this.page;
            } else if( val === 'next' ) {
                this.page = this.page < this.pages ? this.page + 1: this.page;
            } else {
                this.page = val;
            }
            emit('setPage', {page: this.page, perPage: this.perPage})
        }

        return {
            page,
            perPage,
            pages,
            changePage
        }  
    }
})
</script>