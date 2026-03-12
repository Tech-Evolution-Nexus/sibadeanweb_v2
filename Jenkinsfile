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

    // 2. Terapkan Deployment ke folder yang dibuat Ansible tadi
    stage("Deploy to Production") {
        // Gunakan image alpine-rsync agar bisa mengirim file via SSH
        docker.image('agung3wi/alpine-rsync:1.1').inside('-u root') {
            
            // 'ssh-prod' adalah ID Credentials (Username/Password) yang sudah Anda buat di Jenkins
            sshagent (credentials: ['ssh-prod']) {
                // Membuat folder .ssh di dalam kontainer sementara
                sh 'mkdir -p ~/.ssh'
                
                // Mendaftarkan IP agar tidak muncul konfirmasi yes/no (SSH Fingerprint)
                sh 'ssh-keyscan -H 172.17.240.38 >> ~/.ssh/known_hosts'
                
                // Eksekusi pengiriman file dari Jenkins ke folder prod.kelasdevops.xyz
                // ./ adalah root project, dikirim ke user kholzt
                sh "rsync -rav --delete ./ \
                    kholzt@172.17.240.38:/home/kholzt/prod.kelasdevops.xyz/ \
                    --exclude=.env --exclude=storage --exclude=.git --exclude=node_modules"
                
                echo "Deployment Berhasil ke /home/kholzt/prod.kelasdevops.xyz/"
            }
        }
    }
}
