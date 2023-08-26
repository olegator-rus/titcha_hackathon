const getters = {

    // Получение выбранного банка
    BANK: (state) => {
        return state.bank;
    },

    // Получение списка всех банков
    BANKS_LIST: (state) => {
        return state.list;
    },

    // Получить количество всех банков
    BANKS_COUNT: (state) => {
        return state.list.length;
    },

    // Получение списка всех банков
    // для вывода в качестве
    // «select» списка
    BANKS_SELECT_LIST: (state) => {
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
