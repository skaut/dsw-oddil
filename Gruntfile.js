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

		conventionalChangelog: {
			options: {
				changelogOpts: {
					// conventional-changelog options go here
					preset: 'angular'
				},
				context: {
					// context goes here
				},
				gitRawCommitsOpts: {
					// git-raw-commits options go here
				},
				parserOpts: {
					// conventional-commits-parser options go here
				},
				writerOpts: {
					// conventional-changelog-writer options go here
				}
			},
			release: {
				src: 'CHANGELOG.md'
			}
		},

		bump: {
			options: {
				files: [
					'package.json',
					'bower.json',
				],
				updateConfigs: ['pkg'],
				commitFiles: [
					'package.json',
					'bower.json',
					'CHANGELOG.md',
				],
				commitMessage: 'Release v%VERSION%',
				createTag: true,
				tagName: 'v%VERSION%',
				tagMessage: 'Release v%VERSION%',
				push: true,
				pushTo: 'origin',
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
			piskoviste: {
				auth: {
					host: 'www.skauting.cz',
					port: 21,
					authKey: 'piskoviste'
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
			dobryweb: {
				auth: {
					host: 'www.skauting.cz',
					port: 21,
					authKey: 'dobryweb'
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

		compress: {
			installPackage: {
				options: {
					archive: '<%= pkg.name %>-<%= pkg.version %>.zip',
					mode: 'zip',
					pretty: true,
				},
				files: [
					{
						src: [
							'inc/*',
							'css/*',
							'fonts/*',
							'img/**',
							'js/*',
							'languages/*',
							'template-parts/*',
							'*.php',
							'*.md',
							'style.css',
							'screenshot.png',
							'readme.txt',
						],
						dest: '<%= pkg.name%>/',
					},
				]
			}
		}

	});

	grunt.registerTask('default', ['less', 'cssmin', 'copy']);

	grunt.registerTask('build', 'Bumps version and builds JS.', function(version_type) {
		if (version_type !== 'patch' && version_type !== 'minor' && version_type !== 'major') {
		version_type = 'minor';
		}
		return grunt.task.run([
			"bump-only:" + version_type,
			'less',
			'cssmin',
			'imagemin',
			'copy',
			'clean',
			'conventionalChangelog',
			'bump-commit',
			'compress',
		]);
	});

	grunt.registerTask('deploy', 'Deploy files to server over FTP.', function(account) {
		if (typeof account !== 'undefined') {
			return grunt.task.run(['ftp-deploy:' + account]);
		} else {
			return grunt.task.run([
				'ftp-deploy:oddil',
				'ftp-deploy:piskoviste',
				'ftp-deploy:dobryweb',
				'ftp-deploy:navod',
			]);
		}
	});

	grunt.registerTask('dev', ['build', 'watch']);
};
