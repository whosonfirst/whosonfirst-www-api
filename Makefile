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

# in advance of 7.2.x being widely deployed/adopted
# https://github.com/defuse/php-encryption
# https://github.com/defuse/php-encryption/releases
# https://github.com/defuse/php-encryption/blob/master/docs/InstallingAndVerifying.md

defuse:
	curl -L -s -o www/include/defuse-crypto/defuse-crypto.2.2.0.phar https://github.com/defuse/php-encryption/releases/download/v2.2.0/defuse-crypto.phar
	curl -L -s -o www/include/defuse-crypto/defuse-crypto.2.2.0.phar.sig https://github.com/defuse/php-encryption/releases/download/v2.2.0/defuse-crypto.phar.sig

# js-paginate                                                                                                                                                                                                                                       
js-paginate:
	curl -s -o www/javascript/pagination.shortcuts.init.js https://raw.githubusercontent.com/aaronland/js-paginate/master/src/pagination.shortcuts.init.js

# https://github.com/twitter/typeahead.js

js-typeahead:
	curl -s -o www/javascript/typeahead.bundle.js https://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js

# https://mozilla.github.io/pdf.js/getting_started/

js-pdf-js:
	curl -s -o www/javascript/pdf.min.js https://unpkg.com/pdfjs-dist@2.0.489/build/pdf.min.js
	curl -s -o www/javascript/pdf.worker.min.js https://unpkg.com/pdfjs-dist@2.0.489/build/pdf.worker.min.js

# https://getbootstrap.com/docs/4.1/getting-started/download/

js-bootstrap:
	curl -s -o www/css/bootstrap.4.1.1.min.css https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css
	curl -s -o www/javascript/bootstrap.4.1.1.min.js https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js
	curl -s -o www/javascript/jquery-3.3.1.slim.min.js https://code.jquery.com/jquery-3.3.1.slim.min.js
	curl -s -o www/javascript/popper.1.14.3.min.js https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js

js-jquery:
	curl -s -o www/javascript/jquery-3.3.1.min.js https://code.jquery.com/jquery-3.3.1.min.js
	curl -s -o www/javascript/jquery-3.3.1.js https://code.jquery.com/jquery-3.3.1.js

nextzen: tangram styles mapzen-js

tangram:
	curl -s -o www/javascript/tangram.js https://www.nextzen.org/tangram/tangram.debug.js
	curl -s -o www/javascript/tangram.min.js https://www.nextzen.org/tangram/tangram.min.js

styles: refill walkabout

refill:
	curl -s -o www/tangram/refill-style.zip https://www.nextzen.org/carto/refill-style/10/refill-style.zip
	curl -s -o www/tangram/refill-style-themes-label.zip https://www.nextzen.org/carto/refill-style/10/themes/label-10.zip

walkabout:
	curl -s -o www/tangram/walkabout-style.zip https://www.nextzen.org/carto/refill-style/walkabout-style.zip

mapzen-js:
	@echo "waiting for nextzen.js..."
	# curl -s -o www/css/mapzen.js.css https://mapzen.com/js/mapzen.css
	# curl -s -o www/javascript/mapzen.js https://mapzen.com/js/mapzen.js
	# curl -s -o www/javascript/mapzen.min.js https://mapzen.com/js/mapzen.min.js

whosonfirst: whosonfirst-fonts whosonfirst-css whosonfirst-js whosonfirst-php

whosonfirst-fonts: 
	curl -s -o www/fonts/Poppins-Light.ttf https://raw.githubusercontent.com/whosonfirst/whosonfirst-www/master/www/fonts/Poppins-Light.ttf
	curl -s -o www/fonts/Poppins-Medium.ttf https://raw.githubusercontent.com/whosonfirst/whosonfirst-www/master/www/fonts/Poppins-Medium.ttf
	curl -s -o www/fonts/Poppins-SemiBold.ttf https://raw.githubusercontent.com/whosonfirst/whosonfirst-www/master/www/fonts/Poppins-SemiBold.ttf
	curl -s -o www/fonts/Roboto-Light.ttf https://raw.githubusercontent.com/whosonfirst/whosonfirst-www/master/www/fonts/Roboto-Light.ttf
	curl -s -o www/fonts/Roboto-LightItalic.ttf https://raw.githubusercontent.com/whosonfirst/whosonfirst-www/master/www/fonts/Roboto-LightItalic.ttf
	curl -s -o www/fonts/Roboto-Regular.ttf https://raw.githubusercontent.com/whosonfirst/whosonfirst-www/master/www/fonts/Roboto-Regular.ttf
	curl -s -o www/fonts/Roboto-Mono-Light.ttf https://raw.githubusercontent.com/whosonfirst/whosonfirst-www/master/www/fonts/Roboto-Mono-Light.ttf
	curl -s -o www/fonts/glyphicons-halflings-regular.eot https://raw.githubusercontent.com/whosonfirst/whosonfirst-www/master/www/fonts/glyphicons-halflings-regular.eot
	curl -s -o www/fonts/glyphicons-halflings-regular.svg https://raw.githubusercontent.com/whosonfirst/whosonfirst-www/master/www/fonts/glyphicons-halflings-regular.svg
	curl -s -o www/fonts/glyphicons-halflings-regular.ttf https://raw.githubusercontent.com/whosonfirst/whosonfirst-www/master/www/fonts/glyphicons-halflings-regular.ttf
	curl -s -o www/fonts/glyphicons-halflings-regular.woff https://raw.githubusercontent.com/whosonfirst/whosonfirst-www/master/www/fonts/glyphicons-halflings-regular.woff

whosonfirst-css:
	curl -s -o www/css/whosonfirst.css https://raw.githubusercontent.com/whosonfirst/whosonfirst-www/master/www/css/mapzen.whosonfirst.css

whosonfirst-js:
	curl -s -o www/javascript/mapzen.whosonfirst.uri.js https://raw.githubusercontent.com/whosonfirst/js-mapzen-whosonfirst/master/src/mapzen.whosonfirst.uri.js
	curl -s -o www/javascript/mapzen.places.api.js https://raw.githubusercontent.com/whosonfirst/js-mapzen-whosonfirst/master/src/mapzen.places.api.js
	curl -s -o www/javascript/mapzen.whosonfirst.geojson.js https://raw.githubusercontent.com/whosonfirst/js-mapzen-whosonfirst/master/src/mapzen.whosonfirst.geojson.js

whosonfirst-php:
	curl -s -o www/include/lib_whosonfirst_brands_sizes.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_brands_sizes.php
	curl -s -o www/include/lib_whosonfirst_brands_sizes_spec.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_brands_sizes_spec.php
	curl -s -o www/include/lib_whosonfirst_placetypes.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_placetypes.php
	curl -s -o www/include/lib_whosonfirst_placetypes_spec.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_placetypes_spec.php
	curl -s -o www/include/lib_whosonfirst_sources.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_sources.php
	curl -s -o www/include/lib_whosonfirst_sources_spec.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_sources_spec.php
	curl -s -o www/include/lib_whosonfirst_uri.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_uri.php

leaflet: leaflet-locate leaflet-markercluster

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
