# This is CNQA Web Dashboard


## Development Environment

This application is based on Yii2 Framework, advanced template.[Click here to know more about the framework](https://github.com/yiisoft/yii2-app-advanced) 

### Requirements

- Docker & Docker Compose

### Steps

- Clone this repo
- Go to the root directory of this repo and start all docker services by `docker-compose up --build -d`. This will start frontend, backend and db cservices

### Make sure vendor folder is populated

- After services have been started make sure you have a folder `vendor` present in the root directory. if not, ssh into either frontend or backend container and run `composer update`, this will pull down all dependencies needed.

### Initiate project dependencies 

- Occasionaly ssh into the backend container and run `./init`, this will initiate the development mode within the application


### Application configurations

- Go to `common/config/main-local.php` and add/replace database and mailer configurations. Sample is shared below

```php
'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host={insert_db_host};dbname={insert_db_name}',
            'username' => '{insert_mysql_username}',
            'password' => '{insert_mysql_password}',
            'charset' => 'utf8',
        ],
		'mailer' => [
			'class' => \yii\symfonymailer\Mailer::class,
			'viewPath' => '@common/mail',
			'useFileTransport' => false,
			'transport' => [
				'scheme' => 'smtp',
				'class' => 'Swift_SmtpTransport',
				'host' => "{insert_mailer_host}",
				'username' => "{insert_mailer_username}",
				'password' => "{insert_mailer_password}",
				'port' => "{insert_mailer_port}",
				'encryption' => "tls",
			],
		],
    ],
```


### Open the application in the browser

- Open `localhost:24081` to confirm that back office can be accessed.

<span style="color: green; font-weight: bold "> DONE! </span>
