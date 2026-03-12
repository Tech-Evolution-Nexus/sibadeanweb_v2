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
stage("Deploy to Production") {
        docker.image('agung3wi/alpine-rsync:1.1').inside('-u root') {
            // Mengambil private key dari Jenkins Store dan menyimpannya di variabel SSH_KEY (file temporary)
            withCredentials([sshUserPrivateKey(credentialsId: 'ssh-prod', keyFileVariable: 'SSH_KEY')]) {
                def PROD_IP = "172.17.240.38"
                
                sh 'mkdir -p ~/.ssh'
                // Pastikan IP dikenal agar tidak stuck di prompt (Yes/No)
                sh "ssh-keyscan -H ${PROD_IP} >> ~/.ssh/known_hosts"
                
                // Gunakan flag -e untuk memaksa rsync menggunakan file kunci spesifik
                sh """
                    rsync -rav -e "ssh -i ${SSH_KEY} -o StrictHostKeyChecking=no" \
                    --delete ./ \
                    kholzt@${PROD_IP}:/home/kholzt/prod.kelasdevops.xyz/ \
                    --exclude=.env --exclude=storage --exclude=.git --exclude=node_modules
                """
                
                echo "Deployment Berhasil!"
            }
        }
    }
