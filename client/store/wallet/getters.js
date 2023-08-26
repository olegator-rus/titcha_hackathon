const getters = {

    // Получение данных
    // определенного кошелька
    WALLET: (state) => {
        return state.event;
    },

    // Получение списка всех кошельков
    WALLETS_LIST: (state) => {
        return state.list;
    },

    // Получить количество всех кошельков
    WALLETS_COUNT: (state) => {
        return state.list.length;
    },

    // Получение списка всех кошельков
    // для вывода в качестве
    // «select» списка
    WALLETS_SELECT_LIST: (state) => {
        let list = [...state.list];
        list.unshift({
            "id": null,
            "name": "Не выбрано"
        });
        return list;
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
