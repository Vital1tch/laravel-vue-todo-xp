<script>
//Использовать расширение .vue
import Layout from "../Shared/Layout.vue";
import { library } from '@fortawesome/fontawesome-svg-core';
import { faEdit, faTrash, faPlus } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { mapMutations } from 'vuex';
import axios from 'axios';

library.add(faEdit, faTrash, faPlus);

export default {
    components: {
        Layout,
        'font-awesome-icon': FontAwesomeIcon
    },
    props: {
        // Принимаем список задач и привычек через props
        tasks: {
            type: Array,
            required: true,
        },
        habits: {
            type: Array,
            required: true,
        }
    },
    data() {
        return {
            showModalTask: false,
            showModalHabit: false,
            showModalEditTask: false,
            showModalEditHabit: false,
            newTaskName: '',
            newHabitName: '',
            editTask: null,
            editHabit: null,
        };
    },
    methods: {
        ...mapMutations(['ADD_EXPERIENCE']),
        addTask() {
            this.$inertia.post('/tasks', {
                name: this.newTaskName
            }, {
                preserveScroll: true,
                onSuccess: () => {
                    // Закрытие модального окна после успешного добавления задачи
                    this.showModalTask = false;
                    // Очистка поля ввода
                    this.newTaskName = '';
                    // Перезагрузка текущей страницы для обновления списка задач
                    this.$inertia.reload();
                }
            });
        },
        addHabit() {
            this.$inertia.post('/habits', {
                name: this.newHabitName
            }, {
                preserveScroll: true,
                onSuccess: () => {
                    this.closeAllModals(); // Закрываем все модальные окна
                    // Закрытие модального окна после успешного добавления задачи
                    this.showModalHabit = false;
                    // Очистка поля ввода
                    this.newHabitName = '';
                    // Перезагрузка текущей страницы для обновления списка задач
                    this.$inertia.reload();
                }
            });
        },
        openAddTaskModal() {
            this.closeAllModals();
            this.showModalTask = true;
        },
        openAddHabitModal() {
            this.closeAllModals();
            this.showModalHabit = true;
        },
        openEditTask(task) {
            this.closeAllModals(); // Закрываем все модальные окна
            this.editTask = { ...task };
            this.showModalEditTask = true;
        },
        openEditHabit(habit) {
            this.closeAllModals(); // Закрываем все модальные окна
            this.editHabit = { ...habit };
            this.showModalEditHabit = true;
        },
        closeModal() {
            this.showModalTask = false;
            this.showModalHabit = false;
            this.showModalEditHabit = false;
            this.showModalEditTask = false;

        },
        closeAllModals() {
            this.showModalTask = false;
            this.showModalHabit = false;
            this.showModalEditTask = false;
            this.showModalEditHabit = false;
        },
        updateTask() {
            this.$inertia.put(`/tasks/${this.editTask.id}`, {
                name: this.editTask.name
            }, {
                preserveScroll: true,
                onSuccess: () => {
                    this.showModalEditTask = false;
                    this.editTask = null;
                    this.$inertia.reload();
                }
            });
        },
        updateHabit() {
            this.$inertia.put(`/habits/${this.editHabit.id}`, {
                name: this.editHabit.name
            }, {
                preserveScroll: true,
                onSuccess: () => {
                    this.showModalEditHabit = false;
                    this.editHabit = null;
                    this.$inertia.reload();
                }
            });
        },
        completeTask(TaskId) {
            this.$inertia.delete(`/tasks/${TaskId}`,{
                preserveScroll: true,
                onSuccess: () => {
                    this.$inertia.reload();
                    this.ADD_EXPERIENCE(10); // Начисление 10 единиц опыта за выполнение задачи
                }
            })
        },

        deleteTask(TaskId) {
            if (confirm("Вы уверены, что хотите удалить эту задачу?")) {
                this.$inertia.delete(`/tasks/${TaskId}`, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.$inertia.reload();
                    }
                });
            }
        },
        deleteHabit(HabitId) {
            if (confirm("Вы уверены, что хотите удалить эту привычку?")) {
                this.$inertia.delete(`/habits/${HabitId}`, {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.$inertia.reload();
                    }
                });
            }
        },
        async addExperienceForHabit(habitId) {
            const experienceGained = 10; // Количество опыта за выполнение привычки
            try {
                const response = await axios.post('/habits/add-experience', { habitId, experienceGained });
                const { experience, level } = response.data;
                this.ADD_EXPERIENCE(experienceGained); // Обновляем опыт в состоянии Vuex
                // Обновляем счетчик выполнений привычки на фронтенде
                this.habits = this.habits.map(habit => {
                    if (habit.id === habitId) {
                        habit.completion_count++;
                    }
                    return habit;
                });
            } catch (error) {
                console.error('Error adding experience:', error);
            }
        },
    },
    layout:Layout
};
</script>

