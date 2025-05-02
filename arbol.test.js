const { esEspecieValida, estadoPermitido, crearEtiquetaArbol,EstadoArbol } = require('./arbol');

test('verifica si una especie es válida', () => {
  expect(esEspecieValida('Jacarandá')).toBe(true);
  expect(esEspecieValida('')).toBe(false);
});

test('verifica si el estado está permitido', () => {
  expect(estadoPermitido('nativo')).toBe(true);
  expect(estadoPermitido('muerto')).toBe(false);

});

test('crea una etiqueta descriptiva del árbol', () => {
  expect(crearEtiquetaArbol('Ciprés', 20)).toBe('Árbol: Ciprés, Edad: 20 años');
});

test('verificar si el estado es valido',()=>{
    expect(EstadoArbol('0')).toBe(true);
    expect(EstadoArbol('1')).toBe(true);

});



