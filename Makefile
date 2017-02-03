templates:
	php -q ./bin/compile-templates.php

secret:
	php -q ./bin/generate_secret.php

setup:
	if test ! -f www/include/secrets.php; then cp www/include/secrets.php.example www/include/secrets.php; fi
	ubuntu/setup-ubuntu.sh
	ubuntu/setup-flamework.sh
	ubuntu/setup-certified.sh
	sudo ubuntu/setup-certified-ca.sh
	sudo ubuntu/setup-certified-certs.sh
	bin/configure_secrets.sh .
	ubuntu/setup-db.sh wof_api wof_api

mapzen:	styleguide

styleguide:
	if test -e www/css/mapzen.styleguide.css; then cp www/css/mapzen.styleguide.css www/css/mapzen.styleguide.css.bak; fi
	curl -s -o www/css/mapzen.styleguide.css https://mapzen.com/common/styleguide/styles/styleguide.css
	curl -s -o www/javascript/mapzen.styleguide.min.js https://mapzen.com/common/styleguide/scripts/mapzen-styleguide.min.js

chrome:
	curl -s -o www/css/mapzen.whosonfirst.chrome.css https://raw.githubusercontent.com/whosonfirst/css-mapzen-whosonfirst/master/css/mapzen.whosonfirst.chrome.css
	curl -s -o www/javascript/mapzen.whosonfirst.chrome.js https://raw.githubusercontent.com/whosonfirst/js-mapzen-whosonfirst/master/src/mapzen.whosonfirst.chrome.js
	curl -s -o www/javascript/mapzen.whosonfirst.chrome.init.js https://raw.githubusercontent.com/whosonfirst/js-mapzen-whosonfirst/master/src/mapzen.whosonfirst.chrome.init.js

whosonfirst:
	curl -s -o www/include/lib_whosonfirst_placetypes.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_placetypes.php
	curl -s -o www/include/lib_whosonfirst_placetypes_spec.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_placetypes_spec.php
	curl -s -o www/include/lib_whosonfirst_sources.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_sources.php
	curl -s -o www/include/lib_whosonfirst_sources_spec.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_sources_spec.php
	curl -s -o www/include/lib_whosonfirst_uri.php https://raw.githubusercontent.com/whosonfirst/flamework-whosonfirst/master/www/include/lib_whosonfirst_uri.php

dev-to-master:
	git checkout master
	git pull origin dev
	git push origin master
	git checkout dev
