(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */


	 $(function() {
/*Function to count the number of results found in data source cration page.
*/
function get_post_count_ajax(){
		var post_type = $('select#wpnlc_feed_datasource').val();
		 var categories = $('select#wpnlc_feed_category').val();
		 var feed_type = $('select#wpnlc_feed_type').val();
		 var excludes = $('select#wpnlc_feed_excludes').val();
		 var feed_start_date = $('#wpnlc_feed_start_date').val();
		 var feed_end_date = $('#wpnlc_feed_end_date').val();
		 var feed_event_venue = $('#wpnlc_feed_event_venue').val(); 
		 var count = $('#wpnlc_feed_number').val();
		 if(post_type == ''){
			 return; 
			 }
		 var data = {
							'action': 'wpnlc_found_post_count',
							'dataType': "json",
							'post_type': post_type,
							'categories': categories,
							'feed_type': feed_type,
							'excludes': excludes,
							'feed_start_date':feed_start_date,
							'feed_end_date':feed_end_date,
							'feed_event_venue':feed_event_venue,
							'count':(count)?count:-1,
						};
			$('#loading_progress').show();
			jQuery.post(ajaxurl, data, function (response) {
				response = jQuery.parseJSON(response);
				$('p.post_count').html(response+' '+$('select#wpnlc_feed_datasource :selected').text()+' Found');
				
			}).done(function(){
					$('#loading_progress').hide();
				});
			
			}
/*
Fired when page loads to count the number of post found (needed when data source is opened for editing)
*/
if($('p.post_count').length){
	get_post_count_ajax();
}

/*
Trigger the post count when input is changed for datasource
*/
$('#wpnlc_feed_datasource, #wpnlc_feed_category, #wpnlc_feed_type, #wpnlc_feed_start_date, #wpnlc_feed_end_date, #wpnlc_feed_event_venue, #wpnlc_feed_excludes, #wpnlc_feed_number').live('change',function(){
	get_post_count_ajax();
	});			

/*Newsletter custom post metabox related scripts */

//Exclude and Include input fields are converted to chosen select inputs
$('#wpnlc_feed_includes').chosen({
					no_results_text: "Oops, nothing found!",
					width: "50%",
					placeholder_text_multiple: 'Start typing here..',
					});
$('#wpnlc_feed_excludes').chosen({
					no_results_text: "Oops, nothing found!",
					width: "50%",
					placeholder_text_multiple: 'Start typing here..',
					});

//Function to get list of posts matching the enterd string in includes text area					
$('#wpnlc_feed_includes_chosen input').live('keyup',function(){
	if($(this).val() == ''){
		return false;
		}
				var items="";
				var data = {
							'action': 'search_post_ajax',
							'dataType': "json",
							'search_title': $(this).val(),
							'post_type':$('select#wpnlc_feed_datasource').val(),
							'categories':$('select#wpnlc_feed_category').val(),
							'type':$('select#wpnlc_feed_type').val(),
							//'count':5
						};
			var options = $("#wpnlc_feed_includes option:selected");
			var selected = $("#wpnlc_feed_includes").chosen().val();
			jQuery.post(ajaxurl, data, function (response) {
				response = jQuery.parseJSON(response);
				if(response.length){
					$('#wpnlc_feed_includes').html(''); 

					$(response).each(function(index,element){ 
					if($.inArray(element['pid'],selected)!='-1'){
						}else{
						if ($("#wpnlc_feed_excludes option[value="+this.pid+"]:selected").length > 0){
							$('#wpnlc_feed_includes').append('<option value="'+element['pid']+'" disabled="disabled">'+element['title']+'</option>');
							$("#wpnlc_feed_includes").trigger('chosen:updated'); 
							}else{
								$('#wpnlc_feed_includes').append('<option value="'+this.pid+'">'+this.title+'</option>');
								}
						}
						}); 
					
				$(options).each(function(index, element) {
					$('#wpnlc_feed_includes').append('<option value="'+element.value+'" selected="selected">'+element.text+'</option>');
                });
					$("#wpnlc_feed_includes").trigger('chosen:updated'); 
				}
			});			
						
		});
		
//Function to get list of posts matching the enterd string in excludes text area					
$('#wpnlc_feed_excludes_chosen input').live('keyup',function(){
	if($(this).val() == ''){
		return false;
		}
				var items="";
				var data = {
							'action': 'search_post_ajax',
							'dataType': "json",
							'search_title': $(this).val(),
							'post_type':$('select#wpnlc_feed_datasource').val(),
							'categories':$('select#wpnlc_feed_category').val(),
							'type':$('select#wpnlc_feed_type').val(),

						};
			var options = $("#wpnlc_feed_excludes option:selected");
			var selected = $("#wpnlc_feed_excludes").chosen().val();
			jQuery.post(ajaxurl, data, function (response) {
				response = jQuery.parseJSON(response);
				if(response.length){
					$('#wpnlc_feed_excludes').html(''); 
					$(response).each(function(index,element){ 
					if($.inArray(element['pid'],selected)!='-1'){
						}else{
						if ($("#wpnlc_feed_includes option[value="+this.pid+"]:selected").length > 0){
							$('#wpnlc_feed_excludes').append('<option value="'+element['pid']+'" disabled="disabled">'+element['title']+'</option>');
							$("#wpnlc_feed_excludes").trigger('chosen:updated'); 
							}else{
								$('#wpnlc_feed_excludes').append('<option value="'+this.pid+'">'+this.title+'</option>');
								}
						}
						}); 
					
				$(options).each(function(index, element) {
					$('#wpnlc_feed_excludes').append('<option value="'+element.value+'" selected="selected">'+element.text+'</option>');
                });
				
					$("#wpnlc_feed_excludes").trigger('chosen:updated'); 
				
			}
			
			});			
						
		});
		
		
//Hero post selection field converted to chosen select input and ajax call for getting posts matching the string entered in hero post input field
if(($(document).find('#wpnlc_hero_post').length) > 0){
	jQuery('#wpnlc_hero_post').chosen({
		no_results_text: "Oops, nothing found!",
		width: "50%",
		allow_single_deselect: true
	});
	$('#wpnlc_hero_post_chosen input').live('keyup',function(){
		var items="";
		var data = {
			'action': 'search_post_ajax',
			'dataType': "json",
			'search_title': $(this).val(),
			'post_type':$('select#wpnlc_feed_datasource').val(),
			'categories':$('select#wpnlc_feed_category').val(),
			'type':$('select#wpnlc_feed_type').val(),
		};
		jQuery.post(ajaxurl, data, function (response) {
			response = jQuery.parseJSON(response);
			if(response.length){
				$('#wpnlc_hero_post').html(''); 
				$('#wpnlc_hero_post').append('<option value=""></option>');
				$(response).each(function(){ 
					$('#wpnlc_hero_post').append('<option value="'+this.pid+'">'+this.title+'</option>'); 
				}); 
				$("#wpnlc_hero_post").trigger('chosen:updated'); 
			}
		});			
	
	});
}
	
		if($('#wpnlc_feed_category').length){
			$('#wpnlc_feed_category').chosen({width:'50%',placeholder_text_multiple: 'Start typing here..'});
		}
		$('#wpnlc_feed_datasource').live('change',function(){
			
			$('#loading_progress').show();			
			if($(this).val() == 'include_ids' || ($(this).val()=='')){
				$('tr.feed_excludes, tr.feed_orderby, tr.feed_order, tr.feed_type, tr.feed_number, tr.feed_category').hide();
				$('tr.feed_includes').show();
				$('select#wpnlc_feed_includes').attr('required','required');
				}else{
				$('tr.feed_excludes, tr.feed_orderby, tr.feed_order, tr.feed_type, tr.feed_number').show();
				$('tr.feed_includes').hide();
				$('select#wpnlc_feed_includes').removeAttr('required');
				$('tr.feed_category').show();
						var data = {
							'action': 'wpnlc_get_datasource_categories',
							'dataType': "json",
							'post_type': $(this).val(),
						};
			jQuery.post(ajaxurl, data, function (response) {
			response = jQuery.parseJSON(response);
			if(response.length){
				$(document).find('tr.feed_category select#wpnlc_feed_category').remove();
				if($('#wpnlc_feed_category_chosen').length){
					$(document).find('#wpnlc_feed_category_chosen').remove();
				}
				$(document).find('tr.feed_category label').append(response);
				$('#wpnlc_feed_category').chosen({width:'50%',placeholder_text_multiple: 'Start typing here..'});
				}
			});

}
			var data = {
							'action': 'wpnlc_get_feed_types',
							'dataType': "json",
							'post_type': $(this).val(),
						};
			jQuery.post(ajaxurl, data, function (response) {
			response = jQuery.parseJSON(response);
			if(response.length){
				$(document).find('tr.feed_type select#wpnlc_feed_type').remove();
				$(document).find('tr.feed_type label').append(response);
				}
			}).done(function(){
				
			$('#loading_progress').hide();
				});
			$('tr.feed_start_date, tr.feed_end_date, tr.feed_venue').hide();	
			});
			
		$('#wpnlc_feed_type').live('change',function(){
			
		 if($(this).val()=='upcomming'){
			 $('tr.feed_end_date, tr.feed_start_date').show();
			 $('input#wpnlc_feed_start_date, input#wpnlc_feed_end_date').attr('required','required');
			 }else{
				$('tr.feed_end_date, tr.feed_start_date').hide();
				$('input#wpnlc_feed_start_date, input#wpnlc_feed_end_date').removeAttr('required');
				 }
		if($(this).val()=='location')
		{
			 $('tr.feed_venue').show();
			 $('select#wpnlc_feed_event_venue').attr('required','required');
			}else{
				$('tr.feed_venue').hide();
			 $('select#wpnlc_feed_event_venue').removeAttr('required');
			}
		 });
		 
		$('#wpnlc_feed_text_limit').live('change',function(){
		 if($(this).val()=='excerpt'){
			 $('tr.feed_excerpt_length').show();
			 $('input#wpnlc_feed_excerpt_length').attr('required','required');
			 }else{
				$('tr.feed_excerpt_length').hide();
				$('input#wpnlc_feed_excerpt_length').removeAttr('required');
				 }
		 });
		$('input[name="wpnlc_feed_date_format"]').live('change',function(){
		 if($(this).val()=='custom'){
			 $('input.feed_custom_dateformat').show().focus().attr('required','required');
			 }else{
				$('input.feed_custom_dateformat').hide().removeAttr('required');
				 }
		 });
		 /*Newsletter custom post metabox related scripts end */

/*Newsletter Generator Setting page related scripts */
				if($('#wpnlc_code_editor_normal').length ){
						var myCodeMirrorGeneratorNormal = CodeMirror.fromTextArea(wpnlc_code_editor_normal, {value: wpnlc_code_editor_normal.value,
						mode:"htmlmixed",
						theme:"seti",
						lineNumbers:true,
						});
						myCodeMirrorGeneratorNormal.setSize({width: '375px', height: 'auto'});
						myCodeMirrorGeneratorNormal.on('change',function(cm,obj){
						jQuery('textarea#wpnlc_code_editor_normal').val(cm.getValue());
						});
					}
				if($('#wpnlc_code_editor_rss').length ){
						var myCodeMirrorGeneratorRss = CodeMirror.fromTextArea(wpnlc_code_editor_rss, {value: wpnlc_code_editor_rss.value,
						mode:"htmlmixed",
						theme:"seti",
						lineNumbers:true,
						});
						myCodeMirrorGeneratorRss.setSize({width: '375px', height: 'auto'});
					}
					
				if($('#wpnlc_template_code_normal').length ){
					var myCodeMirrorTemplateNormal = CodeMirror.fromTextArea(wpnlc_template_code_normal, {value: wpnlc_template_code_normal.value,
					mode:"htmlmixed",
					theme:"seti",
					lineNumbers:true,
					});
					myCodeMirrorTemplateNormal.setSize({width: '750px', height: 'auto'});
					myCodeMirrorTemplateNormal.on('change',function(cm,obj){
						jQuery('textarea#wpnlc_template_code_normal').val(cm.getValue());
						});
			}	
				if($('#wpnlc_template_code_rss').length ){
					var myCodeMirrorTemplateRss = CodeMirror.fromTextArea(wpnlc_template_code_rss, {value: wpnlc_template_code_rss.value,
					mode:"htmlmixed",
					theme:"seti",
					lineNumbers:true,
					});
					myCodeMirrorTemplateRss.setSize({width: '750px', height: 'auto'});
					myCodeMirrorTemplateRss.on('change',function(cm,obj){
						jQuery('textarea#wpnlc_template_code_rss').val(cm.getValue());
						});
			}	
					
		$('#wpnlc_template_html_preview_tabs li.tabs_control').on('click',function(){
			var sel_tab = $(this).find('a').attr('tab');
			$('#wpnlc_template_html_preview_tabs li.tabs_control').removeClass('active');
			$(this).addClass('active');
			$('.tab_content_wrap .wpnlc_tab').hide();
			$('.tab_content_wrap div#'+sel_tab).show();
			if($('iframe#newsletter_generator_iframe').length){
				var html = $('textarea#wpnlc_code_editor_normal').val();
				var iframe = document.getElementById('newsletter_generator_iframe');
				iframe.contentWindow.document.open();
				iframe.contentWindow.document.write(html);
				iframe.contentWindow.document.close();
			}
			myCodeMirrorGeneratorRss.refresh();
			myCodeMirrorGeneratorNormal.refresh();
			});
			
		$('.html_n_preview li.tabs_control').on('click',function(){
			var sel_tab = $(this).find('a').attr('tab');
			$('.html_n_preview li.tabs_control').removeClass('active');
			$(this).addClass('active');
			$('.html_n_preview_tabs .wpnlc_template_tabs').hide();
			$('.html_n_preview_tabs div#'+sel_tab).show();
			var html = $('textarea#wpnlc_template_code_normal').val();
			var iframe = document.getElementById('template_preview');
			iframe.contentWindow.document.open();
			iframe.contentWindow.document.write(html);
			iframe.contentWindow.document.close();
			});
			
		$('#wpnlc_template_create_n_update_tabs li.tabs_control').on('click',function(){
			var sel_tab = $(this).find('a').attr('tab');
			$('#wpnlc_template_create_n_update_tabs li.tabs_control').removeClass('active');
			$(this).addClass('active');
			if(sel_tab == 'template_update_select'){
			$('.template_update_select').show();
			$('td.template_create span.template_update').show();
			$('td.template_create span.template_create').hide();
			$('tr.template_update_select select#wpnlc_setting_template_name_update').attr('required','required');
			}else{
			$('.template_update_select').hide();
			$('td.template_create span.template_update').hide();
			$('td.template_create span.template_create').show();

			$('tr.template_update_select select#wpnlc_setting_template_name_update').removeAttr('required');
				}
			});
		
		$('select#wpnlc_setting_template_name_update').live('change',function(){
			var template = $(this).val();
			if(template !=''){
				var template_name = $(this).find("option:selected").text();
				$('input#wpnlc_setting_template_name').val(template_name);
				$('input#wpnlc_update_newsletter_btn').attr('template_id',template);
				
				}
			
			});

		/*
		
		$('#wpnlc_setting_template_type').live('change',function(){
			$('#loading_progress').show();
			if($(this).val() == 'rss'){
				$('#wpnlc_setting_feed').removeAttr('required');
				}else{
				$('#wpnlc_setting_feed').attr('required','required');
					}
			 var data = {
							'action' : 'get_templates_by_type',
							'dataType' : "json",
							'template_type' : $(this).val(),
						};
			$.post(ajaxurl, data, function (response) {
				response = jQuery.parseJSON(response);
				if(response !=""){
					$('ul.template_selection_list').html(response);
					$('#selected_template').attr('template_id','');
					$('#template_preview').html('');
					$('textarea#wpnlc_code_editor').val('');
					$('select#wpnlc_setting_feed').val('');
					myCodeMirror.setValue('');
				}
				
				}).done(function(){
					$('#loading_progress').hide();
					$('tr.wpnlc_setting_template').show();
					});
		 });
		
		 */
		 $('form#wpnlc_generate_newsletter_form').on('submit',function(e){
			 e.preventDefault();
			 $('#loading_progress').show();	
			 var template = $('#selected_template').attr('template_id');
			 if(!template){
					$('#loading_progress').hide();
				 alert('Please Select Template');
					$('html, body').animate({
						scrollTop: $("tr.wpnlc_setting_template").offset().top
					}, 1000);
					
					return false;
				 }		
			 var $btn = $(document.activeElement);
			if ($btn.length && $(this).has($btn) && $btn.is('button[type="submit"], input[type="submit"]') && $btn.is('[name]'))
			{
		  		var data = {
							'action' : 'wpncl_generate_campaigns',
							'dataType' : "json",
							'template_type' : $('select#wpnlc_setting_template_type').val(),
							'template' : template,
							'feed_id' : $('select#wpnlc_setting_feed').val(),
							'template_name': $('input#wpnlc_setting_template_name').val(),
						};	
			
			if($btn.attr('id') == 'wpnlc_update_newsletter_btn'){
				var wpnlc_mctid = $btn.attr('template_id');
				 data["wpnlc_mctid"] = wpnlc_mctid;  
			}else if($btn.attr('id') == 'wpnlc_preview_newsletter_btn'){
				data["wpncl_preview"] = 'yes';
				}else if($btn.attr('id') == 'wpnlc_generate_newsletter_btn'){
					if($('input#wpnlc_setting_template_name').val() == ""){
					alert('Please Enter Template Name');
					$('#loading_progress').hide();	
					$('input#wpnlc_setting_template_name').focus().attr('placeholder','Please Enter Template Name');
					return false;
					}
					}
		jQuery.post(ajaxurl, data, function (response) {
			response = jQuery.parseJSON(response);
			if(response){
				if($btn.attr('id') == 'wpnlc_preview_newsletter_btn'){
					
					var stt = $('select#wpnlc_setting_template_type').val();
					if(stt=='normal'){
						myCodeMirrorGeneratorNormal.getDoc().setValue(response);
						myCodeMirrorGeneratorNormal.refresh();

						var iframe = document.createElement("iframe");
						iframe.style.height = '100%';
						iframe.style.width = '100%';
						iframe.style.maxWidth = '1250px';
						iframe.style.minHeight = '850px';
						iframe.setAttribute('id','newsletter_generator_iframe');
						$(document).find('div.newsletter_preview_container').html('').append(iframe);
						var doc = iframe.document;
						if(iframe.contentDocument)
							doc = iframe.contentDocument; // For NS6
						else if(iframe.contentWindow)
							doc = iframe.contentWindow.document; // For IE5.5 and IE6
						// Put the content in the iframe
						doc.open();
						doc.writeln(response);
						doc.close();

					}else if (stt=='rss'){
						myCodeMirrorGeneratorRss.getDoc().setValue(response);
						myCodeMirrorGeneratorRss.refresh();	
						}
					}else{
				$('.settings-error').html(response.message).focus();
					}
				}
			
			}).done(function(){
					$('#loading_progress').hide();
					});
		}
			 });
		 /*Newsletter Generator Setting page related scripts */
		 
	/*Wp Newsletter Settings page scripts*/
	$('#wpnlc_settings_save').on('click',function(){
		var apikey = $('input#wpnlc_mailchimp_api_key').val();
		var valid_datasources = $().val();
		var valid_datasources = $('input[name="wpnlc_valid_datasources[]"]:checked').map(function(){
																						 return $(this).val();
																						}).get();
		if(apikey == ''){
			$('#message').html('<p> Please enter your mailchimp apikey </p>').addClass('updated notice notice-success is-dismissible');
			return false;
			}else{
			$('#loading_progress').show();			
			 var data = {
							'action' : 'wpnlc_save_settings',
							'dataType' : "json",
							'apikey' : apikey,
							'valid_datasources':valid_datasources,
						};
		$.post(ajaxurl, data, function (response) {
			response = jQuery.parseJSON(response);
			
			
			}).done(function(){
					$('#loading_progress').hide();
					location.reload();
					});
	
			}
		
	});
$('li.select_template_thumb').live('click',function(){
	$('li.select_template_thumb').removeClass('active');
	$(this).addClass('active');
	var template = $(this).attr('tid');
	$('#selected_template').attr('template_id',template);
	});
	  });

})( jQuery );
