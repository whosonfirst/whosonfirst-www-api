# whosonfirst-www-api

## Setting up a local Elasticsearch index

These are working notes so adjust your expectations accordingly. There is nothing `whosonfirst-www-api` specific about these instructions. It's just the first place we've written it all down...

```
./ubuntu/setup-elasticsearch.sh 
git clone git@github.com:whosonfirst/es-whosonfirst-schema.git
cd es-whosonfirst-schema/
cat ./schema/mappings.spelunker.json | curl -XPUT 'http://localhost:9200/whosonfirst_20160708' -d @-
curl -XPOST http://HOST:9200/_aliases -d '{ "actions": [ { "add": { "alias": "whosonfirst", "index": "whosonfirst_20160708" }} ] }'
curl -XPOST http://localhost:9200/_aliases -d '{ "actions": [ { "add": { "alias": "whosonfirst", "index": "whosonfirst_20160708" }} ] }'
cd -
sudo apt-get install python-shapely
git clone git@github.com:whosonfirst/py-mapzen-search.git
cd py-mapzen-whosonfirst
sudo python ./setup.py install
cd -
wof-es-index -s /usr/local/mapzen/whosonfirst-data/data/ -b
```
