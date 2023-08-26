const actions = {

    // Загрузить список всех транзакций
    async getMyAccounts({ commit }) {
        const res = await this.$axios({
            url: `account/my`,
            method: 'get'
        });
        const data = res.data.data;
        commit('accountsListUpdate', data);
    },

    // Пополнить определенный кошелек
    async topupAccount({ commit, dispatch }, data) {
        commit('startLoading');
        const res = await this.$axios({
            url: `account/topup`,
            method: 'post',
            data: data
        });
        commit('finishLoading');
    },

}

export default actions;
