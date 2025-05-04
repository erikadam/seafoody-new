import { MouseEvent, useState } from 'react';

import { MenuItem, Popover } from '@mui/material';
import IconButton from '@mui/material/IconButton';
import IconifyIcon from 'components/base/IconifyIcon';

// ----------------------------------------------------------------------

const LANGS = [
  {
    value: 'en-uk',
    label: 'English (Global)',
    icon: 'flag:sh-4x3',
  },
  {
    value: 'en-us',
    label: 'English',
    icon: 'flag:us-4x3',
  },

  {
    value: 'bd',
    label: 'Bangla',
    icon: 'flag:bd-4x3',
  },
];

// ----------------------------------------------------------------------
const LanguageDropdown = () => {
  const [open, setOpen] = useState<HTMLElement | null>(null);

  const handleOpen = (event: MouseEvent<HTMLElement>) => {
    setOpen(event.currentTarget);
  };

  const handleClose = () => {
    setOpen(null);
  };

  return (
    <>
      <IconButton
        onClick={handleOpen}
        sx={{
          height: 40,
          width: 40,
          p: 1,
          ...(open ? { bgcolor: 'primary.lighter' } : {}),
        }}
      >
        <IconifyIcon
          icon="flag:sh-4x3"
          sx={{
            maxWidth: 1,
            borderRadius: 1,
            verticalAlign: 'middle',
          }}
        />
      </IconButton>

      <Popover
        open={!!open}
        anchorEl={open}
        onClose={handleClose}
        anchorOrigin={{ vertical: 'bottom', horizontal: 'right' }}
        transformOrigin={{ vertical: 'top', horizontal: 'right' }}
        slotProps={{
          paper: {
            sx: { width: 170 },
          },
        }}
      >
        {LANGS.map((option) => (
          <MenuItem
            key={option.value}
            selected={option.value === LANGS[0].value}
            onClick={handleClose}
            sx={{ typography: 'body2', py: 1 }}
          >
            <IconifyIcon icon={option.icon} sx={{ width: 28, height: 28, mr: 2 }} />

            {option.label}
          </MenuItem>
        ))}
      </Popover>
    </>
  );
};

export default LanguageDropdown;
