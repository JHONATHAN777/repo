<template>
    <div>
      <h1>Lista de Notas</h1>
      <button @click="openModal(false)">Crear Nota</button>
      <div v-for="nota in notas" :key="nota.id" class="nota-card">
        <h2>{{ nota.title }}</h2>
        <p>{{ nota.description }}</p>
        <img v-if="nota.image" :src="`http://127.0.0.1:8000/storage/images/${nota.image}`" alt="Nota Imagen" />
        <button @click="openModal(true, nota)">Editar Nota</button>
      </div>
  
      <Modal v-if="showModal" :isEdit="isEdit" :nota="selectedNota" :users="users" @close="closeModal" @refresh="fetchNotas" />
    </div>
  </template>
  
  <script>
  import Modal from './Modal.vue';
  
  export default {
    components: {
      Modal,
    },
    data() {
      return {
        notas: [],
        users: [],
        showModal: false,
        isEdit: false,
        selectedNota: null,
      };
    },
    methods: {
      async fetchNotas() {
        const response = await this.$http.get('/api/notas');
        this.notas = response.data;
      },
      async fetchUsers() {
        const response = await this.$http.get('/api/usuarios');
        this.users = response.data;
      },
      openModal(edit, nota = null) {
        this.isEdit = edit;
        this.selectedNota = nota;
        this.showModal = true;
      },
      closeModal() {
        this.showModal = false;
        this.selectedNota = null;
      },
    },
    mounted() {
      this.fetchNotas();
      this.fetchUsers();
    },
  };
  </script>
  
  <style scoped>
  .nota-card {
    border: 1px solid #ccc;
    padding: 10px;
    margin: 10px 0;
  }
  </style>
  