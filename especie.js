function validarDatosArbol({ especie, edad, estado, altura, diametroTronco,reportes}) {
    if (!especie || especie.trim() === '') return false;
    if (!Number.isInteger(edad) || edad <= 0) return false;
    if (!['peligrosos', 'protegido', 'nativo'].includes(estado)) return false;
    if (isNaN(altura) || altura <= 0) return false;
    if (isNaN(diametroTronco) || diametroTronco <= 0) return false;
    if(!Number.isInteger(reportes)|| reportes<=10) return false;
    return true;
  }
  
  module.exports = { validarDatosArbol };
  