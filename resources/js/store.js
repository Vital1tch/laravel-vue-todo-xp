import { createStore } from 'vuex';

export default createStore({
    state: {
        experience: 0,
        level: 1
    },
    mutations: {
        SET_EXPERIENCE(state, experience) {
            state.experience = experience;
        },
        SET_LEVEL(state, level) {
            state.level = level;
        },
        ADD_EXPERIENCE(state, amount) {
            let levelUpExperience = 100;
            for (let i = 1; i < state.level; i++) {
                levelUpExperience *= 1.5;
            }
            state.experience += amount;
            while (state.experience >= levelUpExperience) {
                state.experience -= levelUpExperience;
                state.level++;
                levelUpExperience *= 1.5;
            }
        },

        RESET_PROGRESS(state) {
            state.experience = 0;
            state.level = 1;
        }
    },
    getters: {
        nextLevelExperience(state) {
            let levelUpExperience = 100;
            for (let i = 1; i < state.level; i++) {
                levelUpExperience *= 1.5;
            }
            return levelUpExperience;
        },
        experiencePercentage(state, getters) {
            return (state.experience / getters.nextLevelExperience) * 100;
        }
    },
    actions: {
        addExperienceForHabit({ commit }, experienceGained) {
            commit('ADD_EXPERIENCE', experienceGained);
        },
    },
});

