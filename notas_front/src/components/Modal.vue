<template>
    <div class="modal-overlay" @click.self="close">
      <div class="modal-content">
        <header>
          <h2>{{ isEdit ? 'Editar Nota' : 'Crear Nota' }}</h2>
          <button @click="close" class="close-button">×</button>
        </header>
        <div class="modal-body">
          <form @submit.prevent="submit">
            <div>
              <label for="title">Título</label>
              <input type="text" v-model="form.title" required />
            </div>
            <div>
              <label for="description">Descripción</label>
              <textarea v-model="form.description" required></textarea>
            </div>
            <div>
              <label for="user_id">Usuario</label>
              <select v-model="form.user_id" required>
                <option v-for="user in users" :key="user.id" :value="user.id">
                  {{ user.name }}
                </option>
              </select>
            </div>
            <div>
              <label for="due_date">Fecha de Vencimiento</label>
              <input type="date" v-model="form.due_date" />
            </div>
            <div>
              <label for="image">Imagen</label>
              <input type="file" @change="handleFileUpload" />
            </div>
            <button type="submit">{{ isEdit ? 'Actualizar' : 'Crear' }}</button>
          </form>
        </div>
        <footer>
          <button @click="close">Cerrar</button>
        </footer>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      isEdit: {
        type: Boolean,
        default: false,
      },
      nota: {
        type: Object,
        default: () => ({}),
      },
      users: {
        type: Array,
        default: () => [],
      },
    },
    data() {
      return {
        form: {
          title: this.nota.title || '',
          description: this.nota.description || '',
          user_id: this.nota.user_id || '',
          due_date: this.nota.due_date || '',
          image: null,
        },
      };
    },
    methods: {
      close() {
        this.$emit('close');
      },
      handleFileUpload(event) {
        this.form.image = event.target.files[0];
      },
      async submit() {
        const formData = new FormData();
        Object.entries(this.form).forEach(([key, value]) => {
          formData.append(key, value);
        });
  
        if (this.isEdit) {
          await this.$http.put(`/api/notas/${this.nota.id}`, formData);
        } else {
          await this.$http.post('/api/notas', formData);
        }
        this.close();
        this.$emit('refresh'); // Emitir evento para actualizar la lista
      },
    },
  };
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .modal-content {
    background: white;
    padding: 20px;
    border-radius: 5px;
    width: 400px; /* Ajustar el ancho según tus necesidades */
  }
  .close-button {
    background: transparent;
    border: none;
    font-size: 1.5em;
  }
  </style>
  