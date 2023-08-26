// Плагин добавляющий вывод ошибок при неудачном actions
// ошибки выводятся с помощью vue-toastification
export default ({ $axios, $auth, store, redirect }) => {
  $axios.onRequest(config => {
    let projectId = localStorage.getItem("project-id");
    if(!projectId) return;
    config.headers.common['project-id'] = projectId;
  });

  // $axios.onResponse(res => {
  //   // Отключаем при передаче флага errors вывод ошибки
  //   if(res.response.config.success == true){
  //     store.$toast.error(res.response.data.message);
  //   }
  // });

  // $axios.onError(err => {
  //   // Отключаем при передаче флага errors вывод ошибки
  //   if(err.response.config.errors == true){
  //       store.$toast.error(err.response.data.message);
  //   }
  // });
}
