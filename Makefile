up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down ip-locator-clear docker-pull docker-duild docker-up ip-locator-init

my:
	sudo chown -R roman:roman ip-locator

my2:
	sudo chmod 777 ip-locator

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-duild:
	docker-compose build

ip-locator-init: ip-locator-wait-db ip-locator-ready

ip-locator-clear:
	docker run --rm -v ${PWD}/ip-locator:/app --workdir=/app alpine rm -f .ready

ip-locator-wait-db:
	until docker-compose exec -T ip-locator-postgres pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done

ip-locator-ready:
	docker run --rm -v ${PWD}/ip-locator:/app --workdir=/app alpine touch .ready
