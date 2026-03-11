node {
    checkout scm

    // Build stage
   // Build stage
stage("Build") {
    docker.image('php:8.2-cli').inside('-u root') {
        sh 'apt update'
        sh 'apt install -y git unzip libpng-dev'
        sh 'docker-php-ext-install gd'
        sh 'curl -sS https://getcomposer.org/installer | php'
        sh 'php composer.phar install'
    }
}
    // Testing stage
    stage("Testing") {
        docker.image('ubuntu').inside('-u root') {
            sh 'echo "Ini adalah test"'
        }
    }

    // Deploy to production stage
    stage("Deploy") {
        docker.image('agung3wi/alpine-rsync:1.1').inside('-u root') {
            sshagent (credentials: ['ssh-prod']) {
                sh 'mkdir -p ~/.ssh'
                sh 'ssh-keyscan -H "$PROD_HOST" > ~/.ssh/known_hosts'
                sh "rsync -rav --delete ./laravel/ ubuntu@$PROD_HOST:/home/ubuntu/prod.kelasdevops.xyz/ --exclude=.env --exclude=storage --exclude=.git"
            }
        }
    }
}
