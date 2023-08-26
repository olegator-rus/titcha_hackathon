export default function ({ store, redirect }) {
    return (async () => {
        // Если не установлен токен текущего проекта,
        // перенаправляем пользователя на страницу выбора проекта.
        const projectId = localStorage.getItem("project-id");

        // Если статус еще не загружен, подгружаем его
        if(store.getters["connection/CONNECT_STATUS"] === null){
            await store.dispatch('connection/checkConnection', projectId);
        }

        // Переадресация на страницу подключения
        if(!store.getters["connection/CONNECT_STATUS"]){
            return redirect('/connection');
        }
    })();
}
