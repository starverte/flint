module.exports = function(grunt) {
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),
    shell: {
      phpcs_clone: {
        command: 'git clone https://github.com/squizlabs/PHP_CodeSniffer.git tests/php-codesniffer'
      },
      wpcs_clone: {
        command: 'git clone https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards.git tests/wordpress-coding-standards'
      },
      phpcs_config: {
        command: 'tests/php-codesniffer/scripts/phpcs --config-set installed_paths ../wordpress-coding-standards'
      },
      reset_tests: {
        command: 'echo "" > tests/results'
      },
      syntax_tests: {
        command: "bash tests/syntax.sh >> tests/results"
      },
      phpcs_tests: {
        command: 'tests/php-codesniffer/scripts/phpcs -p -s -v -n . --standard=./codesniffer.ruleset.xml --extensions=php >> tests/results'
      }
    }
  });

  grunt.loadNpmTasks( 'grunt-shell' );
  grunt.registerTask( 'init', ['shell:phpcs_clone', 'shell:wpcs_clone', 'shell:phpcs_config'] );
  grunt.registerTask( 'test', ['shell:reset_tests', 'shell:syntax_tests', 'shell:phpcs_tests'] );
}
