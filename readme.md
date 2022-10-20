# Commission fee calculation app

These are instructions for installing the project on your local environment.

## Build

You need to have make, docker and docker-compose on your local environment. Run this command in project folder:

```bash
make build 
```

## Calculate
Run this command to get commission fee calculation:

```bash
make calculate 
```

If you need to run a command manually with a filename, you can run this command:

```bash
docker-compose exec php-fpm php artisan commissions:calculate input.csv 
```

## Testing
Run this command to run test:

```bash
make test
```

## Docker

Commands for up / down application:

```bash
make up 
```
```bash
make down 
```


