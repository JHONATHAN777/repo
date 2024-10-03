import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';


export default defineConfig({
  plugins: [vue()],
  server: {
    port: 3000, // Cambia esto si es necesario
  },
});
