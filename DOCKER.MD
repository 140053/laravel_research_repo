## SETUP 

* Change  the port for the app in .env  

```
APP_URL=http://localhost
```
and on the docker-compose.yml for the nginx
```
ports:
      - "80:80"
```

* then  run the docker compose in the terminal 



✅ Build and start the containers:
```
docker-compose up -d --build
```


* Note database is not setup in this config configure it manually 
