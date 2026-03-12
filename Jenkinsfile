node {

    stage('Checkout') {
        checkout scm
    }

    stage('Build') {
        docker.image('php:8.2-cli').inside('--entrypoint="" -u root') {
            sh '''
            apt-get update
            apt-get install -y git unzip libzip-dev curl

            docker-php-ext-install zip

            curl -sS https://getcomposer.org/installer | php
            mv composer.phar /usr/local/bin/composer

            composer install --ignore-platform-req=ext-gd
            '''
        }
    }

    stage('Testing') {
        docker.image('ubuntu:22.04').inside('--entrypoint="" -u root') {
            sh '''
            echo "Ini adalah test"
            '''
        }
    }

    stage('Deploy') {
        docker.image('agung3wi/alpine-rsync:1.1').inside('--entrypoint="" -u root') {
            sshagent(credentials: ['ssh-prod']) {
                sh '''
                mkdir -p ~/.ssh
                ssh-keyscan -H $PROD_HOST >> ~/.ssh/known_hosts

                # Hapus cache lama supaya rsync tidak gagal
                ssh sagita@$PROD_HOST "rm -f /home/sagita/prod.kelasdevops.xyz/bootstrap/cache/packages.php /home/sagita/prod.kelasdevops.xyz/bootstrap/cache/services.php"

                # Jalankan rsync
                rsync -rav --delete ./ \
                    newbieflank@$PROD_HOST:/home/sagita/prod.kelasdevops.xyz/ \
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
