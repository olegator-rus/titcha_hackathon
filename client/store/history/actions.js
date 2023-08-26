const actions = {

    // Загрузить список всех транзакций
    async getMyHistory({ commit }) {
        const res = await this.$axios({
            url: `history/my`,
            method: 'get'
        });
        const data = res.data.data;
        commit('historyListUpdate', data);
    },

}

export default actions;
