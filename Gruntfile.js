module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    less: {
      dev: {
        options: {
          cleancss: true
        },
        files: {
          'style.css' : 'style.less'
        }
      }
    },

    phplint: {
      app: ['app.php'],
      testing: ['test/**/*.php']
    },

    phpunit: {
      classes: {
          dir: 'test/'
      },
      options: {
          colors: true
      }
    },

    watch: {
      lessWatch: {
        files: '**/*.less',
        tasks: ['less'],
        options: {
          livereload: true
        }
      },
      phpWatch: {
        files: ['<%= phplint.app %>', '<%= phplint.testing %>'],
        tasks: ['phplint', 'phpunit'],
        options: {
          livereload: true
        }
      }
    }
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-contrib-less');
  grunt.loadNpmTasks('grunt-phplint');
  grunt.loadNpmTasks('grunt-phpunit');

  grunt.registerTask('php', ['phplint', 'phpunit']);
  grunt.registerTask('default', ['less', 'phplint', 'phpunit']);
};