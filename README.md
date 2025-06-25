# tbuy



```bash
# clone
git clone

#copy the .env.example content and make a .env file for both bakckend and frontend

#install composer backend
composer install

#install npm frontend
npm install

#generate app key in backend
php artisan key:generate

#run the command backend
./vendor/bin/sail up -d

#migrate and seed the data backend
./vendor/bin/sail artisan migrate:fresh --seed

#for the root permission run this command in the terminal of docker laravel.test container
chown -R sail:sail storage

#run this command in frontend
npm run dev

#got to the login page


#run this if faced permission issues for log file
chmod -R 775 storage


#run this command for running queue backend
./vendor/bin/sail artisan queue:work

```

