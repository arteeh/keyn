#!/bin/bash

if [ "$EUID" -ne 0 ]
  then echo "Please run as root"
  exit
fi

chmod 775 /var/www/html
chgrp www-data /var/www/html
chmod g+s /var/www/html
