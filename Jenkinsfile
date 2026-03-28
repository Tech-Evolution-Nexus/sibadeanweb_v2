node {
    // Definisikan variabel di level node agar bisa diakses semua stage
    def PROD_HOST = "172.20.124.29"
    def PROD_USER = "sagita"
    def PROD_PATH = "/home/sagita/prod.kelasdevops.xyz"

    stage('Checkout') {
        checkout scm
    }

    stage('Build') {
        // Tips: Gunakan image composer resmi agar build lebih cepat (tidak perlu install manual)
        docker.image('composer:2.6').inside('-u root') {
            sh '''
            composer install --ignore-platform-req=ext-gd --no-dev --optimize-autoloader
            '''
        }
    }

    stage('Testing') {
        docker.image('ubuntu:22.04').inside('--entrypoint="" -u root') {
            sh 'echo "Ini adalah test"'
        }
    }

    stage('Deploy') {
        docker.image('agung3wi/alpine-rsync:1.1').inside('--entrypoint="" -u root') {
            sshagent(credentials: ['ssh-prod']) {
                sh """
                # Hapus cache lama dengan mengabaikan Host Key Checking
                ssh -o StrictHostKeyChecking=no ${PROD_USER}@${PROD_HOST} "rm -f ${PROD_PATH}/bootstrap/cache/packages.php ${PROD_PATH}/bootstrap/cache/services.php"

                # Jalankan rsync dengan mengabaikan Host Key Checking
                rsync -rav --delete -e "ssh -o StrictHostKeyChecking=no" ./ \
                    ${PROD_USER}@${PROD_HOST}:${PROD_PATH}/ \
                    --exclude='public/build' \
                    --exclude='node_modules' \
                    --exclude='vendor' \
                    --exclude='storage' \
                    --exclude='.git' \
                    --exclude='.env'
                """
            }
        }
    }
}
