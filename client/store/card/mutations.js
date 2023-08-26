const mutations = {

    // Мутация списка всех карт
    cardsListUpdate(state, data){
        state.list = data;
    },

    // Мутация данных текущей карты
    cardUpdate(state, data){
        state.card = data;
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
