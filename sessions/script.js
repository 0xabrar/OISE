$(document).ready() {
	
	//Register new user
	$("#btnSave").click(function() {
		var data = $("#addRunner :input").serializeArray();
		$.post($("#addRunner").attr("action"), data, function(json) {
			if (json.status == "success") {
				alert(json.message);
				clearInputs();
			}
		}, "json")
		.fail(function() {
			alert("Insert failed.");
		});
	});
}