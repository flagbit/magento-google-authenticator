#!/bin/bash
# init Project

magentoVersion="magento-1.5.1.0"

checkFile="/var/www/${magentoVersion}"
sudo cat /proc/mounts |grep ${checkFile} > /dev/null

if [ $? -eq 0 ] ; then
	echo [-] ${checkFile} is already mounted
	echo [+] unmounting ${checkFile}
	sudo umount -f ${checkFile}
fi

if [ -d ${checkFile} ]; then
	echo [-] ${checkFile} exists
	echo [+] deleting ${checkFile}
	rm -r ${checkFile}
fi

mkdir ${checkFile}

checkFile="/usr/local/src/magento/ext/${magentoVersion}"
if [ -d ${checkFile} ]; then
	echo [-] ${checkFile} exists
	echo [+] deleting ${checkFile}
	rm -r ${checkFile}
fi
mkdir -p ${checkFile}

checkFile="usr/local/src/vagrant/dump/dump.tgz"

#########Install Extensions ####################################################
for i in /usr/local/src/vagrant/extensions/*.tgz; do tar xfz $i -C /usr/local/src/magento/ext/${magentoVersion}; done


if [ -f ${checkFile} ]; then
	echo [-] ${checkFile} not exists
	echo [+] unpack live shop into ${checkFile}
	mkdir /usr/local/src/magento/live
	tar xfz /usr/local/src/vagrant/dump/dump.tgz -C /usr/local/src/magento/live
	
	echo [+] preparing Userights

	livePath="/usr/local/src/magento/live"
		
	sudo chmod o+w ${livePath}/var ${livePath}/var/.htaccess ${livePath}/app/etc
	sudo chmod -R 775 ${livePath}/media ${livePath}/var     
	echo [+] cleaning up Magento
	sudo chown vagrant:www-data ${livePath}/* -R   
fi

checkFile="/usr/local/src/vagrant/dump/dump.sql"
if [ -f ${checkFile} ]; then
	echo [-] ${checkFile} exists
	echo [+] import live Database
	
	mysql=`which mysql`
	
	${mysql} -u ${magentoVersion} -pvagrant1 ${magentoVersion} < ${checkFile}
	
    sql="UPDATE core_config_data SET value = 'http://localhost:8080/${magentoVersion}/' WHERE path LIKE 'web/%/base_url';"
    ${mysql} -u${magentoVersion} -pvagrant1 ${magentoVersion} -e "${sql}"
    
    sql="UPDATE core_config_data SET value = '.localhost' WHERE path LIKE 'web/%/cookie_domain';"
	${mysql} -u${magentoVersion} -pvagrant1 ${magentoVersion} -e "${sql}"

fi

echo [+] mapping mountpoints

sudo mount -t aufs -o br:/usr/local/src/magento/tmp/${magentoVersion}/ none /var/www/${magentoVersion}/
echo [+] /usr/local/src/magento/tmp/${magentoVersion}/ /var/www/${magentoVersion}/

sudo mount -o remount,append:/usr/local/src/magento/deployment /var/www/${magentoVersion}/
echo [+] /usr/local/src/magento/deployment/ /var/www/${magentoVersion}/

sudo mount -o remount,append:/usr/local/src/magento/versions/${magentoVersion} /var/www/${magentoVersion}/
echo [+] mount /usr/local/src/magento/versions/${magentoVersion}/ /var/www/${magentoVersion}/

sudo mount -o remount,append:/usr/local/src/magento/ext/${magentoVersion} /var/www/${magentoVersion}/
echo [+] /usr/local/src/magento/ext/${magentoVersion} /var/www/${magentoVersion}/

 


	