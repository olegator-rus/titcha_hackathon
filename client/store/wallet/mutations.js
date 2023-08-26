const mutations = {

    // Мутация списка всех кошельков
    walletsListUpdate(state, data){
        state.list = data;
    },

    // Мутация данных текущего кошелька
    walletUpdate(state, data){
        state.wallet = data;
    },

    // Мутация начала загрузки экшена
    startLoading(state){
        state.loading = true;
    },

    // Мутация конца загрузки экшена
    finishLoading(state){
        state.loading = false;
    },

    // Мутация конца загрузки модуля
    activatePreloader(state){
        state.preloader = true;
    },

    // Мутация конца загрузки модуля
    deactivatePreloader(state){
        state.preloader = false;
    }

}

export default mutations;
