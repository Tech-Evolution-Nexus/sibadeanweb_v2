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

    stage("Deploy"){
        // Gunakan --network host agar container bisa menembus firewall WSL
        docker.image('agung3wi/alpine-rsync:1.1').inside('--network host -u root') {
            withEnv(['PROD_HOST=172.17.240.38']) {
                sshagent (credentials: ['ssh-prod']) {
                    sh '''
                        apk add --no-cache openssh-client || true
                        mkdir -p ~/.ssh
                        chmod 700 ~/.ssh
                        
                        # Ambil fingerprint terbaru
                        ssh-keyscan -H "$PROD_HOST" > ~/.ssh/known_hosts
                        
                        # Rsync dengan user kholzt
                        rsync -rav --delete ./ kholzt@$PROD_HOST:/home/kholzt/prod.kelasdevops.xyz/ \
                        --exclude=.env --exclude=storage --exclude=.git
                    '''
                }
            }
        }
    }

}
