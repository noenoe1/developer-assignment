<template>
    <nav class="flex">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <!-- for default home url -->
            <li class="inline-flex items-center">
                <router-link to="/dashboard" class="text-gray-700 hover:text-gray-900 inline-flex items-center" >
                    <icon-fill name="dashboard" class="w-6 h-6 mr-2.5" textColor="text-primary-600" />
                    Home
                </router-link>
            </li>

            <!-- for breadcrumb items -->
            <li v-for="(item,index) in items" :key="index">
                <div v-if="item.url" class="flex items-center">
                    <icon name="rightChervon" class="rtl:rotate-180 text-gray-400 mx-1" viewBox="0 0 6 10" widthHeight="w-3 h-3" />
                    <router-link :to="item.url" :class="item.color ? item.color : 'text-gray-700 hover:text-gray-900'" class="ml-1 md:ml-2 text-sm font-medium">
                        {{ item.label }}
                    </router-link>
                </div>

                <div v-else class="flex items-center">
                    <icon name="rightChervon" class="rtl:rotate-180 text-gray-400 mx-1" viewBox="0 0 6 10" widthHeight="w-3 h-3" />
                    <default-label :textColor="item.color ? item.color : 'text-gray-700 hover:text-gray-900'" class="ml-1 md:ml-2 text-sm font-medium">
                        {{ item.label }}
                    </default-label>
                </div>
            </li>
        </ol>
    </nav>
</template>

<script>
import { defineComponent } from 'vue';
import IconFill from '../icon/IconFill.vue';
import Icon from '../icon/Icon.vue';
import DefaultLabel from '../label/DefaultLabel.vue';

export default defineComponent ({
    name: 'BreadcrumbDefault',
    components: {
        IconFill,
        Icon,
        DefaultLabel,
    },
    props: {
        items: {
            type: Array,
            required: true
        }
    }
})
</script>