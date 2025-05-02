// utils.test.js

const {
    extraerLatLngDePoint,
    formatearCoordenadasParaSQL,
    validarDatosArbol
  } = require('./utils');
  
  
  
  test('devuelve null si el formato es inválido', () => {
    expect(extraerLatLngDePoint('invalid')).toBe(null);
  });
  
  test('formatea correctamente coordenadas para MySQL', () => {
    expect(formatearCoordenadasParaSQL(-66.1577, -17.3745)).toBe('POINT(-66.1577 -17.3745)');
  });
  
  test('valida datos correctos de un árbol', () => {
    const arbol = {
      especie: 'Jacarandá',
      edad: 10,
      estado: 'nativo',
      altura: 3.5,
      diametroTronco: 25.0
    };
    expect(validarDatosArbol(arbol)).toBe(true);
  });
  
  test('detecta datos inválidos (edad negativa)', () => {
    const arbol = {
      especie: 'Jacarandá',
      edad: -2,
      estado: 'nativo',
      altura: 3.5,
      diametroTronco: 25.0
    };
    expect(validarDatosArbol(arbol)).toBe(false);
  });
  