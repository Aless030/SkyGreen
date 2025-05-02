// utils.js

function extraerLatLngDePoint(str) {
    const match = str.match(/POINT\((-?\d+\.?\d*) (-?\d+\.?\d*)\)/);
    if (!match) return null;
    return { lng: parseFloat(match[1]), lat: parseFloat(match[2]) };
  }
  
  function formatearCoordenadasParaSQL(lng, lat) {
    return `POINT(${lng} ${lat})`;
  }
  
  function validarDatosArbol({ especie, edad, estado, altura, diametroTronco }) {
    if (!especie || especie.trim() === '') return false;
    if (!Number.isInteger(edad) || edad <= 0) return false;
    if (!['peligrosos', 'protegido', 'nativo'].includes(estado)) return false;
    if (isNaN(altura) || altura <= 0) return false;
    if (isNaN(diametroTronco) || diametroTronco <= 0) return false;
    return true;
  }
  
  module.exports = {
    extraerLatLngDePoint,
    formatearCoordenadasParaSQL,
    validarDatosArbol
  };
  