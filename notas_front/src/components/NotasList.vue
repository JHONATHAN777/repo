<template>
    <div class="notas-container">
      <div class="nota-card" v-for="nota in notas" :key="nota.id">
        <img v-if="nota.image" :src="getImageUrl(nota.image)" alt="Nota Image" class="nota-image" />
        <h3>{{ nota.title }}</h3>
        <p>{{ nota.description }}</p>
        <button @click="openModal(nota)">Ver Detalle</button>
      </div>
  
      <modal v-if="selectedNota" @close="selectedNota = null">
        <template v-slot:header>
          <h3>{{ selectedNota.title }}</h3>
        </template>
        <template v-slot:body>
          <img v-if="selectedNota.image" :src="getImageUrl(selectedNota.image)" alt="Nota Image" class="modal-image" />
          <p>{{ selectedNota.description }}</p>
        </template>
        <template v-slot:footer>
          <button @click="editNota(selectedNota)">Editar</button>
          <button @click="deleteNota(selectedNota.id)">Eliminar</button>
        </template>
      </modal>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        notas: [],
        selectedNota: null,
      };
    },
    methods: {
      getImageUrl(imagePath) {
        return `${process.env.VUE_APP_API_URL}/storage/${imagePath}`;
      },
      openModal(nota) {
        this.selectedNota = nota;
      },
      fetchNotas() {
        fetch(`${process.env.VUE_APP_API_URL}/api/notas`)
          .then(response => response.json())
          .then(data => {
            this.notas = data;
          });
      },
      mounted() {
        this.fetchNotas();
      },
    },
  };
  </script>
  