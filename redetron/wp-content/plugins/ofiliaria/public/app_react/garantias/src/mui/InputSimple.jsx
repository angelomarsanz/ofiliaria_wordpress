import {TextField, Button, Paper, Box} from '@mui/material';
import Grid from '@mui/material/Grid2';
import { useState } from "react";

export const InputSimple = () => {
  const [textValue, setTextValue] = useState("");

  const onTextChange = (e) => setTextValue(e.target.value);
  const handleSubmit = () => console.log(textValue);
  const handleReset = () => setTextValue("");

  return (
      <Paper sx={{margin: 5 }} elevation={1} >
        <Box sx={{ p : 2 }}>
          <Grid container spacing={{ xs : 2, sm : 2, md : 3, lg : 3, xl : 3 }}>
            <Grid key={'1'} size={{ xs : 12, sm : 12, md : 12, lg : 12, xl : 12 }}>
              <h4>Form Demo</h4>
              <TextField
                fullWidth
                onChange={onTextChange}
                value={textValue}
                label={"Text Value"} //optional
              />
            </Grid>
            <Grid key={'2'} size={{ xs : 12, sm : 12, md : 2, lg : 2, xl : 2 }}>
              <Button onClick={handleSubmit}>Submit</Button>
            </Grid>
            <Grid key={'3'} size={{ xs : 12, sm : 12, md : 2, lg : 2, xl : 2 }}>
              <Button onClick={handleReset}>Reset</Button>
            </Grid>
          </Grid>
        </Box>
      </Paper>
  );
};