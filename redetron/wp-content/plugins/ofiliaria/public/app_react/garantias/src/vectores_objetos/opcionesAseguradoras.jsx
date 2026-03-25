import { useTranslation } from 'react-i18next';

export const opcionesAseguradoras = () => {
    const { t } = useTranslation();
    const opcionesAseguradoras = [];

    // Sura
    opcionesAseguradoras['Sura Tipo sueldo Empleado (trabajador dependiente) Fijo'] = t("Últimos tres recibos de sueldo *");
    opcionesAseguradoras['Sura Tipo sueldo Empleado (trabajador dependiente) Variable'] = t("Últimos seis recibos de sueldo *");
    opcionesAseguradoras['Sura Tipo ingreso Jubilado o pensionista'] = t("Último recibo de cobro de jubilación o pensión emitido por la caja oficial correspondiente *");
    opcionesAseguradoras['Sura Porcentaje de ingresos Persona física'] = 0.35;
    opcionesAseguradoras['Sura Porcentaje de ingresos Unipersonal'] = 0.30;
    opcionesAseguradoras['Sura Porcentaje de ingresos Micro-empresario'] = 0.30;
    opcionesAseguradoras['Sura Porcentaje de ingresos Profesional independiente'] = 0.30;
    opcionesAseguradoras['Sura Porcentaje de ingresos Empresa'] = 0.30;
    opcionesAseguradoras['Sura CertUni etiqueta Profesional independiente'] = t("Certificado de estar al día con la Caja Notarial o CJPPU o Profesional según corresponda *");
    opcionesAseguradoras['Sura CertUni etiqueta2 Profesional independiente'] = t('texto_131');
    opcionesAseguradoras['Sura CertUni error Profesional independiente'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sura CertUni etiqueta Unipersonal'] = t("Certificado de estar al día con la Caja Notarial o CJPPU o Profesional según corresponda *");
    opcionesAseguradoras['Sura CertUni etiqueta2 Unipersonal'] = t('texto_131');
    opcionesAseguradoras['Sura CertUni error Unipersonal'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sura ContratoSocial etiqueta Micro-empresario'] = t('texto_34');
    opcionesAseguradoras['Sura ContratoSocial etiqueta2 Micro-empresario'] = t('texto_77');
    opcionesAseguradoras['Sura ContratoSocial error Micro-empresario'] = t("El contrato es requerido");
    opcionesAseguradoras['Sura ContratoSocial etiqueta Empresa'] = t('texto_34');
    opcionesAseguradoras['Sura ContratoSocial etiqueta2 Empresa'] = t('texto_77');
    opcionesAseguradoras['Sura ContratoSocial error Empresa'] = t("El contrato es requerido");
    opcionesAseguradoras['Sura CertIngMod etiqueta Profesional independiente'] = t("Certificado de ingresos *");
    opcionesAseguradoras['Sura CertIngMod etiqueta2 Profesional independiente'] = t('texto_131');
    opcionesAseguradoras['Sura CertIngMod error Profesional independiente'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sura CertIngMod etiqueta Unipersonal'] = t("Certificado de ingresos *");
    opcionesAseguradoras['Sura CertIngMod etiqueta2 Unipersonal'] = t('texto_131');
    opcionesAseguradoras['Sura CertIngMod error Unipersonal'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sura CertIngMod etiqueta Micro-empresario'] = t("Certificado de ingresos *");
    opcionesAseguradoras['Sura CertIngMod etiqueta2 Micro-empresario'] = t('texto_131');
    opcionesAseguradoras['Sura CertIngMod error Micro-empresario'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sura CertIngMod etiqueta Empresa'] = t("Certificado de ingresos *");
    opcionesAseguradoras['Sura CertIngMod etiqueta2 Empresa'] = t('texto_131');
    opcionesAseguradoras['Sura CertIngMod error Empresa'] = t("Certificado(s) requerido(s)");
    
    opcionesAseguradoras['Sura Cantidad personas adicionales'] = 3;

    // Porto
    opcionesAseguradoras['Porto Tipo sueldo Empleado (trabajador dependiente) Fijo'] = t("Últimos tres recibos de sueldo *");
    opcionesAseguradoras['Porto Tipo sueldo Empleado (trabajador dependiente) Variable'] = t("Últimos seis recibos de sueldo *");
    opcionesAseguradoras['Porto Tipo ingreso Jubilado o pensionista'] = t("Último recibo de cobro de jubilación o pensión emitido por la caja oficial correspondiente *");
    opcionesAseguradoras['Porto Porcentaje de ingresos Persona física'] = 0.35;
    opcionesAseguradoras['Porto Porcentaje de ingresos Persona con rentas de alquileres'] = 0.35;
    opcionesAseguradoras['Porto Porcentaje de ingresos Universitario'] = 1;
    opcionesAseguradoras['Porto Porcentaje de ingresos Profesional independiente'] = 0.15;
    opcionesAseguradoras['Porto Porcentaje de ingresos Unipersonal'] = 0.15;
    opcionesAseguradoras['Porto Porcentaje de ingresos Micro-empresario'] = 0.15;
    opcionesAseguradoras['Porto Porcentaje de ingresos Empresa'] = 0.15;
    opcionesAseguradoras['Porto Moneda ingreso Universitario'] = 'UYU';
    opcionesAseguradoras['Porto Monto ingreso Universitario'] = 10000;
    opcionesAseguradoras['Porto ContratoSocial etiqueta Persona con rentas de alquileres'] = t('texto_75');
    opcionesAseguradoras['Porto ContratoSocial etiqueta2 Persona con rentas de alquileres'] = t('texto_77');
    opcionesAseguradoras['Porto ContratoSocial error Persona con rentas de alquileres'] = t("El contrato es requerido");
    opcionesAseguradoras['Porto CertUni etiqueta Persona con rentas de alquileres'] = t('texto_74');
    opcionesAseguradoras['Porto CertUni etiqueta2 Persona con rentas de alquileres'] = t('texto_134');
    opcionesAseguradoras['Porto CertUni error Persona con rentas de alquileres'] = t('texto_78');
    opcionesAseguradoras['Porto CertUni etiqueta Universitario'] = t("Certificado de universidad emitido oficialmente por la universidad *");
    opcionesAseguradoras['Porto CertUni etiqueta2 Universitario'] = t('texto_131');
    opcionesAseguradoras['Porto CertUni error Universitario'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Porto Modelo certificacion ingresos'] = 'https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/modelos/porto_modelo_certificacion_ingresos.pdf';
    opcionesAseguradoras['Porto Balance etiqueta Empresa'] = t("Último balance con informe de compilacion *");
    opcionesAseguradoras['Porto Balance etiqueta2 Empresa'] = t('texto_132');
    opcionesAseguradoras['Porto Balance error Empresa'] = t("Balance(s) requerido(s)");

    opcionesAseguradoras['Porto CertIngMod etiqueta Profesional independiente'] = t('texto_64');
    opcionesAseguradoras['Porto CertIngMod etiqueta2 Profesional independiente'] = t('texto_131');
    opcionesAseguradoras['Porto CertIngMod error Profesional independiente'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Porto CertIngMod etiqueta Unipersonal'] = t('texto_64');
    opcionesAseguradoras['Porto CertIngMod etiqueta2 Unipersonal'] = t('texto_131');
    opcionesAseguradoras['Porto CertIngMod error Unipersonal'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Porto CertIngMod etiqueta Micro-empresario'] = t('texto_64');
    opcionesAseguradoras['Porto CertIngMod etiqueta2 Micro-empresario'] = t('texto_131');
    opcionesAseguradoras['Porto CertIngMod error Micro-empresario'] = t("Certificado(s) requerido(s)");

    opcionesAseguradoras['Porto Cantidad personas adicionales'] = 4;

    // Sancor
    opcionesAseguradoras['Sancor Tipo sueldo Empleado (trabajador dependiente) Fijo'] = t("Últimos tres recibos de sueldo *");
    opcionesAseguradoras['Sancor Tipo sueldo Empleado (trabajador dependiente) Variable'] = t("Último recibo de sueldo *");
    opcionesAseguradoras['Sancor Tipo ingreso Jubilado o pensionista'] = t("Últimos tres recibos de cobro de jubilación o pensión emitidos por la caja oficial correspondiente *");
    opcionesAseguradoras['Sancor Porcentaje de ingresos Persona física'] = 0.35;
    opcionesAseguradoras['Sancor Porcentaje de ingresos Unipersonal'] = 0.30;
    opcionesAseguradoras['Sancor Porcentaje de ingresos Micro-empresario'] = 0.30;
    opcionesAseguradoras['Sancor Porcentaje de ingresos Profesional independiente'] = 0.30;
    opcionesAseguradoras['Sancor Porcentaje de ingresos Socios o accionistas de sociedades comerciales'] = 0.30;
    opcionesAseguradoras['Sancor Balance etiqueta Socios o accionistas de sociedades comerciales'] = t('texto_76');
    opcionesAseguradoras['Sancor Balance etiqueta2 Socios o accionistas de sociedades comerciales'] = t('texto_132');
    opcionesAseguradoras['Sancor Balance error Socios o accionistas de sociedades comerciales'] = t("Balance(s) requerido(s)");
    opcionesAseguradoras['Sancor Modelo certificacion ingresos'] = 'https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/modelos/sancor_modelo_certificacion_ingresos.docx';
    opcionesAseguradoras['Sancor CertUni etiqueta Profesional independiente'] = t("Certificado de estar al día con la Caja Notarial o CJPPU o Profesional según corresponda *");
    opcionesAseguradoras['Sancor CertUni etiqueta2 Profesional independiente'] = t('texto_131');
    opcionesAseguradoras['Sancor CertUni error Profesional independiente'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sancor CertUni etiqueta Unipersonal'] = t("Certificado de estar al día con la Caja Notarial o CJPPU o Profesional según corresponda *");
    opcionesAseguradoras['Sancor CertUni etiqueta2 Unipersonal'] = t('texto_131');
    opcionesAseguradoras['Sancor CertUni error Unipersonal'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sancor CertUni etiqueta Micro-empresario'] = t("Certificado de estar al día con la Caja Notarial o CJPPU o Profesional según corresponda *");
    opcionesAseguradoras['Sancor CertUni etiqueta2 Micro-empresario'] = t('texto_131');
    opcionesAseguradoras['Sancor CertUni error Micro-empresario'] = t("Certificado(s) requerido(s)");

    opcionesAseguradoras['Sancor CertIngMod etiqueta Profesional independiente'] = t('texto_64');
    opcionesAseguradoras['Sancor CertIngMod etiqueta2 Profesional independiente'] = t('texto_131');
    opcionesAseguradoras['Sancor CertIngMod error Profesional independiente'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sancor CertIngMod etiqueta Unipersonal'] = t('texto_64');
    opcionesAseguradoras['Sancor CertIngMod etiqueta2 Unipersonal'] = t('texto_131');
    opcionesAseguradoras['Sancor CertIngMod error Unipersonal'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sancor CertIngMod etiqueta Micro-empresario'] = t('texto_64');
    opcionesAseguradoras['Sancor CertIngMod etiqueta2 Micro-empresario'] = t('texto_131');
    opcionesAseguradoras['Sancor CertIngMod error Micro-empresario'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sancor CertIngMod etiqueta Socios o accionistas de sociedades comerciales'] = t('texto_64');
    opcionesAseguradoras['Sancor CertIngMod etiqueta2 Socios o accionistas de sociedades comerciales'] = t('texto_131');
    opcionesAseguradoras['Sancor CertIngMod error Socios o accionistas de sociedades comerciales'] = t("Certificado(s) requerido(s)");

    opcionesAseguradoras['Sancor Cantidad personas adicionales'] = 3;

    // Mapfre 
    opcionesAseguradoras['Mapfre Tipo sueldo Empleado (trabajador dependiente) Fijo'] = t("Último recibo de sueldo *");
    opcionesAseguradoras['Mapfre Tipo sueldo Empleado (trabajador dependiente) Variable'] = t("Últimos seis recibos de sueldo *");
    opcionesAseguradoras['Mapfre Tipo ingreso Jubilado o pensionista'] = t("Último recibo de cobro de jubilación o pensión emitido por la caja oficial correspondiente *");
    opcionesAseguradoras['Mapfre Porcentaje de ingresos Persona física'] = 0.35;
    opcionesAseguradoras['Mapfre Porcentaje de ingresos Persona con rentas de alquileres'] = 0.35;
    opcionesAseguradoras['Mapfre Porcentaje de ingresos Unipersonal'] = 0.30;
    opcionesAseguradoras['Mapfre Porcentaje de ingresos Micro-empresario'] = 0.30;
    opcionesAseguradoras['Mapfre Porcentaje de ingresos Profesional independiente'] = 0.30;
    opcionesAseguradoras['Mapfre Porcentaje de ingresos Empresa'] = 0.30;
    opcionesAseguradoras['Mapfre Modelo certificacion ingresos'] = 'https://s3.sa-east-1.amazonaws.com/cdn.ofiliaria.com.uy/garantias-uy/modelos/mapfre_modelo_certificacion_ingresos.docx';

    opcionesAseguradoras['Mapfre CertIngMod etiqueta Persona con rentas de alquileres'] = t('texto_64');
    opcionesAseguradoras['Mapfre CertIngMod etiqueta2 Persona con rentas de alquileres'] = t('texto_131');
    opcionesAseguradoras['Mapfre CertIngMod error Persona con rentas de alquileres'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Mapfre CertIngMod etiqueta Profesional independiente'] = t('texto_64');
    opcionesAseguradoras['Mapfre CertIngMod etiqueta2 Profesional independiente'] = t('texto_131');
    opcionesAseguradoras['Mapfre CertIngMod error Profesional independiente'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Mapfre CertIngMod etiqueta Unipersonal'] = t('texto_64');
    opcionesAseguradoras['Mapfre CertIngMod etiqueta2 Unipersonal'] = t('texto_131');
    opcionesAseguradoras['Mapfre CertIngMod error Unipersonal'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Mapfre CertIngMod etiqueta Micro-empresario'] = t('texto_64');
    opcionesAseguradoras['Mapfre CertIngMod etiqueta2 Micro-empresario'] = t('texto_131');
    opcionesAseguradoras['Mapfre CertIngMod error Micro-empresario'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Mapfre CertIngMod etiqueta Empresa'] = t('texto_64');
    opcionesAseguradoras['Mapfre CertIngMod etiqueta2 Empresa'] = t('texto_131');
    opcionesAseguradoras['Mapfre CertIngMod error Empresa'] = t("Certificado(s) requerido(s)");

    opcionesAseguradoras['Mapfre Cantidad personas adicionales'] = 5;

    // Sbi
    opcionesAseguradoras['Sbi Tipo sueldo Empleado (trabajador dependiente) Fijo'] = t("Último recibo de sueldo *");
    opcionesAseguradoras['Sbi Tipo sueldo Empleado (trabajador dependiente) Variable'] = t("Últimos seis recibos de sueldo *");
    opcionesAseguradoras['Sbi Tipo ingreso Jubilado o pensionista'] = t("Último recibo de cobro de jubilación o pensión emitido por la caja oficial correspondiente *");
    opcionesAseguradoras['Sbi Porcentaje de ingresos Empleado (trabajador dependiente)'] = 0.35;
    opcionesAseguradoras['Sbi Porcentaje de ingresos Persona física'] = 0.35;
    opcionesAseguradoras['Sbi Porcentaje de ingresos Unipersonal'] = 0.30;
    opcionesAseguradoras['Sbi Porcentaje de ingresos Micro-empresario'] = 0.30;
    opcionesAseguradoras['Sbi Porcentaje de ingresos Profesional independiente'] = 0.30;
    opcionesAseguradoras['Sbi Porcentaje de ingresos Empresa'] = 0.30;
    opcionesAseguradoras['Sbi CertIngMod etiqueta Profesional independiente'] = t("Certificado de ingresos *");
    opcionesAseguradoras['Sbi CertIngMod etiqueta2 Profesional independiente'] = t('texto_131');
    opcionesAseguradoras['Sbi CertIngMod error Profesional independiente'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sbi CertIngMod etiqueta Unipersonal'] = t("Certificado de ingresos *");
    opcionesAseguradoras['Sbi CertIngMod etiqueta2 Unipersonal'] = t('texto_131');
    opcionesAseguradoras['Sbi CertIngMod error Unipersonal'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sbi CertIngMod etiqueta Micro-empresario'] = t("Certificado de ingresos *");
    opcionesAseguradoras['Sbi CertIngMod etiqueta2 Micro-empresario'] = t('texto_131');
    opcionesAseguradoras['Sbi CertIngMod error Micro-empresario'] = t("Certificado(s) requerido(s)");
    opcionesAseguradoras['Sbi CertIngMod etiqueta Empresa'] = t("Certificado de ingresos *");
    opcionesAseguradoras['Sbi CertIngMod etiqueta2 Empresa'] = t('texto_131');
    opcionesAseguradoras['Sbi CertIngMod error Empresa'] = t("Certificado(s) requerido(s)");

    opcionesAseguradoras['Sbi Cantidad personas adicionales'] = 5;

    return opcionesAseguradoras;
}