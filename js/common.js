function validateForm(formObj) {
	var fields = formObj.serializeArray();
	for (var i = 0; i < fields.length; i++) {
		var f = fields[i];

		// 验证textarea
		var textarea = $("textarea[name='" + f.name + "']");
		if (textarea.attr("maxlength") < textarea.text().length) {
			alert(textarea.attr("desc") + "\u957f\u5ea6\u4e0d\u80fd\u5927\u4e8e" + textarea.attr("maxlength") + "！");
			textarea[0].focus();
			return false;
		}
		if (textarea.attr("validate") == "notNull" && $.trim(f.value) == "") {
			alert(textarea.attr("desc") + "\u4e0d\u80fd\u4e3a\u7a7a！");
			textarea[0].focus();
			return false;
		}

		// 验证select
		var select = $("select[name='" + f.name + "']");
		if (select.attr("validate") == "notNull" && $.trim(f.value) == "") {
			alert(select.attr("desc")+ "\u4e0d\u80fd\u4e3a\u7a7a！");
			select[0].focus();
			return false;
		}

		// 验证input
		var input = $("input[name='" + f.name + "']");
		if (!input.attr("validate")) continue;
		var v = input.attr("validate").split(",");
		for (var j = 0; j < v.length; j++) {
			if (v[j] == "notNull" && $.trim(f.value) == "") {
				alert(input.attr("desc") + "\u4e0d\u80fd\u4e3a\u7a7a！");
				input[0].focus();
				return false;
			}
			if ($.trim(f.value) == "") break;

			if (v[j] == "number" && !/^\d+$/.test(f.value)) {
				alert(input.attr("desc") + "\u5fc5\u987b\u4e3a\u6574\u6570！");
				input[0].focus();
				return false;
			}
			else if (v[j] == "double" && !/^\d+((\.?\d+)|(\d*))$/.test(f.value)) {
				alert(input.attr("desc") + "\u5fc5\u987b\u4e3a\u6570\u5b57！");
				input[0].focus();
				return false;
			}
			else if (v[j] == "date" && !/^\d{4}\-\d{2}\-\d{2}$/.test(f.value)) {
				alert(input.attr("desc") + "\u5fc5\u987b\u4e3a\u683c\u5f0fyyyy-MM-dd,\u59822012-12-01！");
				input[0].focus();
				return false;
			}
		}
	}
	return true;
}