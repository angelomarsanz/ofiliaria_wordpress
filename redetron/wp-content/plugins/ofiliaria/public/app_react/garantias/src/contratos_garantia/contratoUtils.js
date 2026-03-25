export const convertirANumeroRomanoEnLetras = (num) => {
    if (num < 1 || num > 39) {
        return num.toString();
    }
    const unidades = ["", "PRIMERO", "SEGUNDO", "TERCERO", "CUARTO", "QUINTO", "SEXTO", "SÉPTIMO", "OCTAVO", "NOVENO"];
    const especiales = {
        10: "DÉCIMO",
        11: "UNDÉCIMO",
        12: "DUODÉCIMO",
        20: "VIGÉSIMO",
        30: "TRIGÉSIMO"
    };

    if (especiales[num]) {
        return especiales[num];
    }

    if (num > 12 && num < 20) {
        return `DÉCIMO ${unidades[num % 10]}`;
    }

    if (num > 20 && num < 30) {
        return `VIGÉSIMO ${unidades[num % 10]}`;
    }
    
    if (num > 30 && num < 40) {
        return `TRIGÉSIMO ${unidades[num % 10]}`;
    }

    return unidades[num];
};

export const generarClausulaAdicional = (texto, numero) => {
    if (!texto) {
        return '';
    }
    const numeroEnLetras = convertirANumeroRomanoEnLetras(numero);
    return `<p style="margin: 0; padding: 0;">${numeroEnLetras}.- ${texto}</p>`;
};
