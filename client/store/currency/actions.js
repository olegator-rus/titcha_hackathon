const actions = {

    // Загрузить список всех транзакций
    async getAllCurrencies({ commit }) {
        const res = await this.$axios({
            url: `currency/all`,
            method: 'get'
        });
        const data = res.data.data;
        commit('currenciesListUpdate', data);
    },

    // Загрузить список всех транзакций
    async getAllRates({ commit }) {
        const res = await this.$axios({
            url: `currency/rates`,
            method: 'get'
        });
        const data = res.data.data;
        commit('ratesListUpdate', data);
    },

}

export default actions;
