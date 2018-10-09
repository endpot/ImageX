# ImageX
A free image host built with laravel and B2. Demo: [iEndPot](https://i.endpot.com)

# Features
1. Built on Laravel, the best PHP Framework
2. All images are stored on B2 Cloud Storage (High Performance Cloud Storage at 1/4 the Price)
3. Only hot images are cached (hot images are those viewed by visitors recently)
4. Dupe checking: When a duplicate image is uploaded, a connection would be created at the database and no disk space would be consumed.
5. NFSW tag support
6. and so on...

# How to use
## TL;DR
1. Clone this project to your web application dir
2. Rename .env.example to .env, and change the settings in it, especially those B2 related (please use master key instead of application key from your B2 account here)
3. Set up crontab to run (Laravel Schedule)[https://laravel.com/docs/scheduling#introduction]

## Docker
Please see [HunterXuan/imagex-docker](https://github.com/HunterXuan/imagex-docker)

## Contributing
Thank you for considering contributing to this project! Feel free to raise your question, share your ideas or make a pull request.

# License
This project is open-sourced software licensed under the (MIT license)[https://github.com/HunterXuan/ImageX/blob/master/LICENSE].
