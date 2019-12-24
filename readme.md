## Passport

hello from the other side~

### Installation

1. Run in your terminal:

```bash
$ git clone https://github.com/hldh214/passport.git
```

2. Set your environment variables in your .env file (use the .env.example as an example);

3. Run in your `passport` folder:

```bash
$ composer install
$ php artisan key:generate
$ php artisan migrate
```

4. follow [this guide](https://laravel.com/docs/5.5/passport#deploying-passport)

### Usage

1. Register a new user at https://passport.dev/signup

2. Depending on your configuration you may need to define a site within NGINX or Apache; Your URL domain may change from localhost to what you have defined.

### TODO

 - timezone
 - remember me
 - i18n
 - role switch w/o re-login
 - tests?
 - more front-end stuff?
 - pagination
 - [console warnings](https://github.com/pusher/pusher-js/issues/392)

### Contribution

Feel free to contribute.

 - Found a bug? Try to find it in issue tracker https://github.com/hldh214/passport/issues ... If this bug is missing - you can add an issue about it.
 - Can/want/like develop? Create pull request and I will check it in nearest time!

### Credit

 - https://github.com/doterlin/vue-example-login
 - https://learnku.com/articles/7358/multiuser-and-multi-field-authentication-system-based-on-laravel-passport-api-two
 - https://medium.com/%40Negaihoshi/laravel-socialite-%E7%B0%A1%E5%96%AE%E7%9A%84%E4%BB%A3%E5%83%B9-ff4ab3f406c1
 - https://github.com/laravel/passport/issues/267
