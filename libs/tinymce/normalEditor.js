/**
 * Create profile of tinymce - allow only some of html tags
 * @author Jan Drábek
 */
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "paste,xhtmlxtras,xhtml_helper,inlinepopups",
	theme_advanced_buttons1 : "undo,redo,|,pasteword,|,bold,italic,|,sub,sup,|,bullist,numlist,|,link,unlink",
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
	paste_insert_word_content_callback : 'cleaning',
	editor_selector : "normalEditor",
	valid_child_elements : "li[strong|i|b|em|sup|sub|a|#text]",
	valid_elements : ''
		+'a[href|title],'
		+'br,'
		+'em/i,'
		+'li,'
		+'ol,'
		+'pre,'
		+'strong/b,'
		+'ul,'
		+'sup,'
		+'sub,'
		+'p,'
		+'-p,'
});
function cleaning(type,content){
	if (type == "after") {
		content = content.replace(/<!--/gi, '');
		content = content.replace(/-->/gi, '');
	}
	return content;
}
function CustomCleanup(type, content){
	switch (type) {
		case "get_from_editor":
			content = content.replace(/<p><br \/><\/p>/, '');
			break;
		case "insert_to_editor":
			content = content.replace(/<p><br \/><\/p>/, '');
			break;
	}
}