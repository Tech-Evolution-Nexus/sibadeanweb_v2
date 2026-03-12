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
    checkout scm

    stage("Build") {
        // Menggunakan Docker agar tidak perlu instal PHP di mesin Jenkins
        docker.image('composer:2.7').inside('-u root') {
            sh 'php -v'
            sh 'composer --version'
            sh 'composer install --ignore-platform-reqs'
        }
    }

    stage("Testing") {
        sh 'echo "Ini adalah test"'
    }

    stage("Deploy Prod") {
        // Kita gunakan IP 127.0.0.1 karena Jenkins & Target berada di mesin yang sama (WSL)
        def PROD_HOST = "127.0.0.1" 
        
        sshagent(credentials: ['ssh-prod']) {
            sh 'mkdir -p ~/.ssh'
            // Mengambil sidik jari SSH host
            sh "ssh-keyscan -H ${PROD_HOST} >> ~/.ssh/known_hosts || true"
            
            // Melakukan sinkronisasi file
            sh """
                rsync -rav --delete ./ \
                kholzt@${PROD_HOST}:/home/kholzt/prod.kelasdevops.xyz/ \
                --exclude=.env --exclude=storage --exclude=.git --exclude=node_modules
            """
            echo "Deploy Berhasil ke folder prod.kelasdevops.xyz"
        }
    }
}
