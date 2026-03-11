node {
    checkout scm

    stage("Build") {
        docker.image('composer:2.7').inside('-u root') {
            sh 'composer install --ignore-platform-req=ext-gd'
        }
    }

    stage("Testing") {
        docker.image('ubuntu').inside('-u root') {
            sh 'echo "Ini adalah test"'
        }
    }

    stage("Deploy") {
        echo "Deploy skipped"
    }
}
