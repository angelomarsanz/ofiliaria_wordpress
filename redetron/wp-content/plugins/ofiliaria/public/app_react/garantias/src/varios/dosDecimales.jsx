export const dosDecimales = (numero) => {
    return Number(Math.round(numero+'e'+2)+'e-'+2);
}