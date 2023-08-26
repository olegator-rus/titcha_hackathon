const getters = {

    // Получение списка всех валют
    CURRENCIES_LIST: (state) => {
        return state.list;
    },

    // Получение данных определенного курса
    GET_RATE: (state) => (code) => {
        return state.rates[code];
    },

    // Получение списка всех курсов валют
    RATES_LIST: (state) => {
        return state.rates;
    },

    // Получить количество всех валют
    CURRENCIES_COUNT: (state) => {
        return state.list.length;
    },

    // Получение списка всех валют
    // для вывода в качестве
    // «select» списка
    CURRENCIES_SELECT_LIST: (state) => {
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
