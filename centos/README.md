# centos

_This is work in progress..._

## Basics

```
yum install -y git tcsh emacs-nox htop sysstat ufw fail2ban python-setuptools unzip
```

_Is there an equivalent to Ubuntu's `unattended-upgrades` ?_

## MySQL

* https://linode.com/docs/databases/mysql/how-to-install-mysql-on-centos-7/
* https://dev.mysql.com/downloads/repo/yum/
* https://dev.mysql.com/doc/mysql-yum-repo-quick-guide/en/

_Note that MariaDB does not support the `ST_Distance_Sphere` function... because???_

Then run:

```
yum clean all
yum update
yum install mysql-server

systemctl start mysql-server
```

```
mysql_secure_installation
...typing...
```

* https://mariadb.com/resources/blog/installing-mariadb-10-centos-7-rhel-7
* https://downloads.mariadb.org/mariadb/repositories/#mirror=nodesdirect&distro=CentOS&distro_release=centos7-amd64--centos7&version=10.2

* https://www.digitalocean.com/community/tutorials/how-to-install-mariadb-on-centos-7
* https://mariadb.com/kb/en/library/starting-and-stopping-mariadb/
* https://mariadb.com/kb/en/library/geographic-geometric-features/

* https://dev.mysql.com/doc/mysql-repo-excerpt/5.6/en/linux-installation-yum-repo.html

## Apache

```
yum install httpd24
...configure things here...
systemctl enable httpd.service
systemctl restart httpd.service
```

* https://linode.com/docs/web-servers/apache/install-and-configure-apache-on-centos-7/

## PHP

CentOS install 5.x by default so...

```
yum install -y centos-release-scl.noarch
yum install -y rh-php70 rh-php70-php
yum install -y rh-php70-php-mysqlnd rh-php70-php-mbstring
ln -s /opt/rh/rh-php70/root/bin/php /usr/local/bin/

ln -s /opt/rh/httpd24/root/etc/httpd/conf.d/rh-php70-php.conf /etc/httpd/conf.d/
ln -s /opt/rh/httpd24/root/etc/httpd/conf.modules.d/15-rh-php70-php.conf /etc/httpd/conf.modules.d/
ln -s /opt/rh/httpd24/root/usr/lib64/httpd/modules/librh-php70-php7.so /etc/httpd/modules/
systemctl restart httpd.service
```

Because this:

```
repoquery -l rh-php70-php
/opt/rh/httpd24/root/etc/httpd/conf.d/rh-php70-php.conf
/opt/rh/httpd24/root/etc/httpd/conf.modules.d/15-rh-php70-php.conf
/opt/rh/httpd24/root/usr/lib64/httpd/modules/librh-php70-php7.so
/opt/rh/httpd24/root/usr/share/httpd/icons/rh-php70-php.gif
/opt/rh/rh-php70/register.content/var/opt/rh/rh-php70/lib/php/session
/opt/rh/rh-php70/register.content/var/opt/rh/rh-php70/lib/php/wsdlcache
/var/opt/rh/rh-php70/lib/php/opcache
/var/opt/rh/rh-php70/lib/php/session
/var/opt/rh/rh-php70/lib/php/wsdlcache

/opt/rh/rh-php70/root/bin/php --version
PHP 7.0.27 (cli) (built: Apr  4 2018 13:48:44) ( NTS )
Copyright (c) 1997-2017 The PHP Group
Zend Engine v3.0.0, Copyright (c) 1998-2017 Zend Technologies
```

## Flamework

```
ln -s /usr/local/whosonfirst/whosonfirst-www-api/config/whosonfirst-www-api-apache-nossl.conf /etc/httpd/conf.d/

chown -R apache.apache /usr/local/whosonfirst/whosonfirst-www-api/www/templates_c/

./ubuntu/setup-secrets.sh 

systemctl restart httpd.service
```

### MySQL

Something about the Ubuntu "setup database" script doesn't work so...

```
> DROP DATABASE IF EXISTS whosonfirst;
Query OK, 0 rows affected (0.00 sec)

> CREATE DATABASE whosonfirst;
Query OK, 1 row affected (0.00 sec)

> CREATE user 'whosonfirst'@'localhost' IDENTIFIED BY '***';
Query OK, 0 rows affected (0.00 sec)

> GRANT SELECT,UPDATE,DELETE,INSERT ON whosonfirst.* TO 'whosonfirst'@'localhost' IDENTIFIED BY '***';
Query OK, 0 rows affected (0.00 sec)

> FLUSH PRIVILEGES;
Query OK, 0 rows affected (0.00 sec)
```

```
mysql -uroot -p whosonfirst < schema/db_main.schema
mysql -uroot -p whosonfirst < schema/db_accounts.schema
mysql -uroot -p whosonfirst < schema/db_tickets.schema
```