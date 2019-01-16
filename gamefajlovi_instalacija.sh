#!/bin/bash

echo "Skripta za automatsko instaliranje cs, mc, samp gamefajlova na centos 7 minimal by Root (Nikita Sibul)"
yum update -y
clear;
echo "Update zavrsen!"

yum install vsftpd
clear;
echo "FTP INSTALIRAN!"

yum install glibc.i686 libstdc++.i686
yum install wget
yum install screen
yum install unzip
systemctl stop iptables
systemctl disable iptables
echo "chroot_local_user=YES" >> /etc/vsftpd/vsftpd.conf
echo 'allow_writeable_chroot=YES' >> /etc/vsftpd/vsftpd.conf
systemctl restart vsftpd
systemctl enable vsftpd
chmod -R 775 /home
clear;
echo "Instalirani fajlovi za igre!"

mkdir /home/gamefiles
cd /home/gamefiles/
wget http://files.sa-mp.com/samp037svr_R2-1.tar.gz
tar xf samp037svr_R2-1.tar.gz
mv samp03 samp
rm samp037svr_R2-1.tar.gz
chmod -R 775 /home
clear;
echo "SAMP INSTALIRAN!"

yum install java-1.8.0-openjdk
yum install java-1.8.0-openjdk-devel
mkdir /home/gamefiles/mc
cd /home/gamefiles/mc
wget https://cdn.getbukkit.org/spigot/spigot-1.8.8-R0.1-SNAPSHOT-latest.jar
mv spigot-1.8.8-R0.1-SNAPSHOT-latest.jar spigot.jar
echo "eula=true" > eula.txt
chmod -R 775 /home
clear;
echo "MINECRAFT INSTALIRAN!"

cd /home/gamefiles/
mkdir pub

clear;
echo "ZAVRSENA INSTALACIJA!"
