const actions = {

    // Загрузить список всех кошельков
    async getMyWallets({ commit }) {
        const res = await this.$axios({
            url: `wallet/my`,
            method: 'get'
        });
        const data = res.data.data;
        commit('walletsListUpdate', data);
    },

    // Загрузить информацию об
    // определенном кошельке
    async getWallet({ commit }, id) {
        const res = await this.$axios({
            url: `wallet/my`,
            method: 'get',
            params: {
                id: id
            }
        });
        const data = res.data.data;
        commit('walletUpdate', data);
    },

    // Создать в системе новой кошелек
    async createWallet({ commit, dispatch }, data) {
        commit('startLoading');
        const res = await this.$axios({
            url: `wallet/create`,
            method: 'post',
            data: data
        });
        commit('finishLoading');
        return res;
    },

}

export default actions;
