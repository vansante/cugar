#!/bin/sh
cd /home/cugar
svn update
# copy over debug config files while we're not parsing configurations
cp -r /home/cugar/configfiles/* /home/cugar/Files/etc/
# clean old files from directory (to ensure new files are accurate)
rm -rf /usr/src/tools/tools/nanobsd/Files
# copy over new files
cp -r /home/cugar/Files /usr/src/tools/tools/nanobsd/

# create image
sh /usr/src/tools/tools/nanobsd/nanobsd.sh -w -c /home/cugar/cugar-nano.conf
