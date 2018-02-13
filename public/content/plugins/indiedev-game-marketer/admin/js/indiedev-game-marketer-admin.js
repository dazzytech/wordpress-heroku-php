(function( $ ) {
	'use strict';

        $(document).on( 'click', '.nav-tab-wrapper a', function() {
                        $('section').hide();
                        $('section').eq($(this).index()).show();
                        
                        return false;
        });
 
        jQuery(document).ready(function() {
            jQuery('#idgm-tweet-box').on('input', function() {
                
                var style_value_for_count = '#000000';
                if(this.value.length > 140) {
                    style_value_for_count = '#ff0000';
                }
                jQuery("#idgm-twitter-characters").html( "<span style='color:"+style_value_for_count+"'>" + (140 - this.value.length) + "</span>" );
                
            });
    
            jQuery('#idgm-twitter-select').change(function() {
                if( jQuery('#idgm-twitter-select').val() === 'once' ) {
                    jQuery('#idgm-tweet-schedule').hide();                
                    jQuery('#idgm-tweet-date').show();      
                    jQuery('#idgm-date-time-div').show();
                } else if (jQuery('#idgm-twitter-select').val() === 'repeat') {
                    jQuery('#idgm-tweet-date').hide();
                    jQuery('#idgm-tweet-schedule').show();
                    jQuery('#idgm-date-time-div').show();
                } else if (jQuery('#idgm-twitter-select').val() === 'now' ) {
                    jQuery('#idgm-date-time-div').hide();
                    jQuery('#idgm-tweet-schedule').hide(); 
                    jQuery('#idgm-tweet-date').hide();
                }
            });    
    
            jQuery('#idgm-new-game-form-release-date-a').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-new-game-form-release-date-b').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-new-game-form-release-date-c').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-new-game-form-release-date-d').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-new-game-form-release-date-e').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-new-game-form-release-date-f').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-new-game-form-release-date-g').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-new-game-form-release-date-h').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-new-game-form-release-date-i').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-new-game-form-release-date-j').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-edit-game-form-release-date-a').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-edit-game-form-release-date-b').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-edit-game-form-release-date-c').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-edit-game-form-release-date-d').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-edit-game-form-release-date-e').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-edit-game-form-release-date-f').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-edit-game-form-release-date-g').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-edit-game-form-release-date-h').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-edit-game-form-release-date-i').datepicker({dateFormat : 'yy-mm-dd'});
            jQuery('#idgm-edit-game-form-release-date-j').datepicker({dateFormat : 'yy-mm-dd'});    
            jQuery('#idgm-tweet-date').datepicker({dateFormat : 'yy-mm-dd'});    
            
            var mediaUploaderA;
            var mediaUploaderB;
            var mediaUploaderC;
            var mediaUploaderD;
            var mediaUploaderE;
            var attachment;
            
            jQuery('#idgm-upload-button-form-logo').click(function(e) {
                e.preventDefault();
                if (mediaUploaderA) {
                    mediaUploaderA.open();
                    return;
                }

                mediaUploaderA = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                    text: 'Choose Image'
                }, multiple: false });

                mediaUploaderA.on('select', function() {
                    attachment = mediaUploaderA.state().get('selection').first().toJSON();
                    jQuery('#idgm-new-game-form-logo').val(attachment.url);
                });

                mediaUploaderA.open();
            });            
           
            jQuery('#idgm-upload-button-form-icon').click(function(e) {
                e.preventDefault();
                if (mediaUploaderB) {
                    mediaUploaderB.open();
                    return;
                }

                mediaUploaderB = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                    text: 'Choose Image'
                }, multiple: false });

                mediaUploaderB.on('select', function() {
                    attachment = mediaUploaderB.state().get('selection').first().toJSON();
                    jQuery('#idgm-new-game-form-icon').val(attachment.url);
                });

                mediaUploaderB.open();
            });       
            

            jQuery('#idgm-upload-button-edit-form-logo').click(function(e) {
                e.preventDefault();
                if (mediaUploaderC) {
                    mediaUploaderC.open();
                    return;
                }

                mediaUploaderC = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                    text: 'Choose Image'
                }, multiple: false });

                mediaUploaderC.on('select', function() {
                    attachment = mediaUploaderC.state().get('selection').first().toJSON();
                    jQuery('#idgm-edit-game-form-logo').val(attachment.url);
                });

                mediaUploaderC.open();
            });     
            
            jQuery('#idgm-upload-button-edit-form-icon').click(function(e) {
                e.preventDefault();
                if (mediaUploaderD) {
                    mediaUploaderD.open();
                    return;
                }

                mediaUploaderD = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    button: {
                    text: 'Choose Image'
                }, multiple: false });

                mediaUploaderD.on('select', function() {
                    attachment = mediaUploaderD.state().get('selection').first().toJSON();
                    jQuery('#idgm-edit-game-form-icon').val(attachment.url);
                });

                mediaUploaderD.open();
            });             
            
            jQuery('#idgm-upload-twitter-button').click(function(e) {
                e.preventDefault();
                if (mediaUploaderE) {
                    mediaUploaderE.open();
                    return;
                }

                mediaUploaderE = wp.media.frames.file_frame = wp.media({
                    title: 'Choose Image',
                    library: { type: "image" },
                    button: {
                    text: 'Choose Image'
                }, multiple: true });

                mediaUploaderE.on('select', function() {
                    var temp_img_str = '';
                    var attachments = mediaUploaderE.state().get('selection');
                    var i = 1;
                    
                    attachments.each(function(attachment) {
                            attachment = attachment.toJSON();
                            if ( i < 5 ) {
                                jQuery('#idgm_tweet-image'+i).val(attachment.url);
                                temp_img_str = temp_img_str + '<img src="'+attachment.url+'" style="width:50px;height:50px;object-fit: cover;object-position: center;float:left;margin:5px;cursor:not-allowed;" onclick="jQuery(\'#idgm_tweet-image'+i+'\').val(\'\');jQuery(this).hide();" />';
                            }
                            i++;
                    });

                    jQuery('#idgm-twitter-images').html(temp_img_str);
                });

                mediaUploaderE.open();
            });              
            
        });
        
  
})( jQuery );

