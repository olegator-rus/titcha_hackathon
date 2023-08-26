const getters = {

    // Получение данных
    // определенной карты
    CARD: (state) => {
        return state.card;
    },

    // Получение списка всех карт
    CARDS_LIST: (state) => {
        return state.list;
    },

    // Получить количество всех карт
    CARDS_COUNT: (state) => {
        return state.list.length;
    },

    // Получить количество всех карт
    CARDS_FORMATTED_LIST: (state) => {
        let cards = [];
        state.list.forEach(card => {
            cards.push({
                cardAmount: card.account.balance,
                cardIban: card.account.iban,
                cardCurrency: card.account.currency.code,
                cardName: card.cardholder,
                cardNumber: card.number,
                cardMonth: state.card.expiration_date?.split("/")[0],
                cardYear: state.card.expiration_date?.split("/")[1],
                cardCvv: card.cvc
            });
        });
        return cards;
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
