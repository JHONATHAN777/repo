import axios from 'axios';

const api = axios.create({
  baseURL: 'http://localhost:8000/api', // Cambia esto según tu configuración
  headers: {
    'Authorization': `Bearer ${localStorage.getItem('token')}`, // Agregar token a cada solicitud
  },
});

export default api;
