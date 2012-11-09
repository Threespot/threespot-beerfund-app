module.exports = function( grunt ) {

	grunt.initConfig({
		requirejs: {
			compile: {
				options: {
					appDir: "./src",
				    baseUrl: "js",
				    dir: "./dist",
					optimize: "uglify",
					optimizeCss: "standard",
					exclude: [],
					fileExclusionRegExp: /^.+\.sql$|^bf-connection.php$/,
				    modules: [
				        {
				            name: "main"
				        }
				    ]
				}
			}
		}
	});

	grunt.loadNpmTasks('grunt-contrib-requirejs');
	grunt.registerTask("default", "requirejs");
};