function js_base64_decode (encodedData) { // eslint-disable-line camelcase
  //  discuss at: http://locutus.io/php/base64_decode/
  // original by: Tyler Akins (http://rumkin.com)
  // improved by: Thunder.m
  // improved by: Kevin van Zonneveld (http://kvz.io)
  // improved by: Kevin van Zonneveld (http://kvz.io)
  //    input by: Aman Gupta
  //    input by: Brett Zamir (http://brett-zamir.me)
  // bugfixed by: Onno Marsman (https://twitter.com/onnomarsman)
  // bugfixed by: Pellentesque Malesuada
  // bugfixed by: Kevin van Zonneveld (http://kvz.io)
  //   example 1: base64_decode('S2V2aW4gdmFuIFpvbm5ldmVsZA==')
  //   returns 1: 'Kevin van Zonneveld'
  //   example 2: base64_decode('YQ==')
  //   returns 2: 'a'
  //   example 3: base64_decode('4pyTIMOgIGxhIG1vZGU=')
  //   returns 3: '✓ à la mode'

  if (typeof window !== 'undefined') {
    if (typeof window.atob !== 'undefined') {
      return decodeURIComponent(escape(window.atob(encodedData)))
    }
  } else {
    return new Buffer(encodedData, 'base64').toString('utf-8')
  }

  var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/='
  var o1
  var o2
  var o3
  var h1
  var h2
  var h3
  var h4
  var bits
  var i = 0
  var ac = 0
  var dec = ''
  var tmpArr = []

  if (!encodedData) {
    return encodedData
  }

  encodedData += ''

  do {
    // unpack four hexets into three octets using index points in b64
    h1 = b64.indexOf(encodedData.charAt(i++))
    h2 = b64.indexOf(encodedData.charAt(i++))
    h3 = b64.indexOf(encodedData.charAt(i++))
    h4 = b64.indexOf(encodedData.charAt(i++))

    bits = h1 << 18 | h2 << 12 | h3 << 6 | h4

    o1 = bits >> 16 & 0xff
    o2 = bits >> 8 & 0xff
    o3 = bits & 0xff

    if (h3 === 64) {
      tmpArr[ac++] = String.fromCharCode(o1)
    } else if (h4 === 64) {
      tmpArr[ac++] = String.fromCharCode(o1, o2)
    } else {
      tmpArr[ac++] = String.fromCharCode(o1, o2, o3)
    }
  } while (i < encodedData.length)

  dec = tmpArr.join('')

  return decodeURIComponent(escape(dec.replace(/\0+$/, '')))
}

