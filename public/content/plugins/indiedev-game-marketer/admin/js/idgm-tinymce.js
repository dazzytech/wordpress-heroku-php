tinymce.create( 'tinymce.plugins.indiedev', {

    init: function( ed, url ) {

        ed.addButton( 'idgmoption', {
                title: 'Indiedev Game Marketer',
                cmd:   'idgmoption',
                image: url + '/button.png'
        });

        ed.addCommand( 'idgmoption', function() {

            var idgm_text = ed.selection.getContent({
                'format': 'html'
            });

            ed.windowManager.open({
                // Modal settings
                title: 'Indiedev Game Marketer',
                width: 820,
                height: 390,
                inline: 1,
                id: 'idgm-insert-dialog',
                buttons: [{
                        text: 'Insert',
                        id: 'idgm-button-insert',
                        class: 'insert',
                        onclick: function( e ) {
                            ed.execCommand('mceReplaceContent', false, '' + idgm_text + '' + jQuery('#idgm-press-release-textarea').val());
                            ed.windowManager.close();
                        },
                },
                {
                        text: 'Cancel',
                        id: 'idgm-button-cancel',
                        onclick: 'close'
                }],
            });

            jQuery.ajax({
              type: 'POST',
              url: ajaxurl,
              data: { action: 'idgm_ajax_tinymce' },
              success: function(response){
                  jQuery('#idgm-insert-dialog-body').html(response);
              }
            });                               

        });

    },

    createControl: function( n, cm ) {
        return null;
    },

    getInfo: function() {

        return {

                longname:  'Indiedev Game Marketer Option',
                author:    'BLACK LODGE GAMES, LLC',
                authorurl: 'http://blacklodgegames.com',
                version:   '0.0.1'

        };

    }

});

tinymce.PluginManager.add( 'indiedev', tinymce.plugins.indiedev );