<template>
    <div class="box-content min-h-screen w-4/5 m-auto bg-bg-grey-custom text-white flex items-start content-center rounded-t-3xl">

        <div class="box-content min-h-screen w-4/5 m-auto bg-bg-grey-custom text-white flex items-start content-center rounded-t-3xl">

            <div class="">
                <p class="ml-10 mt-6 mb-5 font-semibold text-white text-3xl">Привычки</p>
                <button @click="openAddHabitModal" class="border-4 border-solid border-white ml-12 w-96 h-16 bg-bg-grey-custom hover:bg-purple-header text-white font-semibold text-xl rounded-t-3xl ">+ Добавить</button>
                    <div class="box-content border-2 bg-black-header ml-12 rounded-b-lg min-h-32">
                        <div v-for="habit in habits" :key="habit.id" class="flex justify-center items-center mt-10 mb-5">
                            <! --Блок привычки-->
                            <div class="box-content min-h-20 bg-white flex font-semibold text-xl rounded-lg items-center text-slate-600 w-80">
                                <! --Plus-->
                                <div class="flex items-center bg-purple-header rounded-l-lg p-6 h-full">
                                    <button @click="addExperienceForHabit(habit.id)" class="w-10 h-10 font-semibold text-black text-3xl flex justify-center rounded-full bg-white hover:bg-gradient-to-r from-purple-plus from-10% cian-header via-40% to-cian-header to-100%">+</button>
                                </div>
                                <span class="w-full p-2 font-semibold">{{habit.name}}</span>
                                <span class="mr-4 text-green-500 font-semibold">+{{ habit.completion_count }}</span>
                                <button @click="openEditHabit(habit)" class="text-yellow-500 text-base mr-2">
                                    <font-awesome-icon icon="edit" />
                                </button>
                                <button @click="deleteHabit(habit.id)" class="text-red-500 text-base mr-2">
                                    <font-awesome-icon icon="trash" />
                                </button>
                            </div>
                        </div>
                    </div>
            </div>

            <div class="">
                <p class="ml-10 mt-6 mb-5 font-semibold text-white text-3xl">Задачи</p>
                <button @click="openAddTaskModal()" class="border-4 border-solid border-white ml-12 w-96 h-16 bg-bg-grey-custom hover:bg-purple-header text-white font-semibold text-xl rounded-t-3xl ">+ Добавить</button>
                <div class="box-content border-2 bg-black-header ml-12 rounded-b-lg min-h-32">
                    <div v-for="task in tasks" :key="task.id" class="flex justify-center items-center mt-10 mb-5">
                        <! --Блок задачи-->
                        <div class="box-content min-h-20 bg-white flex font-semibold text-xl rounded-lg items-center text-slate-600 w-80">
                            <! --CheckBox-->
                            <div class="flex items-center bg-cian-header rounded-l-lg p-6 h-full">
                                <input type="checkbox" class="w-10 h-9" @change="completeTask(task.id)">
                            </div>
                            <span class="w-full p-2 font-semibold">{{task.name}}</span>
                            <button @click="openEditTask(task)" class="text-yellow-500 text-base mr-2">
                                <font-awesome-icon icon="edit" />
                            </button>
                            <button @click="deleteTask(task.id)" class="text-red-500 text-base mr-2">
                                <font-awesome-icon icon="trash" />
                            </button>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Модальное окно для добавления ЗАДАЧИ -->
            <div v-if="showModalTask" class="modal">

                <div class="modal-content mt-20 bg-black-header box-content ml-28 rounded-lg h-64 w-56 p-4 border-2 relative">
                    <div class="text-base font-semibold text-white ml-4">
                        <p>Добавление задачи</p>
                    </div>
                    <!-- Кнопка для закрытия модального окна -->
                    <button class="close-button absolute bg-bg-grey-custom w-8 h-8 top-0 rounded-tr-lg left-56" @click="closeModal">&times;</button>

                    <div class="flex items-center justify-center h-16 mt-10 border-4 font-semibold text-white">
                        <input v-model="newTaskName" type="text" class="bg-bg-grey-custom text-white w-full h-full text-center" placeholder="Введите название задачи">
                    </div>

                    <button class="bg-bg-grey-custom mt-16 w-32 h-12 ml-12 border-4 flex items-center justify-center" @click="addTask">
                        <p class="font-semibold text-white text-sm">+Добавить</p>
                    </button>
                </div>
            </div>

            <!-- Модальное окно для добавления ПРИВЫЧКИ -->
            <div v-if="showModalHabit" class="modal">
                <div class="modal-content mt-20 bg-black-header box-content ml-28 rounded-lg h-64 w-56 p-4 border-2 relative">
                    <div class="text-base font-semibold text-white ml-4">
                        <p>Добавление привычки</p>
                    </div>
                    <!-- Кнопка для закрытия модального окна -->
                    <button class="close-button absolute bg-bg-grey-custom w-8 h-8 top-0 rounded-tr-lg left-56" @click="closeModal">&times;</button>

                    <div class="flex items-center justify-center h-16 mt-10 border-4 font-semibold text-white">
                        <input v-model="newHabitName" type="text" class="bg-bg-grey-custom text-white w-full h-full text-center" placeholder="Введите название привычки">
                    </div>

                    <button class="bg-bg-grey-custom mt-16 w-32 h-12 ml-12 border-4 flex items-center justify-center" @click="addHabit">
                        <p class="font-semibold text-white text-sm">+Добавить</p>
                    </button>
                </div>
            </div>

            <!-- Модальное окно для редактирования задачи -->
            <div v-if="showModalEditTask" class="modal">
                <div class="modal-content mt-20 bg-black-header box-content ml-28 rounded-lg h-64 w-56 p-4 border-2 relative">
                    <div class="text-base font-semibold text-white ml-4">
                        <p>Редактирование задачи</p>
                    </div>
                    <button class="close-button absolute bg-bg-grey-custom w-8 h-8 top-0 rounded-tr-lg left-56" @click="closeModal">&times;</button>
                    <div class="flex items-center justify-center h-16 mt-10 border-4 font-semibold text-white">
                        <input v-model="editTask.name" type="text" class="bg-bg-grey-custom text-white w-full h-full text-center" placeholder="Введите название задачи">
                    </div>
                    <button class="bg-bg-grey-custom mt-16 w-32 h-12 ml-12 border-4 flex items-center justify-center" @click="updateTask">
                        <p class="font-semibold text-white text-sm">Обновить</p>
                    </button>
                </div>
            </div>

            <!-- Модальное окно для редактирования привычки -->
            <div v-if="showModalEditHabit" class="modal">
                <div class="modal-content mt-20 bg-black-header box-content ml-28 rounded-lg h-64 w-56 p-4 border-2 relative">
                    <div class="text-base font-semibold text-white">
                        <p>Редактирование привычки</p>
                    </div>
                    <button class="close-button absolute bg-bg-grey-custom w-8 h-8 top-0 rounded-tr-lg left-56" @click="closeModal">&times;</button>
                    <div class="flex items-center justify-center h-16 mt-10 border-4 font-semibold text-white">
                        <input v-model="editHabit.name" type="text" class="bg-bg-grey-custom text-white w-full h-full text-center" placeholder="Введите название привычки">
                    </div>
                    <button class="bg-bg-grey-custom mt-16 w-32 h-12 ml-12 border-4 flex items-center justify-center" @click="updateHabit">
                        <p class="font-semibold text-white text-sm">Обновить</p>
                    </button>
                </div>
            </div>


        </div>

    </div>
</template>





