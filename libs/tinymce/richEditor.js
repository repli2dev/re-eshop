/**
 * Create profile of tinymce - allow only some of html tags
 * @author Jan Drábek
 */
tinyMCE.init({
	mode : "textareas",
	theme : "advanced",
	plugins : "paste,xhtmlxtras,xhtml_helper,inlinepopups,table",
	theme_advanced_buttons1 : "undo,redo,|,pasteword,|,bold,italic,|,sub,sup,|,bullist,numlist,|,hr,|,link,unlink,|,formatselect,",
	theme_advanced_buttons2 : "table, delete_table,|,delete_col, delete_row,|, col_after, col_before, row_after, row_before,|, split_cells, merge_cells",
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
	cleanup_callback : "CustomCleanup",
	editor_selector : "richEditor",
	theme_advanced_blockformats : "p, pre, h3, h4, h5",
	valid_child_elements : "td/th/li[strong|i|b|em|sup|sub|a|#text]",
	valid_elements : ''
		+'a[href|title],'
		+'br,'
		+'em/i,'
		+'h3,'
		+'h4,'
		+'h5,'
		+'li,'
		+'ol,'
		+'pre,'
		+'strong/b,'
		+'ul,'
		+'sup,'
		+'table,'
		+'td[rowspan|colspan],'
		+'tr[rowspan|colspan],'
		+'th[rowspan|colspan],'
		+'sub,'
		+'hr,'
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
function CustomCleanup(type, content) {
		switch (type) {
			case "get_from_editor":
			content = content.replace(/<p><br \/><\/p>/,'');
			content = content.replace(/<p><table>/,'<table>');
			content = content.replace(/<\/table><\/p>/,'</table>');
			content = content.replace(/<ul><\/ul>/,'');
			content = content.replace(/<p><ul>/,'<ul>');
			content = content.replace(/<\/ul><\/p>/,'</ul>');
			break;
		case "insert_to_editor":
			content = content.replace(/<p><br \/><\/p>/,'');
			break;
	}
return content;
}
