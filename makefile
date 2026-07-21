bash:
	docker exec -it 2312auto_as bash

npm-dev:
	docker exec 2312auto_as sh -c "cd /home_as/2312auto_as && npm run dev"

npm-prod:
	docker exec 2312auto_as sh -c "cd /home_as/2312auto_as && npm run prod"
npm-prod-go:
	npm run prod

