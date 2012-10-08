({
    appDir: "../",
    baseUrl: "js/",
    dir: "../../build",
	useStrict: true,
	
    paths: {
        //"lib/jquery": "empty:",
		//"lib/knockout": "empty:"
    },

    modules: [
        {
            name: "main",
			include: [
				"mod/contributor-view"
			]
        },
		{
            name: "mod/contribution-view",
			exclude:[
				'lib/knockout'
			]
        }
    ]
})
