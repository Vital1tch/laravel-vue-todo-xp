<script>
    export default {

    }
</script>

<template>
    <div class="bg-gradient-to-r from-purple-header from-50% black-header via-100% to-cian-header to-100% w-4/5 m-auto mt-14 rounded-t-lg">

        <header class="flex justify-between px-8 py-5">

            <div class="flex items-center">
                <img src="/Photos/Logo.png" alt="Logo" class="w-13 mr-3" />
                <div>
                    <h2 class="text-3xl font-semibold text-white">Task sculptor</h2>
                    <p class="font-semibold-regular text-slate-500">Ваяй свою продуктивность</p>
                </div>
            </div>

            <ul class="flex items-center gap-14 text-white text-xl">
                <li class="flex items-center gap-3 cursor-pointer hover:text-indigo-400">
                    <b>Задачи</b>
                </li>

                <li class="flex items-center gap-3 cursor-pointer hover:text-indigo-400">
                    <b>Инвентарь</b>
                </li>

                <li class="flex items-center gap-3 cursor-pointer hover:text-indigo-400">
                    <b>Магазин</b>
                </li>

                <li class="flex items-center gap-3 cursor-pointer hover:text-indigo-400">
                    <b>О нас</b>
                </li>
            </ul>
        </header>
    </div>

    <div class="w-4/5 m-auto mt-6 px-6 flex items-center ">

        <div class="pb-10">
            <img src="/Photos/avatar.png" alt="Avatar">
        </div>

        <div class="mb-16 ml-5 w-48 ">
            <div class="font-semibold text-white text-3xl">
                <b>Vitalitch</b>
            </div>
            <div class="flex items-center">
                <div class="mr-10 text-white text-base pt-2 pb-2">
                    <b>Уровень:</b>
                    <div class="bg-blue-400 w-32 h-4 rounded-full overflow-hidden">
                        <div class="bg-blue-4000 h-full"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <slot>

    </slot>
</template>



