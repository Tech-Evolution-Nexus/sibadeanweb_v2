node {
    checkout scm
    stage("Build"){
        docker.image('composer:2.6').inside('-u root') {
            sh 'rm -f composer.lock'
            sh 'composer install'
        }
    }
    stage("Testing"){
        docker.image('ubuntu').inside('-u root') {
            sh 'echo "Ini adalah test"'
        }
    }
    stage("Deploy"){
    sshagent(['ssh-prod']) {
        sh '''
            ssh -o StrictHostKeyChecking=no -p 22 sagita@ 172.20.124.29"
                echo 'Deploy berhasil!'
            "
        '''
    }
}
}
