(function() {
	tinymce.create('tinymce.plugins.recentposts', {
		init : function(ed, url) {
			ed.addButton('recentposts', {
			title : 'Nedávné příspěvky',
			image : url+'/recentpostsbutton.png',
			onclick : function() {
				var posts = prompt("Počet příspěvků", "1");
				var text = prompt("Nadpis", "Toto je text nadpisu");
				var link = prompt("Zobrazit pouze odkazy", "false");

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