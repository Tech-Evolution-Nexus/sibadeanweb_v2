node {
    checkout scm

    // Build stage
    stage("Build") {
        docker.image('composer:2.7').inside('-u root') {
            sh 'composer install --ignore-platform-req=ext-gd'
        }
    }

    // Testing stage
    stage("Testing") {
        docker.image('ubuntu').inside('-u root') {
            sh 'echo "Ini adalah test"'
        }
    }

    // Deploy stage
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
