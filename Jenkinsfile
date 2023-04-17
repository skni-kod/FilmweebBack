pipeline{
    agent none
    environment {
        REGISTRY = 'harbor.skni.edu.pl/'
        DOCKER_REGISTRY_CREDENTIALS_ID = 'harbor'
        IMAGE_BACK = 'harbor.skni.edu.pl/library/filmweeb-back'
        IMAGE_NGINX = 'harbor.skni.edu.pl/library/filmweeb-back-nginx'
    }
    stages{
        stage('Sonar'){
            agent{
                label 'host'
            }
            environment {
                SCANNER_HOME = tool 'Scanner'
                ORGANIZATION = "SKNI-KOD"
                PROJECT_NAME = "filmweeb-back"
            }
            steps{
                withCredentials([file(credentialsId: '.env-filmweeb', variable: 'ENV_BACK')]) {
                    sh """
                    rm -rf .env
                    cp $ENV_BACK .env"""
                }
                withSonarQubeEnv('Sonarqube') {
                sh """$SCANNER_HOME/bin/sonar-scanner -Dsonar.organization=$ORGANIZATION \
                -Dsonar.projectKey=$PROJECT_NAME \
                -Dsonar.sources=. \
                -Dsonar.sourceEncoding=UTF-8 \
                -Dsonar.language=php \
                -Dsonar.php.file.suffixes=.php"""
                }
            }
        }
/*        stage("Quality Gate") {
            steps {
                timeout(time: 1, unit: 'HOURS') {
                    // Parameter indicates whether to set pipeline to UNSTABLE if Quality Gate fails
                    // true = set pipeline to UNSTABLE, false = don't
                    waitForQualityGate abortPipeline: true
                }
            }
        }*/
        stage('Scan source') {
            agent{
                label 'host'
            }
            steps {
                sh 'curl -sfL https://raw.githubusercontent.com/aquasecurity/trivy/main/contrib/html.tpl > html.tpl'
                // Scan all vuln levels
                sh 'mkdir -p reports'
                sh 'trivy filesystem --ignore-unfixed --vuln-type os,library --format template --template "@html.tpl" -o reports/php.html .'
                // Scan again and fail on CRITICAL vulns
                sh 'trivy filesystem --ignore-unfixed --vuln-type os,library --exit-code 1 --severity CRITICAL .'
            }
        }
        stage('Build Back'){
            agent{
                label 'host'
            }
            steps{
                    sh """
                    sed -i 's|"url": "http://localhost/api"|"url": "https://filmweeb.skni.edu.pl/api"|' storage/api-docs/api-docs.json
                    docker build -t $IMAGE_BACK:$BUILD_ID .
                    docker build -f Dockerfile-nginx -t $IMAGE_NGINX:$BUILD_ID .
                    """
                    stash name: 'compose', includes: 'docker-compose-prod.yml'
            }
        }
        stage('Scan image') {
            agent{
                label 'host'
            }
            steps {
                sh 'mkdir -p reports'
                sh 'trivy image --format template --template "@html.tpl" -o reports/image.html $IMAGE_BACK:$BUILD_ID '
                // Scan again and fail on CRITICAL vulns
                sh 'trivy image --exit-code 1 --severity CRITICAL  $IMAGE_BACK:$BUILD_ID'
                publishHTML([allowMissing: true, 
                    alwaysLinkToLastBuild: true, 
                    keepAll: true, 
                    reportDir: 'reports', 
                    reportFiles: 'php.html, image.html', 
                    reportName: 'Trivy Scan',
                    reportTitles: 'Trivy Scan'
                ])
            }
        }
        stage('Push to registry - back'){
            agent{
                label 'host'
            }
            steps{
                withCredentials([usernamePassword(credentialsId: 'harbor', passwordVariable: 'passwd', usernameVariable: 'username')]) {
                    sh """
                    docker login -u $username -p $passwd  ${env.REGISTRY}
                       docker push $IMAGE_BACK:$BUILD_ID
                       docker tag $IMAGE_BACK:$BUILD_ID $IMAGE_BACK:latest
                       docker push $IMAGE_BACK:latest
                       docker image rm $IMAGE_BACK:latest
                       docker image rm $IMAGE_BACK:$BUILD_ID
                       docker push $IMAGE_NGINX:$BUILD_ID
                       docker tag $IMAGE_NGINX:$BUILD_ID $IMAGE_NGINX:latest
                       docker push $IMAGE_NGINX:latest
                       docker image rm $IMAGE_NGINX:latest
                       docker image rm $IMAGE_NGINX:$BUILD_ID
                    """
                }
            }
        }
        stage('Deploy'){
            agent{
                label 'slave'
            }
            steps{
                deleteDir()
                withCredentials([usernamePassword(credentialsId: 'harbor', passwordVariable: 'passwd', usernameVariable: 'username')]) {
                    unstash 'compose'
                    sh """
                        docker login -u $username -p $passwd  ${env.REGISTRY}
                        docker compose -f docker-compose-prod.yml pull
                        docker compose -f docker-compose-prod.yml up -d --force-recreate
                        docker compose -f docker-compose-prod.yml exec -it php php artisan migrate
                        docker logout ${env.REGISTRY}
                    """
                }
            }
        }
    }
    post {
        always {
            node('host') {
                deleteDir()
            }
        }
    }
}
