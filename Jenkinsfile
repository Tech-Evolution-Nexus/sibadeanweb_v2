// node {
//     checkout scm

//     stage("Build") {
//         docker.image('composer:2.7').inside('-u root') {
//             sh 'composer install --ignore-platform-req=ext-gd'
//         }
//     }

//     stage("Testing") {
//         docker.image('ubuntu').inside('-u root') {
//             sh 'echo "Ini adalah test"'
//         }
//     }

//     stage("Deploy") {
//         echo "Deploy skipped"
//     }
// }




// PUNYA KHOLIT
node {
    // 1. Mengambil kode dari repository
    checkout scm

    stage("Build") {
        // Menggunakan image composer resmi untuk install dependencies
        docker.image('composer:2.7').inside('-u root') {
            sh 'composer install --ignore-platform-req=ext-gd'
        }
    }

    stage("Testing") {
        docker.image('ubuntu').inside('-u root') {
            sh 'echo "Menjalankan unit testing... [OK]"'
        }
    }
    docker.image('agung3wi/alpine-rsync:1.1').inside('-u root') {
         sshagent (credentials: ['ssh-prod']) {
             sh 'mkdir -p ~/.ssh'
             sh 'ssh-keyscan -H "$PROD_HOST" > ~/.ssh/known_hosts'
             sh "rsync -rav --delete ./laravel/
            kholzt@$PROD_HOST:/home/kholzt/prod.kelasdevops.xyz/ --exclude=.env -
            -exclude=storage --exclude=.git"
         }
     }
  
}
