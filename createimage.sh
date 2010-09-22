#!/bin/sh
cd /home/cugar
svn update
# clean old files from directory (to ensure new files are accurate)
rm -rf /usr/src/tools/tools/nanobsd/Files
# copy over new files
cp -r /home/cugar/Files /usr/src/tools/tools/nanobsd/

# create image
sh /usr/src/tools/tools/nanobsd/nanobsd.sh -c /home/cugar/cugar-nano.conf
