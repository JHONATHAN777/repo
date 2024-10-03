<template>
    <div class="container mt-4">
      <h1>Notas</h1>
      <button class="btn btn-success" @click="openModal()">Crear Nota</button>
      <div class="row mt-3">
        <div class="col-md-4" v-for="nota in notas" :key="nota.id">
          <div class="card">
            <img v-if="nota.image" :src="`http://127.0.0.1:8000/storage/${nota.image}`" class="card-img-top" alt="Nota Imagen" />
            <div class="card-body">
              <h5 class="card-title">{{ nota.title }}</h5>
              <p class="card-text">{{ nota.description }}</p>
              <p class="card-text"><strong>Usuario:</strong> {{ getUsuarioNombre(nota.user_id) }}</p>
              <button class="btn btn-primary" @click="editNota(nota)">Editar</button>
              <button class="btn btn-danger" @click="deleteNota(nota.id)">Eliminar</button>
            </div>
          </div>
        </div>
      </div>
      <CreateEditModal
        :nota="selectedNota"
        :usuarios="usuarios"
        @close="closeModal"
        v-if="isModalOpen"
      />
    </div>
  </template>
  
  <script>
  import CreateEditModal from './CreateEditModal.vue';
  import api from '../services/api.js';
  
  export default {
    components: {
      CreateEditModal,
    },
    data() {
      return {
        notas: [],
        usuarios: [],
        selectedNota: null,
        isModalOpen: false,
      };
    },
    mounted() {
      this.fetchNotas();
      this.fetchUsuarios();
    },
    methods: {
      async fetchNotas() {
        const response = await api.get('/notas');
        this.notas = response.data;
      },
      async fetchUsuarios() {
        const response = await api.get('/usuarios'); // Asumiendo que tienes un endpoint para usuarios
        this.usuarios = response.data;
      },
      openModal() {
        this.selectedNota = null;
        this.isModalOpen = true;
      },
      closeModal() {
        this.isModalOpen = false;
        this.fetchNotas();
      },
      editNota(nota) {
        this.selectedNota = nota;
        this.isModalOpen = true;
      },
      async deleteNota(notaId) {
        await api.delete(`/notas/${notaId}`);
        this.fetchNotas();
      },
      getUsuarioNombre(userId) {
        const usuario = this.usuarios.find((user) => user.id === userId);
        return usuario ? usuario.name : 'Desconocido';
      },
    },
  };
  </script>
  
  <style scoped>
  .card-img-top {
    max-height: 200px;
    object-fit: cover;
  }
  </style>
  