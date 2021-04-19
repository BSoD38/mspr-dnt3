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
        stage('UnitTests') {
          steps {
            bat 'php bin\\phpunit tests\\UnitTests'
          }
        }

        stage('FunctionalTests') {
          steps {
            bat 'php bin\\phpunit tests\\FunctionalTests'
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
        archiveArtifacts '*'
      }
    }

  }
}