(function() {
	tinymce.create('tinymce.plugins.recentposts', {
		init : function(ed, url) {
			ed.addButton('recentposts', {
			title : recentposts_vars.title,
			image : url+'/recentpostsbutton.png',
			onclick : function() {
				var posts = prompt(recentposts_vars.posts, "1");
				var text = prompt(recentposts_vars.text, recentposts_vars.message);
				var link = prompt(recentposts_vars.link, "false");

				if (text != null && text != ''){
					if (posts != null && posts != '')
						if (link != null && link != '')
							ed.execCommand('mceInsertContent', false, '[recent-posts posts="'+posts+'" linkonly="'+link+'"]'+text+'[/recent-posts]');
						else
							ed.execCommand('mceInsertContent', false, '[recent-posts posts="'+posts+'"]'+text+'[/recent-posts]');
					else
						ed.execCommand('mceInsertContent', false, '[recent-posts]'+text+'[/recent-posts]');
				}
				else {
					if (posts != null && posts != '')
						if (link != null && link != '')
							ed.execCommand('mceInsertContent', false, '[recent-posts posts="'+posts+'" linkonly="'+link+'"]');
						else
							ed.execCommand('mceInsertContent', false, '[recent-posts posts="'+posts+'"]');
					else
						ed.execCommand('mceInsertContent', false, '[recent-posts]');
					}
				}
			});
		},
		createControl : function(n, cm) {
			return null;
		},
		getInfo : function() {
			return {
				longname : "Recent Posts",
				author : 'Litera Tomas',
				authorurl : 'http://www.litera.me',
				infourl : 'http://www.smashingmagazine.com',
				version : "1.0"
			};
		}
	});
	tinymce.PluginManager.add('recentposts', tinymce.plugins.recentposts);
})();
