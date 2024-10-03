<template>
  <div class="modal fade show" tabindex="-1" role="dialog" style="display: block;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ nota ? 'Editar Nota' : 'Crear Nota' }}</h5>
          <button type="button" class="close" @click="$emit('close')">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form @submit.prevent="submit">
            <div class="form-group">
              <label for="title">Título</label>
              <input
                type="text"
                class="form-control"
                v-model="nota.title"
                required
              />
            </div>
            <div class="form-group">
              <label for="description">Descripción</label>
              <textarea
                class="form-control"
                v-model="nota.description"
                required
              ></textarea>
            </div>
            <div class="form-group">
              <label for="user_id">Usuario</label>
              <select v-model="nota.user_id" class="form-control" required>
                <option disabled value="">Seleccione un usuario</option>
                <option v-for="usuario in usuarios" :key="usuario.id" :value="usuario.id">
                  {{ usuario.name }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label for="due_date">Fecha de Vencimiento</label>
              <input
                type="date"
                class="form-control"
                v-model="nota.due_date"
              />
            </div>
            <div class="form-group">
              <label for="image">Imagen</label>
              <input
                type="file"
                class="form-control"
                @change="onFileChange"
              />
              <img v-if="imagePreview" :src="imagePreview" class="img-thumbnail mt-2" alt="Preview" />
            </div>
            <button type="submit" class="btn btn-primary">
              {{ nota ? 'Actualizar' : 'Crear' }}
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '../services/api.js';

export default {
  props: ['nota', 'usuarios'],
  data() {
    return {
      imagePreview: null,
    };
  },
  methods: {
    onFileChange(event) {
      const file = event.target.files[0];
      if (file) {
        this.nota.image = URL.createObjectURL(file);
        this.imagePreview = this.nota.image;
      }
    },
    async submit() {
      const formData = new FormData();
      formData.append('title', this.nota.title);
      formData.append('description', this.nota.description);
      formData.append('user_id', this.nota.user_id);
      formData.append('due_date', this.nota.due_date);
      if (this.nota.image) {
        const file = this.$refs.image.files[0];
        formData.append('image', file);
      }

      if (this.nota.id) {
        await api.put(`/notas/${this.nota.id}`, formData);
      } else {
        await api.post('/notas', formData);
      }

      this.$emit('close');
    },
  },
};
</script>

<style scoped>
.img-thumbnail {
  max-height: 200px;
  object-fit: cover;
}
</style>
