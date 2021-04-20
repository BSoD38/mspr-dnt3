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

      }
    }

    stage('GenerateDoc') {
      steps {
        bat 'doxygen Doxyfile'
      }
    }

    stage('CopyToServer') {
      steps {
        bat 'xcopy . %DNT3_LOC% /s /e /c /y'
      }
    }

    stage('ClearCache') {
      steps {
        bat 'php %DNT3_LOC%\\bin\\console cache:clear'
      }
    }

    stage('UpdateServer') {
      parallel {
        stage('MigrateDB') {
          steps {
            bat 'php %DNT3_LOC%\\bin\\console d:s:u --force'
          }
        }

        stage('InstallAssets') {
          steps {
            bat 'php %DNT3_LOC%\\bin\\console assets:install'
          }
        }

      }
    }

  }
}