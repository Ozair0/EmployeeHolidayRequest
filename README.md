# Employee Holiday Request Web APP

## -- Setup --
#### --STEP 1: create a copy of .env.example and rename it to .env

#### change bellow database information to your database information
#### DB_CONNECTION=mysql<br />
#### DB_HOST=127.0.0.1<br />
#### DB_PORT=3306<br />
#### DB_DATABASE=laravel<br />
#### DB_USERNAME=root<br />
#### DB_PASSWORD=<br />

#### --STEP 2: install composer dependencies
###<code>composer install</code>

#### --STEP 3: migrate database
###<code>php artisan migrate</code>

#### --STEP 4: install NPM dependencies
###<code>npm install</code>


## -- Run (Dev)--
#### --STEP 1: first 'run npm dev' for front-end
###<code>npm run dev</code>

#### --STEP 2: now run the back-end
###<code>php artisan serve</code>

## -- Run (production)--
#### --STEP 1: first 'run npm production' build for front-end to build for production 
###<code>npm run production</code>

#### --STEP 2: Edit .env for production use
###<code>APP_ENV=production</code>
###<code>APP_DEBUG=false</code>

#### --STEP 3: Optimizing Configuration Loading
###<code>php artisan config:cache</code>

#### --STEP 4: Optimizing Route Loading
###<code>php artisan route:cache</code>

#### --STEP 5: Compile all of the application's Blade templates
###<code>php artisan view:cache</code>

#### --STEP 6: Cache the framework bootstrap files
###<code>php artisan optimize</code>

#### --STEP 7: now your project is production ready!
###<code>Done! Keep coding!</code>
