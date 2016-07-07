templates:
	php -q ./bin/compile-templates.php

secret:
	php -q ./bin/generate_secret.php

setup:
	ubuntu/setup-ubuntu.sh
	ubuntu/setup-flamework.sh
	ubuntu/setup-certified.sh
	sudo ubuntu/setup-certified-ca.sh
	sudo ubuntu/setup-certified-certs.sh
	bin/configure_secrets.sh .
	ubuntu/setup-db.sh wof_api wof_api
