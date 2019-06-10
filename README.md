# Docker environment
Prerequisites
-----
You will require:

- Docker engine for your platfom ([Windows](https://docs.docker.com/docker-for-windows/) [Linux](https://docs.docker.com/engine/installation/#/on-linux) [Mac](https://docs.docker.com/docker-for-mac/install/))
- [Docker-compose](https://docs.docker.com/compose/install/)
- Git client
- [Make](https://en.wikipedia.org/wiki/Make_(software))

Deployment steps
-----
 * Clone the Docker repo:

```
git clone https://github.com/Jonikru/calculator calculator && cd calculator
```

 * Replace ALL values in `.env` file;
 * Start spinup scenario

```
make docker-env
```
 
 * Run tests
 
```
make phpunit-run
```
 
 * For additional commands
 
```
make help
```
 
 * Start of work
 
```
$calculator = new Calculator();
$result = $calculator->calculate('2+2', Calculator::RNP_CALCULATOR_TYPE);
```
