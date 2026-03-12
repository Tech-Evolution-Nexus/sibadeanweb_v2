// node {
//     checkout scm
//     stage("Build"){
//         docker.image('composer:2.6').inside('-u root') {
//             sh 'rm -f composer.lock'
//             sh 'composer install'
//         }
//     }
//     stage("Testing"){
//         docker.image('ubuntu').inside('-u root') {
//             sh 'echo "Ini adalah test"'
//         }
//     }
//     stage("Deploy"){
//     sshagent(['ssh-prod']) {
//         sh '''
//             ssh -o StrictHostKeyChecking=no -p 22 sagita@172.20.124.29"
//                 echo 'Deploy berhasil!'
//             "
//         '''
//     }
// }
// }


node {
    def PROD_HOST = "172.20.124.29"
    def PROD_USER = "sagita"
    def PROD_PATH = "/home/sagita/prod.kelasdevops.xyz"

    stage("Checkout") {
        checkout scm
    }

    stage("Build") {
        docker.image('composer:2.6').inside('-u root') {
            sh '''
            rm -f composer.lock
            composer install
            '''
        }
    }

    stage("Testing") {
        docker.image('ubuntu').inside('-u root') {
            sh 'echo "Ini adalah test"'
        }
    }

   stage("Deploy"){
        // Gunakan image yang sudah punya rsync + network host agar IP terlihat
        docker.image('agung3wi/alpine-rsync:1.1').inside('--network host -u root') {
            sshagent(['ssh-prod']) {
                sh '''
                    # Pastikan openssh client terinstall untuk ssh-keyscan
                    apk add --no-cache openssh-client || true
                    
                    mkdir -p ~/.ssh
                    chmod 700 ~/.ssh
                    
                    # Scan host (gunakan 127.0.0.1 karena sudah pakai --network host)
                    ssh-keyscan -H 172.20.124.29> ~/.ssh/known_hosts
                    
                    # Jalankan rsync ke folder yang benar (sagita, bukan ubuntu)
                    rsync -avz --delete ./ sagita@172.20.124.29:/home/kholzt/prod.kelasdevops.xyz/ \
                    --exclude=.env --exclude=storage --exclude=.git
                '''
            }
        }
    }
}
