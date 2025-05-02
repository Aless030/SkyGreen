function esEspecieValida(especie) {
    return typeof especie === 'string' && especie.trim().length > 0;
  }
  
  function estadoPermitido(estado) {
    const permitidos = ['peligrosos', 'protegido', 'nativo'];
    return permitidos.includes(estado);
  }
  
  function crearEtiquetaArbol(especie, edad) {
    return `Árbol: ${especie}, Edad: ${edad} años`;
  }
  function EstadoArbol(estadoar){

    const estadoper=['0','1'];
    return estadoper.includes(estadoar)}

  module.exports = { esEspecieValida, estadoPermitido, crearEtiquetaArbol,EstadoArbol };
  




