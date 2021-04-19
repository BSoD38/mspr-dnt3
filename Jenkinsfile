pipeline {
  agent any
  stages {
    stage('Dependencies') {
      steps {
        bat(script: 'composer install', returnStatus: true)
      }
    }

    stage('Tests') {
      parallel {
        stage('UnitTest') {
          steps {
            bat 'php bin/php-unit tests/UnitTests'
          }
        }

        stage('WebTest') {
          steps {
            bat 'php bin/php-unit tests/FunctionalTests'
          }
        }

      }
    }

    stage('GenerateDoc') {
      steps {
        bat 'doxygen Doxyfile'
      }
    }

    stage('Archive') {
      steps {
        archiveArtifacts './*'
      }
    }

  }
}