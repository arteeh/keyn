## Keyndb.com
#### A mod hosting site based on torrenting

### Setup

- Install Apache and PHP (`sudo apt install php`)
- Place the contents of this repository in `/var/www/html/`
- Fix permissions (`sudo chmod +x permissions.sh; sudo ./permissions.sh`)
- Copy the keyn configuration to Apache (`sudo cp keyn.conf /etc/apache2/sites-available/keyn.conf`)
- Enable the rewrite module (`sudo a2enmod rewrite`)
- Enable the site (`sudo a2ensite keyn`)
- Start or restart Apache (`sudo systemctl reload apache2`)
