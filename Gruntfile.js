module.exports = function (grunt) {

	// Autoload all Grunt tasks
	require('matchdep').filterAll('grunt-*').forEach(grunt.loadNpmTasks);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// Compile LESS
		less: {
			dev: {
				files: {
					'.tmp/main.css': 'src/main.less'
				},
				options: {
					sourceMap: true
				}
			}
		},

		// Remove unused CSS
		uncss: {
			dev: {
				files: {
					'.tmp/<%= pkg.name %>.clean.css': 'src/index.html'
				},
				options: {
					ignore: [/svg/],
					stylesheets: ['../.tmp/main.css']
				}
			}
		},

		// Minify CSS
		cssmin: {
			dist: {
				files: {
					'css/combined.min.css': '.tmp/main.css'
				}
			}
		},

		// Clean temporary files
		clean: [
			'.tmp'
		],

		// Watch task
		watch: {
			less: {
				files: ['src/**/*.less'],
				tasks: [
					'less',
					'cssmin'
				]
			}
		},

	});

	grunt.registerTask('default', ['less', 'cssmin']);
	grunt.registerTask('build', [
		'less',
		'uncss',
		'cssmin',
		'clean'
	]);
	grunt.registerTask('dev', ['build', 'browserSync', 'watch']);

}