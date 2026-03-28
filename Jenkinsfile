node {

    environment {
        DOCKER_HOST = 'unix:///var/run/docker.sock'
        COMPOSER_CACHE_DIR = '/tmp/composer-cache'
        COMPOSER_HOME = '/tmp'
    }

    stage('Checkout') {
        checkout scm
    }

    stage('Build') {
        docker.image('php:8.2-cli').inside('--entrypoint="" -u root') {
            sh '''
            set -e

            apt-get update
            apt-get install -y git unzip libzip-dev curl

            docker-php-ext-install zip

            # install composer
            curl -sS https://getcomposer.org/installer | php
            mv composer.phar /usr/local/bin/composer

            # fix composer cache
            mkdir -p $COMPOSER_CACHE_DIR

            # install dependency
            composer install --no-interaction --prefer-dist --ignore-platform-req=ext-gd
            '''
        }
    }

    stage('Testing') {
        docker.image('ubuntu:22.04').inside('--entrypoint="" -u root') {
            sh '''
            set -e
            echo "Ini adalah test"
            '''
        }
    }

    stage('Deploy') {
        docker.image('agung3wi/alpine-rsync:1.1').inside('--entrypoint="" -u root') {
            sshagent(credentials: ['ssh-prod']) {
                sh '''
                set -e

                mkdir -p ~/.ssh
                ssh-keyscan -H 172.20.124.29 >> ~/.ssh/known_hosts

                # hapus cache lama
                ssh sagita@172.20.124.29 "rm -f /home/sagita/prod.kelasdevops.xyz/bootstrap/cache/packages.php /home/sagita/prod.kelasdevops.xyz/bootstrap/cache/services.php"

                # rsync deploy
                rsync -rav --delete ./ \
                    sagita@172.20.124.29:/home/sagita/prod.kelasdevops.xyz/ \
                    --exclude='public/build' \
                    --exclude='node_modules' \
                    --exclude='vendor' \
                    --exclude='storage' \
                    --exclude='.git' \
                    --exclude='.env'
                '''
            }
        }
    }
}
