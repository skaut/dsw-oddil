module.exports = function (grunt) {

	// Autoload all Grunt tasks
	require('matchdep').filterAll('grunt-*').forEach(grunt.loadNpmTasks);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// Compile LESS
		less: {
			dev: {
				files: {
					'.tmp/combined.css': 'src/main.less',
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
					'.tmp/combined.min.css': '.tmp/combined.css'
				}
			}
		},

		// Minify Images
		imagemin: {
			dynamic: {
				files: [{
					expand: true,
					cwd: 'src/images',
					src: ['*.{png,jpg,gif}'],
					dest: '.tmp'
				}]
			}
		},

		// Copy unprocessed files from src to www
		copy: {
			images: {
				files: [
					{
						expand: true,
						cwd: '.tmp/',
						src: ['*.{png,jpg,gif}'],
						dest: 'img'
					}
				]
			},
			fonts: {
				files: [
					{
						expand: true,
						cwd: 'src/fonts/',
						src: ['**'],
						dest: 'fonts'
					}
				]
			},
			css: {
				files: [
					{
						expand: true,
						cwd: '.tmp/',
						src: ['combined*.css'],
						dest: 'css'
					}
				]
			},
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
					'cssmin',
					'copy'
				]
			}
		},

	});

	grunt.registerTask('default', ['less', 'cssmin', 'copy']);
	grunt.registerTask('build', [
		'less',
		'cssmin',
		'imagemin',
		'copy',
		'clean'
	]);
	grunt.registerTask('dev', ['build', 'browserSync', 'watch']);

}