module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    copy: {
      bootstrap_css: {
        expand: true,
        flatten: true,
        src: 'node_modules/bootstrap/dist/css/*',
        dest: 'css/',
      },
      bootstrap_fonts: {
        expand: true,
        flatten: true,
        src: 'node_modules/bootstrap/dist/fonts/*',
        dest: 'fonts/',
      },
      bootstrap_js: {
        expand: true,
        flatten: true,
        src: 'node_modules/bootstrap/dist/js/*',
        dest: 'js/',
      },
    },
    csscomb: {
      main: {
        options: {
          config: './.csscomb.json'
        },
        files: {
          'style.css': ['style.css']
        }
      }
    },
    shell: {
      phpcs_config: {
        command: 'vendor/bin/phpcs --config-set installed_paths ../../wp-coding-standards/wpcs'
      },
      syntax_tests: {
        command: "find . -name '*.php' -not -path './node_modules/*' -not -path './tests/*' -not -path './vendor/*' -exec php -lf '{}' \\;"
      },
      phpcs_tests: {
        command: 'vendor/bin/phpcs -p -s -v -n . --standard=./.phpcs.rules.xml --extensions=php --ignore=tests/*,node_modules/*,vendor/*'
      }
    }
  });

  grunt.loadNpmTasks( 'grunt-contrib-copy' );
  grunt.loadNpmTasks( 'grunt-shell' );
  grunt.loadNpmTasks( 'grunt-csscomb' );
  grunt.registerTask( 'init', ['shell:phpcs_config'] );
  grunt.registerTask( 'build', ['csscomb', 'copy'] );
  grunt.registerTask( 'test', ['shell:syntax_tests', 'shell:phpcs_tests'] );
}
