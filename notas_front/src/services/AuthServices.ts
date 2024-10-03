import axios from 'axios';

class AuthService {
  // Cambia la URL base según tu configuración de API
  private static apiUrl = 'http://localhost:8000/api'; // Actualiza según tu configuración

  // Método para iniciar sesión
  static async login(email: string, password: string) {
    try {
      const response = await axios.post(`${this.apiUrl}/login`, {
        email,
        password,
      });
      return response.data;
    } catch (error) {
      if (axios.isAxiosError(error)) {
        throw new Error(error.response?.data?.message || 'Error en la solicitud');
      } else {
        throw new Error('Error desconocido');
      }
    }
  }

  // Método para obtener notas
  static async getNotes() {
    try {
      const response = await axios.get(`${this.apiUrl}/notes`); // Asegúrate de que esta sea la ruta correcta
      return response.data;
    } catch (error) {
      throw new Error('Error al obtener notas');
    }
  }
}

export default AuthService;
