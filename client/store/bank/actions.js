const actions = {

    // Загрузить список всех транзакций
    async getAllBanks({ commit }) {
        const res = await this.$axios({
            url: `bank/all`,
            method: 'get'
        });
        const data = res.data.data;
        commit('banksListUpdate', data);
    },

    // Загрузить информацию об
    // определенном банке
    async getBank({ commit }, id) {
        const res = await this.$axios({
            url: `bank/get`,
            method: 'get',
            params: {
                id: id
            }
        });
        const data = res.data.data;
        commit('bankUpdate', data);
    },

    // Обновить данные текущего банка в системе
    async updateBank({ commit, dispatch }, data) {
        commit('startLoading');
        const res = await this.$axios({
            url: `bank/update`,
            method: 'patch',
            data: data
        });
        commit('finishLoading');
    },

    // Удалить данные определенного
    // банка в системе
    async deleteBank({ commit }, id) {
        const res = await this.$axios({
            url: `bank/remove`,
            method: 'delete',
            params: {
                id: id
            }
        });
    },

}

export default actions;
