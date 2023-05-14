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
                // Scan all vuln levels
                sh 'mkdir -p reports'
                sh 'trivy filesystem --ignore-unfixed --vuln-type os,library --format json -o reports/php.json .'
                // Scan again and fail on CRITICAL vulns
                sh 'trivy filesystem --ignore-unfixed --vuln-type os,library --exit-code 1 --severity CRITICAL .'
		archiveArtifacts 'reports/php.json'
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
            }
        }
        stage('Scan image') {
            agent{
                label 'host'
            }
            steps {
                sh 'mkdir -p reports'
                sh 'trivy image --format json -o reports/image.json $IMAGE_BACK:$BUILD_ID '
                // Scan again and fail on CRITICAL vulns
                sh 'trivy image --exit-code 1 --severity CRITICAL  $IMAGE_BACK:$BUILD_ID '
		        archiveArtifacts 'reports/image.json'
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
        stage('Update k8s config') {
            agent{
                label 'host'
            }
            steps {
		sh 'sed -i "s|harbor.skni.edu.pl/library/filmweeb-back-nginx:latest|harbor.skni.edu.pl/library/filmweeb-back-nginx:${BUILD_ID}|g" k8s/nginx-deployment.yaml'
        	sh 'sed -i "s|harbor.skni.edu.pl/library/filmweeb-back:latest|harbor.skni.edu.pl/library/filmweeb-back:${BUILD_ID}|g" k8s/php-deployment.yaml'
        	sh 'sed -i "s|harbor.skni.edu.pl/library/filmweeb-back:latest|harbor.skni.edu.pl/library/filmweeb-back:${BUILD_ID}|g" k8s/db-migration-job.yaml'
                stash name: 'kubernetes', includes: 'k8s/**'
            }
        }
        stage('Deploy'){
	    agent {
	        docker {
	            image 'bitnami/kubectl:latest'
	            args "--entrypoint=''"
	        }
	    }
            steps{
		        unstash 'kubernetes'
                withCredentials([file(credentialsId: 'k8s-kubeconfig', variable: 'CONFIG')]) {
                        sh """
        	    		    mv k8s/* .
                            kubectl --kubeconfig=$CONFIG delete job --ignore-not-found=true -n filmweeb filmweeb-migration
        	    		    kubectl --kubeconfig=$CONFIG apply -f db-migration-job.yaml
        	    		    kubectl --kubeconfig=$CONFIG apply -f nginx-deployment.yaml
        	    		    kubectl --kubeconfig=$CONFIG apply -f nginx-service.yaml
        	    		    kubectl --kubeconfig=$CONFIG apply -f php-deployment.yaml
        	    		    kubectl --kubeconfig=$CONFIG apply -f php-service.yaml	
        	    		    kubectl --kubeconfig=$CONFIG apply -f ingress.yaml
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
