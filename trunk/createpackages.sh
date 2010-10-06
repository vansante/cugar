#!/bin/sh
setenv PACKAGES /home/cugar/packages
PORTSDIR=/usr/ports/

while read inputline
do
	cd ${PORTSDIR}${inputline}
	make deinstall	
	make package	
done < /home/cugar/packages.list 
