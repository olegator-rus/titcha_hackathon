const getters = {

    // Получение списка всех счетов
    // для вывода в качестве
    // «select» списка
    ACCOUNT_SELECT_LIST: (state) => {
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
