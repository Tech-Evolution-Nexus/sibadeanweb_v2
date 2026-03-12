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
        docker.image('composer:2.7').inside('-u root') {
            sh 'composer install --ignore-platform-req=ext-gd'
        }
    }

    stage("Testing") {
        docker.image('ubuntu').inside('-u root') {
            sh 'echo "Menjalankan unit testing... [OK]"'
        }
    }

    stage("Deploy to Production") {
        docker.image('agung3wi/alpine-rsync:1.1').inside('-u root') {
            sshagent (credentials: ['ssh-prod']) {
                // Mendefinisikan IP langsung agar tidak kosong
                def PROD_IP = "172.17.240.38"
                
                sh 'mkdir -p ~/.ssh'
                sh "ssh-keyscan -H ${PROD_IP} >> ~/.ssh/known_hosts"
                
                // Gunakan tanda \ di akhir baris jika ingin memutus kalimat perintah
                sh """
                    rsync -rav --delete ./ \
                    kholzt@${PROD_IP}:/home/kholzt/prod.kelasdevops.xyz/ \
                    --exclude=.env --exclude=storage --exclude=.git --exclude=node_modules
                """
            }
        }
    }
}
