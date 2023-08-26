export default function ({ store, redirect }) {
    // В других случаях выбираем первую ссылку, из меню
    // для роли пользователя и переадресовываем его на нее.
    return (async () => {
        // Если не установлен токен текущего проекта,
        // перенаправляем пользователя на страницу выбора проекта.
        const projectId = localStorage.getItem("project-id");

        // Получить список активированных модулей
        await store.dispatch('connection/checkConnection', projectId);

        // Переадресация на страницу подключения
        if(store.getters["connection/CONNECT_STATUS"]){
            return redirect('/');
        }
      })();
}
