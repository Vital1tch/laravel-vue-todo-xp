<script>
//Использовать расширение .vue
import Layout from "../Shared/Layout.vue";
    export default {
        layout:Layout
    }
</script>

<template>
    <div class="h-screen w-4/5 m-auto bg-bg-grey-custom text-white flex items-start content-center rounded-t-3xl">

        <div>
            <p class="ml-10 mt-6 mb-5 font-semibold text-white text-3xl ">Привычки</p>
            <div class="bg-black-header mt-3 ml-10 pb-96 pr-80 rounded-xl border-gray-100 border-2 relative">
                <button class="absolute top-4 left-4 py-2 px-4 w-72 h-14 bg-bg-grey-custom hover:bg-purple-header text-white font-semibold text-xl rounded-2xl inline-block">+ Добавить</button>
            </div>
        </div>

        <div>
            <p class="ml-12 mt-6 mb-5 font-semibold text-white text-3xl ">Задачи</p>
            <div class="bg-black-header mt-3 ml-12 pb-96 pr-80 rounded-xl border-gray-100 border-2 relative">
                <button class="absolute top-4 left-4 py-2 px-4 w-72 h-14 bg-bg-grey-custom hover:bg-purple-header text-white font-semibold text-xl rounded-2xl inline-block">+ Добавить</button>
            </div>
        </div>

    </div>
</template>


