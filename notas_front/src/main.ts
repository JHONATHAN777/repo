import { createApp } from 'vue';
import App from './App.vue';
import router from './router'; // Importar el enrutador
import 'bootstrap/dist/css/bootstrap.min.css'; // Importar Bootstrap
import 'bootstrap'; // Importar JS de Bootstrap

createApp(App)
  .use(router) // Usar el enrutador
  .mount('#app');
