export default function ({ store, redirect }) {

    // Если не установлен токен текущего проекта,
    // перенаправляем пользователя на страницу выбора проекта.
    const projectId = localStorage.getItem("project-id");
    if(!projectId) return redirect('/selector');

}
