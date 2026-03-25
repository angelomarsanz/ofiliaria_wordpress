import * as React from 'react';
import Card from '@mui/material/Card';
import CardContent from '@mui/material/CardContent';
import CardMedia from '@mui/material/CardMedia';
import Typography from '@mui/material/Typography';
import CardActionArea from '@mui/material/CardActionArea';

export const TarjetaPrimaria = ({urlImagen, titulo}) => {
  return (
    <Card className='ra_tarjeta_aseguradora'>
      <CardActionArea>
        <CardMedia
          component="img"
          image={urlImagen}
          alt="Imagen"
        />
        <CardContent sx={{ backgroundColor : '#9127ff', color : 'white', padding : '0.5rem'}}>
          <Typography gutterBottom variant="h5" component="div">
            {titulo}
          </Typography>
        </CardContent>
      </CardActionArea>
    </Card>
  );
}