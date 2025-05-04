import { Box, ButtonBase, Container, Grid, Link, Stack, Typography } from '@mui/material';
import IconifyIcon from 'components/base/IconifyIcon';

/* ----------------  Links Data  ------------------------------ */
const data = [
  { href: '#!', title: 'Themewagon', key: 'team' },
  { href: '#!', title: 'About Us', key: 'about' },
  { href: '#!', title: 'Blog ', key: 'blog' },
  { href: '#!', title: 'License ', key: 'license' },
];
/* ------------------------------------------------------------ */
const Footer = () => {
  return (
    <>
      <Box component="section" textAlign="center" py={0}>
        <Container>
          <Box pb={3}>
            <Grid container justifyContent="space-between" alignItems="center">
              <Grid item xs={12} lg="auto">
                <Stack
                  alignItems="center"
                  sx={{
                    flexDirection: {
                      xs: 'column',
                      lg: 'row',
                    },
                    gap: 1,
                  }}
                >
                  <Typography variant="h6" fontWeight="regular" mb={0}>
                    &copy; {new Date().getFullYear()}, Your Company Inc.
                  </Typography>
                  <Typography
                    variant="h6"
                    mb={0}
                    display="flex"
                    alignItems="center"
                    justifyContent="center"
                    fontWeight="regular"
                  >
                    Made with
                    <IconifyIcon icon="ri:heart-fill" sx={{ mx: 1, color: 'error.main' }} />
                    by
                    <Link
                      href="https://themewagon.com/"
                      target="_blank"
                      color="inherit"
                      sx={{
                        textDecoration: 'none',
                        transition: 'background 1s, color 0.5s',
                        ml: 1,
                        fontWeight: 'bold',
                        '&:hover': { color: 'primary.main' },
                      }}
                    >
                      ThemeWagon
                    </Link>
                  </Typography>
                </Stack>
              </Grid>
              <Grid item xs={12} lg="auto" mb={{ xs: 1, lg: 0 }} alignItems="center">
                <Stack
                  flexDirection="row"
                  flexWrap="wrap"
                  alignItems="center"
                  justifyContent="center"
                  component="ul"
                  sx={{
                    listStyle: 'none',
                    mt: { xs: 3, lg: 0 },
                    mb: 0,
                    p: 0,
                  }}
                >
                  {data?.map((link) => (
                    <ButtonBase
                      key={link.key}
                      component={Link}
                      href={`${link.href}`}
                      sx={{
                        px: 2,
                        lineHeight: 1,
                        '& :hover': { color: 'primary.main' },
                      }}
                    >
                      <Typography variant="button" fontWeight="regular" color="text.secondary">
                        {link.title}
                      </Typography>
                    </ButtonBase>
                  ))}
                </Stack>
              </Grid>
            </Grid>
          </Box>
        </Container>
      </Box>
    </>
  );
};

export default Footer;
