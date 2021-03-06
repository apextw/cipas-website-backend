jQuery(document).ready(function() {
	rules = {
		rule_title: {
			required: true
		},
		rule_show_date: {
			required: true
		},
		rule_content: {
			required: function() {
				CKEDITOR.instances.content.updateElement();
			}
		},
		rule_meta_description: {
			maxlength: 30
		}
	};

	messages = {
		rule_title:'標題不能為空值',
		rule_show_date:'發佈日期不能為空值',
		rule_content:'內文不能為空值',
		rule_meta_description:'說明分享不能超過30字',
	};

    FormValidation.init(rules, messages);
    uploadFile.applyAjaxFileUpload('#tmp_file');
});
var addFileNumber = $('#file_tbody').children().length;

// 新增附件 Abby
function addFile(){

	fileTemplate = $('#fileTemplate').html();
	addFileNumber++;
	$('#file_tbody').append(fileTemplate);
	$("#file_tbody #fileRow").attr("id","fileRow_"+addFileNumber);
	$("#file_tbody #fileRow_"+addFileNumber+" #delFile").attr("onclick","delFileRow("+addFileNumber+")");
	uploadFile.applyAjaxFileUpload('#fileRow_'+addFileNumber+' #tmp_file');

}
// 刪除附件
function delFileRow(addFileNumber){
	$('#fileRow_'+addFileNumber).remove();
}