import {
  Avatar,
  Badge,
  Box,
  Button,
  Chip,
  IconButton,
  Menu,
  MenuItem,
  Stack,
  Typography,
} from '@mui/material';
import NotificationIcon from 'components/icons/NotificationIcon';
import { notificationOptions } from 'data/navbar/menu-data';
import { useState } from 'react';
import SimpleBar from 'simplebar-react';

function notificationsLabel(count: number) {
  if (count === 0) {
    return 'no notifications';
  }
  if (count > 99) {
    return 'more than 99 notifications';
  }
  return `${count} notifications`;
}

const NotificationDropdown = () => {
  const [anchorEl, setAnchorEl] = useState<HTMLButtonElement | null>(null);
  const open = Boolean(anchorEl);
  const handleClick = (event: React.MouseEvent<HTMLButtonElement>) => {
    setAnchorEl(event.currentTarget);
  };

  const handleClose = () => {
    setAnchorEl(null);
  };
  return (
    <>
      <IconButton
        aria-label={notificationsLabel(100)}
        color="inherit"
        onClick={handleClick}
        sx={{
          color: 'grey.200',
        }}
      >
        <Badge color="primary" badgeContent={5}>
          <NotificationIcon />
        </Badge>
      </IconButton>
      <Menu
        id="long-menu"
        MenuListProps={{
          sx: { flex: 1 },
        }}
        keepMounted
        anchorEl={anchorEl}
        open={open}
        onClose={handleClose}
        anchorOrigin={{ horizontal: 'right', vertical: 'bottom' }}
        transformOrigin={{ horizontal: 'right', vertical: 'top' }}
        slotProps={{
          paper: {
            style: {
              width: 326,
            },
          },
        }}
      >
        <Stack direction="row" py={2} px={4} justifyContent="space-between" alignItems="center">
          <Typography variant="h6">Notifications</Typography>
          <Chip label="5 new" color="primary" size="small" />
        </Stack>
        <SimpleBar style={{ height: '385px' }}>
          {notificationOptions.map((notification) => (
            <MenuItem
              key={notification.id}
              sx={{
                py: 2,
                px: 4,
              }}
              onClick={handleClose}
            >
              <Stack direction="row" alignItems="center" spacing={2}>
                <Avatar
                  src={notification.avatar}
                  alt={notification.avatar}
                  sx={{
                    width: 36,
                    height: 36,
                  }}
                />
                <Box
                  sx={{
                    width: 200,
                  }}
                >
                  <Typography variant="subtitle2" color="textPrimary" fontWeight="medium" noWrap>
                    {notification.title}
                  </Typography>
                  <Typography color="textSecondary" variant="subtitle2" noWrap>
                    {notification.subtitle}
                  </Typography>
                </Box>
              </Stack>
            </MenuItem>
          ))}
        </SimpleBar>
        <Stack direction="row" sx={{ width: 1, justifyContent: 'center' }}>
          <Button
            size="small"
            variant="outlined"
            sx={{
              mt: 3.5,
              width: '80%',
            }}
          >
            See All Notifications
          </Button>
        </Stack>
      </Menu>
    </>
  );
};

export default NotificationDropdown;
