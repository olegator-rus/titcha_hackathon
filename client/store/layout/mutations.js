const mutations = {

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
