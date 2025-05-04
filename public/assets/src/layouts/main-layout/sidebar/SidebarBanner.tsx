import { Box, Button, Stack, Typography } from '@mui/material';
import bg from 'assets/images/illustration.svg';
import Image from 'components/base/Image';
const SidebarBanner = () => {
  return (
    <Stack direction={'row'} alignItems="center" gap={2} sx={{ my: 0, p: 2 }}>
      <Box
        sx={{
          height: 164,
          width: 1,
          position: 'relative',
          color: 'common.white',
        }}
      >
        <Image
          src={bg}
          alt="illustration"
          sx={{
            position: 'absolute',
            top: 0,
            left: 0,
            width: 1,
            height: 1,
            zIndex: -1,
            objectFit: 'cover',
          }}
        />
        <Box
          sx={{
            position: 'absolute',
            top: '50%',
            left: '50%',
            transform: 'translate(-50%, -50%)',
            textAlign: 'left',
          }}
        >
          <div>
            <Typography variant="h6">Grow Business</Typography>
            <Typography variant="subtitle1">Explore our marketing solutions</Typography>

            <Button
              variant="contained"
              color="secondary"
              size="small"
              sx={{
                mt: 1.5,
                alignSelf: 'flex-start',
              }}
            >
              Read More
            </Button>
          </div>
        </Box>
      </Box>
    </Stack>
  );
};

export default SidebarBanner;