function idgmEditGame(game_array) {
    jQuery('#idgm_edit_game_list').hide('fold');
    jQuery('#idgm_add_game_dialog').hide('fold');
    jQuery('#idgm_edit_game_dialog').show('fold');
    jQuery('#idgm_add_game_button').hide('fold');
    
    var gameData = JSON.parse(js_base64_decode(game_array));

    jQuery('#idgm-edit-game-form-id').val(gameData.id);
    jQuery('#idgm-edit-game-form-name').val(gameData.name);
    jQuery('#idgm-edit-game-form-logo').val(gameData.logo);
    jQuery('#idgm-edit-game-form-icon').val(gameData.icon);
    jQuery('#idgm-edit-game-form-small-desc').val(gameData.small_desc);
    jQuery('#idgm-edit-game-form-long-desc').val(gameData.long_desc);
    jQuery('#idgm-edit-game-form-genres').val(gameData.genres);
    jQuery('#idgm-edit-game-form-multiplayer').val(gameData.multiplayer);
    jQuery('#idgm-edit-game-form-home-url').val(gameData.home_url);
    jQuery('#idgm-edit-game-form-greenlight-url').val(gameData.greenlight_url);
    jQuery('#idgm-edit-game-form-developers').val(gameData.developers);
    jQuery('#idgm-edit-game-form-publishers').val(gameData.publishers);
    jQuery('#idgm-edit-game-form-distributors').val(gameData.distributors);
    jQuery('#idgm-edit-game-form-producers').val(gameData.producers);
    jQuery('#idgm-edit-game-form-designers').val(gameData.designers);
    jQuery('#idgm-edit-game-form-programmers').val(gameData.programmers);
    jQuery('#idgm-edit-game-form-artists').val(gameData.artists);
    jQuery('#idgm-edit-game-form-writers').val(gameData.writers);
    jQuery('#idgm-edit-game-form-composers').val(gameData.composers);
    jQuery('#idgm-edit-game-engine').val(gameData.game_engine);
    jQuery('#idgm-edit-game-form-franchise-series').val(gameData.franchise_series);
    jQuery('#idgm-edit-game-form-platform-a').val(gameData.platform_a);
    jQuery('#idgm-edit-game-form-release-date-a').val(gameData.release_date_a);
    jQuery('#idgm-edit-game-form-platform-b').val(gameData.platform_b);
    jQuery('#idgm-edit-game-form-release-date-b').val(gameData.release_date_b);
    jQuery('#idgm-edit-game-form-platform-c').val(gameData.platform_c);
    jQuery('#idgm-edit-game-form-release-date-c').val(gameData.release_date_c);
    jQuery('#idgm-edit-game-form-platform-d').val(gameData.platform_d);
    jQuery('#idgm-edit-game-form-release-date-d').val(gameData.release_date_d);
    jQuery('#idgm-edit-game-form-platform-e').val(gameData.platform_e);
    jQuery('#idgm-edit-game-form-release-date-e').val(gameData.release_date_e);
    jQuery('#idgm-edit-game-form-platform-f').val(gameData.platform_f);
    jQuery('#idgm-edit-game-form-release-date-f').val(gameData.release_date_f);
    jQuery('#idgm-edit-game-form-platform-g').val(gameData.platform_g);
    jQuery('#idgm-edit-game-form-release-date-g').val(gameData.release_date_g);
    jQuery('#idgm-edit-game-form-platform-h').val(gameData.platform_h);
    jQuery('#idgm-edit-game-form-release-date-h').val(gameData.release_date_h);
    jQuery('#idgm-edit-game-form-platform-i').val(gameData.platform_i);
    jQuery('#idgm-edit-game-form-release-date-i').val(gameData.release_date_i);
    jQuery('#idgm-edit-game-form-platform-j').val(gameData.platform_j);
    jQuery('#idgm-edit-game-form-release-date-j').val(gameData.release_date_j);                
    jQuery('#idgm-edit-game-form-release-a-url').val(gameData.release_a_url);        
    jQuery('#idgm-edit-game-form-release-b-url').val(gameData.release_b_url);        
    jQuery('#idgm-edit-game-form-release-c-url').val(gameData.release_c_url);        
    jQuery('#idgm-edit-game-form-release-d-url').val(gameData.release_d_url);        
    jQuery('#idgm-edit-game-form-release-e-url').val(gameData.release_e_url);        
    jQuery('#idgm-edit-game-form-release-f-url').val(gameData.release_f_url);        
    jQuery('#idgm-edit-game-form-release-g-url').val(gameData.release_g_url);        
    jQuery('#idgm-edit-game-form-release-h-url').val(gameData.release_h_url);        
    jQuery('#idgm-edit-game-form-release-i-url').val(gameData.release_i_url);        
    jQuery('#idgm-edit-game-form-release-j-url').val(gameData.release_j_url);        
          
}


