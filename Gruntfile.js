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
			stylesheets: {
				files: [
					{
						expand: true,
						cwd: '.tmp/',
						src: ['combined*.css'],
						dest: 'css'
					}
				]
			},
			javascripts: {
				files: [
					{
						expand: true,
						cwd: 'src/components/bootstrap/dist/js',
						src: ['bootstrap*.js'],
						dest: 'js'
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

		// Deploy to servers
		'ftp-deploy': {
			oddil: {
				auth: {
					host: 'www.skauting.cz',
					port: 21,
					authKey: 'oddil'
				},
				src: '.',
				dest: 'wp-content/themes/dsw-oddil',
				exclusions: [
					'.*',
					'bower.json',
					'package.json',
					'Gruntfile.js',
					'node_modules',
					'doc',
					'src',
				]
			},
			navod: {
				auth: {
					host: 'www.skauting.cz',
					port: 21,
					authKey: 'navod'
				},
				src: '.',
				dest: 'wp-content/themes/dsw-oddil',
				exclusions: [
					'.*',
					'bower.json',
					'package.json',
					'Gruntfile.js',
					'node_modules',
					'doc',
					'src',
				]
			},
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
	grunt.registerTask('deploy-oddil', ['ftp-deploy:oddil']);
	grunt.registerTask('deploy-navod', ['ftp-deploy:navod']);

}