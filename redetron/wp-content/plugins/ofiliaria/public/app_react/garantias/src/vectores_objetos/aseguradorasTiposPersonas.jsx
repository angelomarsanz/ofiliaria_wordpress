import { useTranslation } from 'react-i18next';

export const aseguradorasTiposPersonas = () => {
    const { t } = useTranslation();
    const aseguradorasTiposPersonas = [];

    // Sura
    aseguradorasTiposPersonas['Sura'] = [
        ['', ''],
        [t('texto_66'), t('texto_66')], // Persona física
        [t('texto_69'), t('texto_69')], // Profesional independiente
        [t('texto_70'), t('texto_70')], // Unipersonal
        [t('texto_71'), t('texto_71')], // Micro-empresario
        [t('texto_72'), t('texto_72')], // Empresa
    ];

    // Porto
    aseguradorasTiposPersonas['Porto'] = [
        ['', ''],
        [t('texto_66'), t('texto_66')], // Persona física
        [t('texto_67'), t('texto_67')], // Persona con rentas de alquileres
        [t('texto_68'), t('texto_68')], // Universitario
        [t('texto_69'), t('texto_69')], // Profesional independiente
        [t('texto_70'), t('texto_70')], // Unipersonal
        [t('texto_71'), t('texto_71')], // Micro-empresario
        [t('texto_72'), t('texto_72')], // Empresa
    ];

    // Sancor
    aseguradorasTiposPersonas['Sancor'] = [
        ['', ''],
        [t('texto_66'), t('texto_66')], // Persona física
        [t('texto_69'), t('texto_69')], // Profesional independiente
        [t('texto_70'), t('texto_70')], // Unipersonal
        [t('texto_71'), t('texto_71')], // Micro-empresario
        [t('texto_73'), t('texto_73')], // Socios o Accionistas de Sociedades Comerciales 
    ];

    // Mapfre
    aseguradorasTiposPersonas['Mapfre'] = [
        ['', ''],
        [t('texto_66'), t('texto_66')], // Persona física
        [t('texto_67'), t('texto_67')], // Persona con rentas de alquileres
        [t('texto_69'), t('texto_69')], // Profesional independiente
        [t('texto_70'), t('texto_70')], // Unipersonal
        [t('texto_71'), t('texto_71')], // Micro-empresario
        [t('texto_72'), t('texto_72')], // Empresa
    ];

    // Sbi
    aseguradorasTiposPersonas['Sbi'] = [
        ['', ''],
        [t('texto_66'), t('texto_66')], // Persona física
        [t('texto_69'), t('texto_69')], // Profesional independiente
        [t('texto_70'), t('texto_70')], // Unipersonal
        [t('texto_71'), t('texto_71')], // Micro-empresario
        [t('texto_72'), t('texto_72')], // Empresa
    ];

    return aseguradorasTiposPersonas;
}