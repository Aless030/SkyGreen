const { validarDatosArbol } = require('./especie');

test('valida datos correctos de un árbol', () => {
  const arbol = {
    especie: 'Jacarandá',
    edad: 10,
    estado: 'nativo',
    altura: 3.5,
    diametroTronco: 25.0,
    reportes:11
  };
  expect(validarDatosArbol(arbol)).toBe(true);
});

test('detecta datos inválidos (edad negativa)', () => {
  const arbol = {
    especie: 'Jacarandá',
    edad: -2,
    estado: 'nativo',
    altura: 3.5,
    diametroTronco: 25.0,
    reportes:5
  };
  expect(validarDatosArbol(arbol)).toBe(false);
});
