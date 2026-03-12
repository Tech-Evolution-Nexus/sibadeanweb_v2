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
    sh 'php -v'
    sh 'composer --version'
    sh 'composer install'
  }

  stage("Testing") {
    sh 'echo "Ini adalah test"'
  }

  stage("Deploy Prod") {
    withEnv(["PROD_HOST=172.17.240.38"]) {
      sshagent(credentials: ['ssh-prod']) {
        sh 'mkdir -p ~/.ssh'
        sh 'ssh-keyscan -H "$PROD_HOST" >> ~/.ssh/known_hosts'
        sh 'rsync -rav --delete ./ kholzt@$PROD_HOST:/home/kholzt/prod.kelasdevops.xyz/ --exclude=.env --exclude=storage --exclude=.git'
      }
    }
  }
}
