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
					'.tmp/combined.min.css': '.tmp/combined.css',
					'css/blue.min.css': 'css/blue.css',
					'css/green.min.css': 'css/green.css',
					'css/red.min.css': 'css/red.css',
					'css/violet.min.css': 'css/violet.css',
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

		changelog: {
			sample: {
				options: {
					dest: 'CHANGELOG.md',
				}
			}
		},

		bump: {
			options: {
				files: ['package.json', 'bower.json'],
				updateConfigs: ['pkg'],
				commitFiles: ['-a'],
				pushTo: 'origin'
			}
		},

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

	grunt.registerTask('build', 'Bumps version and builds JS.', function(version_type) {
		if (version_type !== 'patch' && version_type !== 'minor' && version_type !== 'major') {
		version_type = 'patch';
		}
		return grunt.task.run([
			"bump-only:" + version_type,
			'less',
			'cssmin',
			'imagemin',
			'copy',
			'clean',
			//'changelog'
			//'bump-commit'
		]);
	});

	grunt.registerTask('dev', ['build', 'watch']);
	grunt.registerTask('deploy-oddil', ['ftp-deploy:oddil']);
	grunt.registerTask('deploy-navod', ['ftp-deploy:navod']);

}