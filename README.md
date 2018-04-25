###### Copyright (C) 2014-2016 Richard Nelson <unixabg@gmail.com>
######
###### This program comes with ABSOLUTELY NO WARRANTY; for details see COPYING.
###### This is free software, and you are welcome to redistribute it
###### under certain conditions; see COPYING for details.

#############################################################################
### General install instructions as root on debian based system.
#############################################################################
#############################################################################
#### Install the packages we need.
`apt-get install apache2 git mysql-server php5-mysqlnd youtube-dl`

#### For Systems running php7.x
`apt-get install apache2 libapache2-mod-php git mysql-server youtube-dl`

#############################################################################
#### Move to the root home folder.
`cd`

#### Clone the software.
`git clone https://github.com/unixabg/ts-yt-dl.git`

#### Change directory to the new clone.
`cd ts-yt-dl/`

#### Run the make install to install.
`make install`

#############################################################################
### Adjust the security password of 'mypass' before source of tsytdl.sql.
`vim /var/www/ts-yt-dl-defaults/tsytdl.sql`

#### Match the password on the mysql_security file.
`vim /var/www/ts-yt-dl-defaults/mysql_security`

#############################################################################
### Login to the mysql and source in the tsytdl.sql file.
`mysql -u root -p`

#### Source in the tsytdl.sql file.
`source /var/www/ts-yt-dl-defaults/tsytdl.sql`

#############################################################################
### Public Audios and Videos option.

#### By defualt a public folder will not be created. However a public_path is set in the defualts as shown below:

`$public_path = '/srv/ts-yt-dl/public';`

#### To enable the public option create the public folder with the correct permissions.

`mkdir /srv/ts-yt-dl/public`
`chown -R www-data:www-data /srv/ts-yt-dl/public`

