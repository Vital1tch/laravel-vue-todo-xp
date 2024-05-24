<script>

import { mapState, mapGetters } from 'vuex';
import axios from 'axios';
import { Link } from '@inertiajs/inertia-vue3'
    export default {
    props: {
        tasks: {
            type: Array,
            required: true,
        },
        habits: {
            type: Array,
            required: true,
        },
        user: {
            type: Object,
            required: true,
        }
    },
        components: {
        Link,
        },
        computed: {
            ...mapState(['experience', 'level']),
            ...mapGetters(['nextLevelExperience', 'experiencePercentage'])
        },

        methods: {
            resetProgress() {
                axios.post('/reset-progress').then(() => {
                    this.$store.commit('RESET_PROGRESS');
                }).catch(error => {
                    console.error('Error resetting progress:', error);
                });
            },
            addExperienceForHabit(habitId) {
                const experienceGained = 10; // Количество опыта за выполнение привычки
                axios.post('/habits/add-experience', { habitId, experienceGained })
                    .then(response => {
                        this.$store.commit('SET_EXPERIENCE', response.data.experience);
                        this.$store.commit('SET_LEVEL', response.data.level);
                    })
                    .catch(error => {
                        console.error('Error adding experience:', error);
                    });
            }
        },

        mounted() {
            // Получаем данные из сессии при загрузке компонента
            axios.get('/api/user-progress').then(response => {
                this.$store.commit('SET_EXPERIENCE', response.data.experience);
                this.$store.commit('SET_LEVEL', response.data.level);
            });
        }
    }
</script>

<template>
    <div class="bg-gradient-to-r from-purple-header from-50% black-header via-100% to-cian-header to-100% w-4/5 m-auto mt-14 rounded-t-2xl">

        <header class="flex justify-between px-8 py-5">

            <div class="flex items-center">
                <img src="/public/Photos/Logo.png" alt="Logo" class="w-13 mr-3" />
                <div>
                    <h2 class="text-3xl font-semibold text-white">Task sculptor</h2>
                    <p class="font-semibold-regular text-slate-500">Ваяй свою продуктивность</p>
                </div>
            </div>

            <ul class="flex items-center gap-14 text-white text-xl">
                <li class="flex items-center gap-3 mr-6 text-2xl font-semibold cursor-pointer hover:text-indigo-400">
                    <a href="/" class="">Задачи</a>
                </li>

                <li class="flex items-center gap-3 mr-4 text-2xl font-semibold cursor-pointer hover:text-indigo-400">
                    <a href="/about" class="">О нас</a>
                </li>
            </ul>
        </header>
    </div>

    <div class="w-4/5 m-auto mt-6 px-6 flex items-center ">

        <div class="pb-10">
            <img src="/public/Photos/avatar.png" alt="Avatar">
        </div>

        <div class="mb-16 ml-5 w-48 ">
            <div class="font-semibold text-white text-3xl">
                <b>Vitalitch</b>
            </div>
            <div class="flex items-center">
                <div class="mr-10 text-white text-base pt-2 pb-2">
                    <b>Уровень: {{level}}</b><br>
                    <b class="">Опыт: {{experience}}/{{nextLevelExperience}}</b>
                    <div class="bg-white w-32 h-4 rounded-full overflow-hidden">
                        <div class="bg-gradient-to-r from-purple-header from-20% black-header via-100% bg-blue-400 to-39%  h-full" :style="{width: experiencePercentage + '%'}"></div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <slot>

    </slot>
</template>



