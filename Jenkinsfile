pipeline {
  agent any
  stages {
    stage('Dependencies') {
      steps {
        bat(script: 'composer install', returnStatus: true)
        bat 'php bin\\phpunit'
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

        stage('Linting') {
          steps {
            bat 'php vendor\\bin\\phplint.bat --xml=junit.xml'
          }
        }

      }
    }

    stage('DocsAndReports') {
      parallel {
        stage('GenerateDoc') {
          steps {
            bat 'doxygen Doxyfile'
          }
        }

        stage('JUnitCheck') {
          steps {
            junit '**/junit.xml'
          }
        }

      }
    }

    stage('Archive') {
      steps {
        archiveArtifacts '**'
      }
    }

  }
}