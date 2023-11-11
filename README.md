### Getting started

Clone the repository
```bash
$ git clone https://github.com/wribeiiro/futebol-ieq
```
Switch to the repo `back` folder
```bash
$ cd futebol-ieq/back
```
Install all the dependencies using composer
```bash
$ composer install
```
Set the database params and fill them. `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` in .env file.
```bash
cp .env.example .env
```

Start the local development server
```bash
$ php -S localhost:8000
```
Switch to the repo `front` folder
```bash
$ cd futebol-ieq/front
```
Install all the dependencies using npm
```bash
$ npm install
```
And then start serve:
```
$ npm start
```
