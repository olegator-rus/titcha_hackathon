const actions = {

    // Загрузить список всех карт
    async getMyCards({ commit }) {
        const res = await this.$axios({
            url: `card/my`,
            method: 'get'
        });
        const data = res.data.data;
        commit('cardsListUpdate', data);
    },

    // Загрузить информацию об
    // определенной карте
    async getCard({ commit }, id) {
        const res = await this.$axios({
            url: `card/get`,
            method: 'get',
            params: {
                id: id
            }
        });
        const data = res.data.data;
        commit('cardUpdate', data);
    },

    // Создать в системе новую карту
    async createCard({ commit, dispatch }, data) {
        commit('startLoading');
        const res = await this.$axios({
            url: `card/create`,
            method: 'post',
            data: data
        });
        commit('finishLoading');
        return res;
    },

    // Обновить данные текущего банка в системе
    async createTransaction({ commit, dispatch }, data) {
        commit('startLoading');
        const res = await this.$axios({
            url: `card/transaction`,
            method: 'post',
            data: data
        });
        commit('finishLoading');
    },

}

export default actions;
