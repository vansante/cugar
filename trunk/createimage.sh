#!/bin/csh
setenv CFG_ROOT_PASSWORD toor
 
cd /home/cugar/Client
svn update
# copy over debug config files while we're not parsing configurations
#cp -r /home/cugar/Client/configfiles/* /home/cugar/Client/Files/etc/
# clean old files from directory (to ensure new files are accurate)
rm -rf /usr/src/tools/tools/nanobsd/Files
# copy over new files
cp -r /home/cugar/Client/Files /usr/src/tools/tools/nanobsd/
chmod -R +x /usr/src/tools/tools/nanobsd/Files 
# copy over frontend files
mkdir /usr/src/tools/tools/nanobsd/Files/var
mkdir /usr/src/tools/tools/nanobsd/Files/var/www
mkdir /usr/src/tools/tools/nanbosd/Files/var/www/mgmt

cp -r /home/cugar/Client/ui/* /usr/src/tools/tools/nanobsd/Files/var/www/mgmt/

# create image
sh /usr/src/tools/tools/nanobsd/nanobsd.sh -w -c /home/cugar/cugar-nano.conf
