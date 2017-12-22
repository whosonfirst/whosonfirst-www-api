#!/bin/sh

# because this (20160205/thisisaaronland)
#
# A: I have an elasticsearch question: do you have an opinion about whether there any practical benefit in running it with the oracle
# java8 stuff or is the openjdk7 stuff just fine?
# A: I ask only because the former makes installs/build fiddly because of that stupid license modal dialog
# B: i always run with oracle java
# B: I have first hand experience of openjdk sucking
# B: at least with ES
# A: what was the suckage?
# B: this was some time ago. that said, all our ES installs (and java installs) done with chef obviate any problem with the dialog issue
# B: basically it would fail during indexing with openjdk for what we were working on at the time
# B: but chugged through without incident with oracle

WHOAMI=`python -c 'import os, sys; print os.path.realpath(sys.argv[1])' $0`

PARENT=`dirname $WHOAMI`
PROJECT=`dirname $PARENT`

CONF_DIR="${PROJECT}/config"
CONF="${CONF_DIR}/${PROJECT_NAME}-elasticsearch.yml"

if [ ! -f ${CONF}.example ]
then
    echo "missing example ${CONF}"
    exit 1
fi

if [ -f ${CONF} ]
then
    cp ${CONF} ${CONF}.bak
fi

cp ${CONF}.example ${CONF}

sudo add-apt-repository ppa:webupd8team/java -y
sudo apt-get update
sudo apt-get install oracle-java8-installer -y

cd /tmp
wget https://download.elastic.co/elasticsearch/release/org/elasticsearch/distribution/deb/elasticsearch/2.4.6/elasticsearch-2.4.6.deb
sudo dpkg -i elasticsearch-2.4.6.deb
rm /tmp/elasticsearch-2.4.6.deb
cd -

if [ -f /etc/elasticsearch/elasticsearch.yml ]
	sudo rm /etc/elasticsearch/elasticsearch.yml
fi
sudo ln -s ${CONF} /etc/elasticsearch/elasticsearch.yml

sudo systemctl enable elasticsearch.service
sudo systemctl start elasticsearch
