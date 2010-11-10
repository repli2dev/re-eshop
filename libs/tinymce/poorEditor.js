/**
 * Create profile of tinymce - only base html tags are allowed
 * @author Jan Drábek
 */
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "paste,xhtmlxtras,xhtml_helper,inlinepopups",
	theme_advanced_buttons1 : "undo,redo,|,bold,italic,|,sub,sup,|,link,unlink",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	cleanup : true,
	paste_auto_cleanup_on_paste : true,
	paste_strip_class_attributes : "all",
	paste_remove_spans : true,
	paste_remove_styles : true,
	entity_encoding : "raw",
	verify_html : true,
	convert_urls : false,
	editor_selector : "poorEditor",
	valid_elements : ''
		+'a[href|title],'
		+'em/i,'
		+'strong/b,'
		+'sup,'
		+'sub,'
});
