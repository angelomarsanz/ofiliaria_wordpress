import Box from '@mui/material/Box';
import Typography from '@mui/material/Typography';
import Modal from '@mui/material/Modal';
import Button from '@mui/material/Button';
import { useTranslation } from 'react-i18next';

// Import Icons
import CheckCircleOutlineIcon from '@mui/icons-material/CheckCircleOutline';
import InfoOutlinedIcon from '@mui/icons-material/InfoOutlined';
import WarningAmberOutlinedIcon from '@mui/icons-material/WarningAmberOutlined';
import ErrorOutlineIcon from '@mui/icons-material/ErrorOutline';

const style = {
    position: 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    width: 400,
    bgcolor: 'background.paper',
    boxShadow: 'rgba(100, 100, 111, 0.3) 0px 7px 29px 0px',
    backgroundColor: 'white',
    border: '2px solid rgb(240, 240, 240)',
    borderRadius: '12px',
    p: 4,
};

export const ModalBasico = ({ open, handleClose, tituloModal, contenidoModal, tipoAlerta }) => {
    const { t } = useTranslation();

    const getAlertInfo = () => {
        switch (tipoAlerta) {
            case 'Información':
                return { Icon: InfoOutlinedIcon, color: 'info.main', buttonColor: 'info' };
            case 'Satisfactorio':
                return { Icon: CheckCircleOutlineIcon, color: 'success.main', buttonColor: 'success' };
            case 'Advertencia':
                return { Icon: WarningAmberOutlinedIcon, color: 'warning.main', buttonColor: 'warning' };
            case 'Peligro':
                return { Icon: ErrorOutlineIcon, color: 'error.main', buttonColor: 'error' };
            default:
                return { Icon: null, color: 'inherit', buttonColor: 'primary' };
        }
    };

    const { Icon, color, buttonColor } = getAlertInfo();

    return (
        <div>
            <Modal
                open={open}
                onClose={handleClose}
                aria-labelledby="modal-modal-title"
                aria-describedby="modal-modal-description"
            >
                <Box sx={style}>
                    <Box sx={{ display: 'flex', alignItems: 'center', gap: 1.5, color: color }}>
                        {Icon && <Icon sx={{ fontSize: '1.7rem' }} />}
                        <Typography id="modal-modal-title" variant="h4" sx={{ color: 'inherit', fontSize: '1.2rem', fontWeight: 'bold' }}>
                            {tituloModal}
                        </Typography>
                    </Box>
                    <Typography id="modal-modal-description" sx={{ mt: 2, fontSize: 16 }}>
                        {contenidoModal}
                    </Typography>
                    <Box sx={{pt: 3, textAlign: 'right'}}>
                        <Button onClick={handleClose} color={buttonColor}>{t("Ok")}</Button>
                    </Box>
                </Box>
            </Modal>
        </div>
    );
}