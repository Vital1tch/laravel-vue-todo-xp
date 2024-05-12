<script>
//Использовать расширение .vue
import Layout from "../Shared/Layout.vue";
import axios from 'axios';

    export default {
        data() {
            return {
                showModal: false,
                newTaskName: '',
                tasks: [] // Ваш массив с задачами
            };
        },

        methods: {
            addTask() {
                this.$inertia.post('/tasks', {
                    name: this.newTaskName
                }, {
                    onSuccess: () => {
                        // Закрытие модального окна после успешного добавления задачи
                        this.showModal = false;
                        // Очистка поля ввода
                        this.newTaskName = '';
                        // Перезагрузка текущей страницы для обновления списка задач
                        this.$inertia.reload();
                    }
                });
            }
        },

        props: {
            // Принимаем список задач через props
            tasks: {
                type: Array,
                required: true,
            },
            habits : {
                type: Array,
                required: true,
            }
        },
        layout:Layout
    }
</script>

<template>

    <div class="box-content max-h-max w-4/5 m-auto bg-bg-grey-custom text-white flex items-start content-center rounded-t-3xl">

        <div class="box-content max-h-max w-4/5 m-auto bg-bg-grey-custom text-white flex items-start content-center rounded-t-3xl">

            <div class="">
                <p class="ml-10 mt-6 mb-5 font-semibold text-white text-3xl">Привычки</p>
                <button class="border-4 border-solid border-white ml-12 w-96 h-16 bg-bg-grey-custom hover:bg-purple-header text-white font-semibold text-xl  rounded-t-3xl ">+ Добавить</button>
                <div class="box-content border-2 bg-black-header max-h-max  ml-12 rounded-b-lg ">
                    <div v-for="habit in habits" :key="habit.id" class="flex justify-center items-center mt-10 mb-5">
                        <div class="box-border h-20 bg-white flex justify-normal font-semibold text-xl rounded-lg items-center text-slate-600 w-80 ">
                            <div class="box-content h-20 w-20 bg-purple-header flex justify-center rounded-l-lg items-center ">
                                <input type="checkbox" class="w-10 h-9">
                            </div>
                            {{habit.name}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="">
                <p class="ml-10 mt-6 mb-5 font-semibold text-white text-3xl">Задачи</p>
                <button @click="showModal = true" class="border-4 border-solid border-white ml-12 w-96 h-16 bg-bg-grey-custom hover:bg-purple-header text-white font-semibold text-xl  rounded-t-3xl ">+ Добавить</button>
                <div class="box-content border-2 bg-black-header ml-12 rounded-b-lg ">
                    <div v-for="task in tasks" :key="task.id" class="flex justify-center items-center mt-10 mb-5">
                        <! --Блок задачи-->
                        <div class="box-content min-h-20 bg-white flex justify-normal font-semibold text-xl rounded-lg items-center text-slate-600 w-80 ">
                            <! --CheckBox-->
                            <div class="relative pt-10 pr-10 bg-cian-header top-0 left-0 rounded-l-lg mr-4">
                                <input type="checkbox" class="w-10 h-9 ">
                            </div>
                            {{task.name}}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Модальное окно для добавления задачи -->
            <div v-if="showModal" class="modal">
                <div class="modal-content mt-20 bg-black-header box-content ml-28  h-64 w-56 p-4 border-2">
                    <input v-model="newTaskName" type="text" class="bg-bg-grey-custom text-white pt-6" placeholder="Введите название задачи">
                    <button class="mt-10 pt-6 bg-bg-grey-custom" @click="addTask">Добавить</button>
                </div>
            </div>

        </div>









    </div>
</template>



