const getters = {


    // Получение списка всех транзакций
    HISTORY_LIST: (state) => {
        return state.list;
    },

    // Получить количество всех транзакций
    HISTORY_COUNT: (state) => {
        return state.list.length;
    },

    // Получение статуса загрузки экшена
    LOADING_STATUS: (state) => {
        return state.loading;
    },

    // Получаение статуса загрузки модуля
    PRELOADER_STATUS: (state) =>{
        return state.preloader;
    }

}

export default getters;
