mz-docs:
	php -q ./bin/mk_mapzen_docs.php > docs/index.md
	php -q ./bin/mk_mapzen_docs.php --page methods --endpoint "$(ENDPOINT)" --api_key "$(API_KEY)" --access_token "$(ACCESS_TOKEN)" --examples > docs/methods.md
	php -q ./bin/mk_mapzen_docs.php --page formats > docs/formats.md
	php -q ./bin/mk_mapzen_docs.php --page pagination > docs/pagination.md
	php -q ./bin/mk_mapzen_docs.php --page errors > docs/errors.md

templates:
	php -q ./bin/compile-templates.php

secret:
	php -q ./bin/generate_secret.php

countries:
	php -q ./bin/mk_countries.php

setup:
	if test ! -f www/include/secrets.php; then cp www/include/secrets.php.example www/include/secrets.php; fi
	ubuntu/setup-ubuntu.sh
	ubuntu/setup-flamework.sh

	ubuntu/setup-certified.sh
	sudo ubuntu/setup-certified-ca.sh
	sudo ubuntu/setup-certified-certs.sh
	bin/configure_secrets.sh .
	ubuntu/setup-db.sh wof_api wof_api

setup-nossl:
	if test ! -f www/include/secrets.php; then cp www/include/secrets.php.example www/include/secrets.php; fi
	ubuntu/setup-ubuntu.sh
	ubuntu/setup-flamework.sh
	bin/configure_secrets.sh .
	ubuntu/setup-db.sh wof_api wof_api
	ubuntu/setup-apache-conf.sh nossl

nextzen: tangram styles mapzenjs

tangram:
	curl -s -o www/javascript/tangram.js https://www.nextzen.org/tangram/tangram.debug.js
	curl -s -o www/javascript/tangram.min.js https://www.nextzen.org/tangram/tangram.min.js

styles: refill walkabout

refill:
	curl -s -o www/tangram/refill-style.zip https://www.nextzen.org/carto/refill-style/10/refill-style.zip
	curl -s -o www/tangram/refill-style-themes-label.zip https://www.nextzen.org/carto/refill-style/10/themes/label-10.zip

walkabout:
	curl -s -o www/tangram/walkabout-style.zip https://www.nextzen.org/carto/refill-style/walkabout-style.zip

mapzenjs:
	@echo "waiting for nextzen.js..."
	# curl -s -o www/css/mapzen.js.css https://mapzen.com/js/mapzen.css
	# curl -s -o www/javascript/mapzen.js https://mapzen.com/js/mapzen.js
	# curl -s -o www/javascript/mapzen.min.js https://mapzen.com/js/mapzen.min.js

whosonfirstjs:
	curl -s -o www/javascript/mapzen.whosonfirst.uri.js https://raw.githubusercontent.com/whosonfirst/js-mapzen-whosonfirst/master/src/mapzen.whosonfirst.uri.js
	curl -s -o www/javascript/mapzen.places.api.js https://raw.githubusercontent.com/whosonfirst/js-mapzen-whosonfirst/master/src/mapzen.places.api.js
	curl -s -o www/javascript/mapzen.whosonfirst.geojson.js https://raw.githubusercontent.com/whosonfirst/js-mapzen-whosonfirst/master/src/mapzen.whosonfirst.geojson.js

chrome:
	curl -s -o www/css/mapzen.whosonfirst.chrome.css https://raw.githubusercontent.com/whosonfirst/css-mapzen-whosonfirst/master/css/mapzen.whosonfirst.chrome.css
	curl -s -o www/javascript/mapzen.whosonfirst.chrome.js https://raw.githubusercontent.com/whosonfirst/js-mapzen-whosonfirst/master/src/mapzen.whosonfirst.chrome.js
	curl -s -o www/javascript/mapzen.whosonfirst.chrome.init.js https://raw.githubusercontent.com/whosonfirst/js-mapzen-whosonfirst/master/src/mapzen.whosonfirst.chrome.init.js

whosonfirst:
	curl -s -o www/include/lib_whosonfirst_brands_sizes.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_brands_sizes.php
	curl -s -o www/include/lib_whosonfirst_brands_sizes_spec.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_brands_sizes_spec.php
	curl -s -o www/include/lib_whosonfirst_placetypes.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_placetypes.php
	curl -s -o www/include/lib_whosonfirst_placetypes_spec.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_placetypes_spec.php
	curl -s -o www/include/lib_whosonfirst_sources.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_sources.php
	curl -s -o www/include/lib_whosonfirst_sources_spec.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_sources_spec.php
	curl -s -o www/include/lib_whosonfirst_uri.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_uri.php

leaflet-locate:
	curl -s -o www/javascript/L.Control.Locate.min.js https://raw.githubusercontent.com/domoritz/leaflet-locatecontrol/gh-pages/dist/L.Control.Locate.min.js
	curl -s -o www/javascript/L.Control.Locate.js https://raw.githubusercontent.com/domoritz/leaflet-locatecontrol/gh-pages/src/L.Control.Locate.js
	curl -s -o www/css/L.Control.Locate.css https://raw.githubusercontent.com/domoritz/leaflet-locatecontrol/gh-pages/dist/L.Control.Locate.css
	curl -s -o www/css/L.Control.Locate.min.css https://raw.githubusercontent.com/domoritz/leaflet-locatecontrol/gh-pages/dist/L.Control.Locate.min.css

LEAFLET_MARKERCLUSTER_VERSION = 1.1.0
leaflet-markercluster:
	curl -s -L -o /tmp/leaflet-markercluster.zip https://github.com/Leaflet/Leaflet.markercluster/archive/v$(LEAFLET_MARKERCLUSTER_VERSION).zip
	unzip -q /tmp/leaflet-markercluster.zip -d /tmp
	cp /tmp/Leaflet.markercluster-$(LEAFLET_MARKERCLUSTER_VERSION)/dist/leaflet.markercluster.js www/javascript/leaflet.markercluster.min.js
	cp /tmp/Leaflet.markercluster-$(LEAFLET_MARKERCLUSTER_VERSION)/dist/leaflet.markercluster-src.js www/javascript/leaflet.markercluster.js
	cp /tmp/Leaflet.markercluster-$(LEAFLET_MARKERCLUSTER_VERSION)/dist/MarkerCluster.css www/css/leaflet.markercluster.css
	cp /tmp/Leaflet.markercluster-$(LEAFLET_MARKERCLUSTER_VERSION)/dist/MarkerCluster.Default.css www/css/leaflet.markercluster.default.css
	rm -rf /tmp/Leaflet.markercluster-$(LEAFLET_MARKERCLUSTER_VERSION)
	rm /tmp/leaflet-markercluster.zip
