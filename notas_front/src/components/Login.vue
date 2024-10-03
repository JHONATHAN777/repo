<template>
    <div class="container mt-4">
      <h1>Iniciar Sesión</h1>
      <form @submit.prevent="login">
        <div class="form-group">
          <label for="email">Correo Electrónico</label>
          <input type="email" class="form-control" v-model="email" required />
        </div>
        <div class="form-group">
          <label for="password">Contraseña</label>
          <input type="password" class="form-control" v-model="password" required />
        </div>
        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
      </form>
    </div>
  </template>
  
  <script>
  import api from '../services/api.js';
  
  export default {
    data() {
      return {
        email: '',
        password: '',
      };
    },
    methods: {
      async login() {
        try {
          const response = await api.post('/login', {
            email: this.email,
            password: this.password,
          });
          localStorage.setItem('token', response.data.token); // Almacenar token
          this.$router.push('/'); // Redirigir a la página principal
        } catch (error) {
          alert('Error de inicio de sesión. Verifica tus credenciales.');
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Estilos específicos para el login aquí */
  </style>
  